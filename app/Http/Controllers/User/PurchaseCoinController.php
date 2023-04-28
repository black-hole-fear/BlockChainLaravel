<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PurchaseCoinController extends Controller {
    public function purchaseCoin() {
        $pageTitle = 'Purchase Coin';
        return view($this->activeTemplate . 'user.purchase.coin', compact('pageTitle'));
    }

    public function purchaseConfirm(Request $request) {

        $request->validate([
            'amount'         => 'required|numeric|gt:0',
            'payment_status' => 'required|integer|in:1,2',
        ]);

        $general   = gs();
        $basePrice = $general->coin_rate / $general->cur_rate;
        $payAmount = getAmount($request->amount * $basePrice, 2);

        if ($request->payment_status == 2) {
            session()->put('coin_amount', [
                'coin'  => $request->amount,
                'price' => $payAmount,
            ]);
            return to_route('user.payment');
        }

        $user = auth()->user();

        if ($payAmount > $user->balance) {
            $notify[] = ['error', 'Insufficient balance in your account'];
            return back()->withNotify($notify);
        }

        $user->balance -= getAmount($payAmount);
        $user->coin += $request->amount;
        $user->save();

        $trx = getTrx();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = getAmount($payAmount);
        $transaction->charge       = 0;
        $transaction->post_balance = getAmount($user->balance);
        $transaction->trx_type     = '-';
        $transaction->trx          = $trx;
        $transaction->remark       = 'purchase';
        $transaction->details      = $payAmount . ' ' . $general->cur_text . ' subtract for coin purchased';
        $transaction->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->coin_status  = 1;
        $transaction->amount       = getAmount($request->amount);
        $transaction->charge       = 0;
        $transaction->post_balance = getAmount($user->coin);
        $transaction->trx_type     = '+';
        $transaction->trx          = $trx;
        $transaction->remark       = 'purchase';
        $transaction->details      = 'You have purchased ' . showAmount($request->amount) . ' ' . $general->coin_code;
        $transaction->save();

        notify($user, 'PURCHASE_COMPLETED', [
            'user_name'     => $user->username,
            'method_name'   => 'User balance',
            'amount'        => getAmount($request->amount),
            'charge'        => getAmount(0),
            'paid_amount'   => showAmount($payAmount),
            'post_balance'  => showAmount($user->balance),
            'coin'          => showAmount($user->coin),
            'site_currency' => $general->cur_text,
            'coin_code'     => $general->coin_code,
            'trx'           => $trx,
        ]);

        $notify[] = ['success', 'Coin purchased successfully'];
        return back()->withNotify($notify);
    }

}
