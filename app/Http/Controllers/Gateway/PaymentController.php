<?php

namespace App\Http\Controllers\Gateway;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller {
    public function deposit() {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Deposit Methods';
        $amount    = null;
        session()->forget('coin_amount');
        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'pageTitle', 'amount'));
    }

    public function payment() {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->with('method')->orderby('method_code')->get();
        $pageTitle  = 'Deposit Methods';
        $amount     = null;
        $coinAmount = session()->get('coin_amount');

        if (!$coinAmount) {
            $notify[] = ['error', 'Session invalidate'];
            return to_route('user.home')->withNotify($notify);
        }
        $amount = $coinAmount['price'];
        
        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'pageTitle', 'amount'));
    }

    public function depositInsert(Request $request) {
        $coinAmount     = session()->get('coin_amount');
        $amountValidate = $coinAmount ? 'nullable' : 'required';

        $request->validate([
            'amount'      => "$amountValidate|numeric|gt:0",
            'method_code' => 'required',
            'currency'    => 'required',
        ]);

        $user = auth()->user();
        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();

        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        $amount = $coinAmount ? $coinAmount['price'] : $request->amount;

        if ($gate->min_amount > $amount || $gate->max_amount < $amount) {
            $notify[] = ['error', 'Please follow deposit limit'];
            return back()->withNotify($notify);
        }

        $data = new Deposit();

        if ($coinAmount) {
            $data->coin_amount = $coinAmount['coin'];
            session()->forget('coin_amount');
        }
        $charge    = $gate->fixed_charge + ($amount * $gate->percent_charge / 100);
        $payable   = $amount + $charge;
        $final_amo = $payable * $gate->rate;

        $data->user_id         = $user->id;
        $data->method_code     = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount          = $amount;
        $data->charge          = $charge;
        $data->rate            = $gate->rate;
        $data->final_amo       = $final_amo;
        $data->btc_amo         = 0;
        $data->btc_wallet      = "";
        $data->trx             = getTrx();
        $data->save();
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }

    public function appDepositConfirm($hash) {
        try {
            $id = decrypt($hash);
        } catch (\Exception$ex) {
            return "Sorry, invalid URL.";
        }

        $data = Deposit::where('id', $id)->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'DESC')->firstOrFail();
        $user = User::findOrFail($data->user_id);
        auth()->login($user);
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }

    public function depositConfirm() {
        $track = session()->get('Track');

        $deposit  = Deposit::where('trx', $track)->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();
        $purchase = $deposit->purchase;

        if ($deposit->method_code >= 1000) {
            return to_route('user.deposit.manual.confirm');
        }

        $dirName = $deposit->gateway->alias;
        $new     = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);

        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }

        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

