<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ExchangeController extends Controller {

    public function exchangeMoney(Request $request) {
        $pageTitle = 'Exchange Coin';
        return view($this->activeTemplate . 'user.exchange.index', compact('pageTitle'));
    }

    public function exchangeConfirm(Request $request) {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
        ]);

        $user = auth()->user();

        if ($request->amount > $user->coin) {
            $notify[] = ['error', 'Sorry! Insufficient coin in your account.'];
            return back()->withNotify($notify);
        }

        $general = gs();

        $currencyCharge = $general->cur_rate;
        $inUsdRate      = $request->amount * $general->coin_rate;
        $paidAmount     = $inUsdRate / $currencyCharge;

        $user->coin -= $request->amount;
        $user->balance += $paidAmount;
        $user->save();

        $trx = getTrx();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $paidAmount;
        $transaction->post_balance = $user->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = 'Balance added for coin exchange';
        $transaction->trx          = $trx;
        $transaction->remark       = 'exchange';
        $transaction->save();

        $transaction               = new Transaction();
        $transaction->coin_status  = 1;
        $transaction->user_id      = $user->id;
        $transaction->amount       = $request->amount;
        $transaction->post_balance = $user->coin;
        $transaction->charge       = 0;
        $transaction->trx_type     = '-';
        $transaction->details      = 'Coin has been deducted for balance exchange';
        $transaction->trx          = $trx;
        $transaction->remark       = 'exchange';
        $transaction->save();

        notify($user, 'COIN_EXCHANGE', [
            'user_name'       => $user->username,
            'amount'          => showAmount($paidAmount),
            'coin'            => showAmount($request->amount),
            'site_currency'   => $general->cur_text,
            'coin_code'       => $general->coin_code,
            'currency_charge' => showAmount($general->cur_rate),
            'coin_rate'       => showAmount($general->coin_rate),
            'trx'             => $trx,
            'post_coin'       => showAmount($user->coin),
            'post_balance'    => showAmount($user->balance),
        ]);

        $notify[] = ['success', 'Coin exchanged successfully'];
        return back()->withNotify($notify);
    }

}
