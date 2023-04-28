<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Lib\GoogleAuthenticator;
use App\Models\CoinRate;
use App\Models\Deposit;
use App\Models\Form;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function home() {
        $pageTitle = 'Dashboard';
        $userId    = auth()->id();

        $user['balance']            = auth()->user()->balance;
        $user['coin']               = auth()->user()->coin;
        $data['total_deposited']    = Deposit::where('user_id', $userId)->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
        $data['pending_deposited']  = Deposit::where('user_id', $userId)->where('status', Status::PAYMENT_PENDING)->sum('amount');
        $data['rejected_deposited'] = Deposit::where('user_id', $userId)->where('status', Status::PAYMENT_REJECT)->sum('amount');
        $data['total_purchased']    = Transaction::where('coin_status', 1)->where('user_id', $userId)->where('remark', 'purchase')->sum('amount');
        $data['total_transferred']  = Transaction::where('coin_status', 1)->where('user_id', $userId)->where('remark', 'transfer')->sum('amount');
        $data['total_exchanged']    = Transaction::where('coin_status', 1)->where('user_id', $userId)->where('remark', 'exchange')->sum('amount');
        $data['total_withdrawn']    = Withdrawal::approved()->where('user_id', $userId)->sum('amount');
        $data['pending_withdrawn']  = Withdrawal::pending()->where('user_id', $userId)->sum('amount');
        $data['rejected_withdrawn'] = Withdrawal::rejected()->where('user_id', $userId)->sum('amount');
        $data['tickets']            = SupportTicket::where('user_id', $userId)->count();
        $coin                       = CoinRate::latest()->select('price')->first();

        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'user', 'data', 'coin'));
    }

    public function depositHistory(Request $request) {
        $pageTitle = 'Deposit History';
        $deposits  = auth()->user()->deposits()->searchable(['trx'])->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function referralUser(Request $request) {
        $pageTitle = 'My Referral Users';
        $users     = User::active()->searchable(['username'])->where('ref_by', auth()->id())->latest()->paginate(getPaginate());

        return view($this->activeTemplate . 'user.my_referral', compact('pageTitle', 'users'));
    }

    public function show2faForm() {
        $general   = gs();
        $ga        = new GoogleAuthenticator();
        $user      = auth()->user();
        $secret    = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->site_name, $secret);
        $pageTitle = '2FA Setting';
        return view($this->activeTemplate . 'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request) {
        $user = auth()->user();
        $this->validate($request, [
            'key'  => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts  = 1;
            $user->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request) {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user     = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts  = 0;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions(Request $request) {
        $pageTitle    = 'Transactions';
        $transactions = Transaction::where('user_id', auth()->id());

        if (request()->routeIs('user.transactions')) {
            $transactions = $transactions->where('coin_status', 0);
            $remarks      = Transaction::where('user_id', auth()->id())->where('coin_status', 0)->distinct('remark')->orderBy('remark')->get('remark');
            $layout       = 'transactions';
        } elseif (request()->routeIs('user.coin.transactions')) {
            $transactions = $transactions->where('coin_status', 1);
            $remarks      = Transaction::where('user_id', auth()->id())->where('coin_status', 1)->distinct('remark')->orderBy('remark')->get('remark');
            $layout       = 'coin_transactions';
        }

        $transactions = $transactions->searchable(['trx'])->filter(['trx_type', 'remark'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.' . $layout, compact('pageTitle', 'transactions', 'remarks'));
    }

    public function kycForm() {
        if (auth()->user()->kv == 2) {
            $notify[] = ['error', 'Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == 1) {
            $notify[] = ['error', 'You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form      = Form::where('act', 'kyc')->first();
        return view($this->activeTemplate . 'user.kyc.form', compact('pageTitle', 'form'));
    }

    public function kycData() {
        $user      = auth()->user();
        $pageTitle = 'KYC Data';
        return view($this->activeTemplate . 'user.kyc.info', compact('pageTitle', 'user'));
    }

    public function kycSubmit(Request $request) {
        $form           = Form::where('act', 'kyc')->first();
        $formData       = $form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData       = $formProcessor->processFormData($request, $formData);
        $user           = auth()->user();
        $user->kyc_data = $userData;
        $user->kv       = 2;
        $user->save();

        $notify[] = ['success', 'KYC data submitted successfully'];
        return to_route('user.home')->withNotify($notify);

    }

    public function attachmentDownload($fileHash) {
        $filePath  = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general   = gs();
        $title     = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype  = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData() {
        $user = auth()->user();
        if ($user->profile_complete == 1) {
            return to_route('user.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate . 'user.user_data', compact('pageTitle', 'user'));
    }

    public function userDataSubmit(Request $request) {
        $user = auth()->user();
        if ($user->profile_complete == 1) {
            return to_route('user.home');
        }
        $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
        ]);
        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;
        $user->address   = [
            'country' => @$user->address->country,
            'address' => $request->address,
            'state'   => $request->state,
            'zip'     => $request->zip,
            'city'    => $request->city,
        ];
        $user->profile_complete = 1;
        $user->save();

        $general = gs();
        if ($general->register_referral == 1 && $user->ref_by) {
            $refBonus = $general->register_bonus;
            $referBy  = User::active()->find($user->ref_by);
            if ($referBy) {
                $detail = 'You have got a sign up referral bonus.';
                referralBonus($referBy, $refBonus, $detail);
            }
        }

        $notify[] = ['success', 'Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);
    }
}