// for Stripe V3
        if (@$data->session) {
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Payment Confirm';
        return view($this->activeTemplate . $data->view, compact('data', 'pageTitle', 'deposit'));
    }

    public static function userDataUpdate($deposit, $isManual = null) {

        if ($deposit->status == Status::PAYMENT_INITIATE || $deposit->status == Status::PAYMENT_PENDING) {
            $deposit->status = Status::PAYMENT_SUCCESS;
            $deposit->save();

            $user = User::find($deposit->user_id);
            $user->balance += $deposit->amount;
            $user->save();

            $transaction               = new Transaction();
            $transaction->user_id      = $deposit->user_id;
            $transaction->amount       = $deposit->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge       = $deposit->charge;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Deposit Via ' . $deposit->gatewayCurrency()->name;
            $transaction->trx          = $deposit->trx;
            $transaction->remark       = 'deposit';
            $transaction->save();

            if (!$isManual) {
                $adminNotification            = new AdminNotification();
                $adminNotification->user_id   = $user->id;
                $adminNotification->title     = 'Deposit successful via ' . $deposit->gatewayCurrency()->name;
                $adminNotification->click_url = urlPath('admin.deposit.successful');
                $adminNotification->save();
            }

            notify($user, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
                'method_name'     => $deposit->gatewayCurrency()->name,
                'method_currency' => $deposit->method_currency,
                'method_amount'   => showAmount($deposit->final_amo),
                'amount'          => showAmount($deposit->amount),
                'charge'          => showAmount($deposit->charge),
                'rate'            => showAmount($deposit->rate),
                'trx'             => $deposit->trx,
                'post_balance'    => showAmount($user->balance),
            ]);

            $general = gs();

            if ($general->deposit_referral == 1 && $user->ref_by) {

                if ($general->bonus_type == 1) {
                    $depositBonus = $general->deposit_bonus;
                } else {
                    $depositBonus = ($deposit->amount * $general->deposit_bonus) / 100;
                }

                $referBy = User::active()->find($user->ref_by);
                if ($referBy) {
                    $detail = 'You have got deposit referral bonus.';
                    referralBonus($referBy, $depositBonus, $detail);
                }
            }

            if ($deposit->coin_amount != 0) {
                $user->balance -= getAmount($deposit->amount);
                $user->coin += $deposit->coin_amount;
                $user->save();

                $transaction               = new Transaction();
                $transaction->user_id      = $user->id;
                $transaction->amount       = getAmount($deposit->amount);
                $transaction->charge       = 0;
                $transaction->post_balance = getAmount($user->balance);
                $transaction->trx_type     = '-';
                $transaction->trx          = $deposit->trx;
                $transaction->remark       = 'payment';
                $transaction->details      = showAmount($deposit->amount) . ' ' . $general->cur_text . ' subtract for coin purchased';
                $transaction->save();

                $transaction               = new Transaction();
                $transaction->user_id      = $user->id;
                $transaction->coin_status  = 1;
                $transaction->amount       = getAmount($deposit->coin_amount);
                $transaction->charge       = 0;
                $transaction->post_balance = getAmount($user->coin);
                $transaction->trx_type     = '+';
                $transaction->trx          = $deposit->trx;
                $transaction->remark       = 'purchase';
                $transaction->details      = 'You have purchased ' . showAmount($deposit->coin_amount) . ' ' . $general->coin_code;
                $transaction->save();

                notify($user, 'PURCHASE_COMPLETED', [
                    'user_name'     => $user->username,
                    'method_name'   => 'User balance',
                    'amount'        => getAmount($deposit->coin_amount),
                    'charge'        => getAmount($deposit->charge),
                    'paid_amount'   => showAmount($deposit->amount),
                    'post_balance'  => showAmount($user->balance),
                    'coin'          => showAmount($user->coin),
                    'site_currency' => $general->cur_text,
                    'coin_code'     => $general->coin_code,
                    'trx'           => $deposit->trx,
                ]);
            }

        }

    }

    public function manualDepositConfirm() {
        $track = session()->get('Track');
        $data  = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();

        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }

        if ($data->method_code > 999) {

            $pageTitle = 'Deposit Confirm';
            $method    = $data->gatewayCurrency();
            $gateway   = $method->method;
            return view($this->activeTemplate . 'user.payment.manual', compact('data', 'pageTitle', 'method', 'gateway'));
        }

        abort(404);
    }

    public function manualDepositUpdate(Request $request) {
        $track = session()->get('Track');
        $data  = Deposit::with('gateway')->where('status', Status::PAYMENT_INITIATE)->where('trx', $track)->first();

        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }

        $gatewayCurrency = $data->gatewayCurrency();
        $gateway         = $gatewayCurrency->method;
        $formData        = $gateway->form->form_data;

        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);

        $data->detail = $userData;
        $data->status = Status::PAYMENT_PENDING;
        $data->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $data->user->id;
        $adminNotification->title     = 'Deposit request from ' . $data->user->username;
        $adminNotification->click_url = urlPath('admin.deposit.details', $data->id);
        $adminNotification->save();

        notify($data->user, 'DEPOSIT_REQUEST', [
            'method_name'     => $data->gatewayCurrency()->name,
            'method_currency' => $data->method_currency,
            'method_amount'   => showAmount($data->final_amo),
            'amount'          => showAmount($data->amount),
            'charge'          => showAmount($data->charge),
            'rate'            => showAmount($data->rate),
            'trx'             => $data->trx,
        ]);
        $notification = 'You have deposit request has been taken';

        if ($data->coin_amount != 0) {
            $general = gs();
            notify($data->user, 'PURCHASE_PENDING', [
                'user_name'     => $data->user->username,
                'method_name'   => 'User balance',
                'amount'        => getAmount($data->coin_amount),
                'charge'        => getAmount($data->charge),
                'paid_amount'   => showAmount($data->user->amount),
                'post_balance'  => showAmount($data->user->balance),
                'coin'          => showAmount($data->user->coin),
                'site_currency' => $general->cur_text,
                'coin_code'     => $general->coin_code,
                'trx'           => $data->trx,
            ]);
            $notification = 'Your coin request has been taken';
            session()->forget('coin_amount');
        }

        $notify[] = ['success', $notification];
        return to_route('user.deposit.history')->withNotify($notify);
    }

}
