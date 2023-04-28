<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransferController extends Controller {
    public function transferMoney() {
        $pageTitle = 'Transfer Coin';
        return view($this->activeTemplate . 'user.transfer.create', compact('pageTitle'));
    }

    public function checkWalletAddress(Request $request) {
        $walletAddress = User::active()->where('wallet_address', $request->walletAddress)->exists();

        if (!$walletAddress) {
            return response()->json([
                'message' => 'Sorry! The wallet address is incorrect.',
            ]);
        }

    }

    public function transferConfirm(Request $request) {
        $request->validate([
            'amount'         => 'required|numeric|gt:0',
            'wallet_address' => 'required',
        ]);
        $user    = auth()->user();
        $general = gs();
        $charge  = $general->transfer_fixed_charge + ($request->amount * $general->transfer_percentage_charge / 100);
        $payable = $request->amount + $charge;

        if ($request->wallet_address == $user->wallet_address) {
            $notify[] = ['error', 'You can\'t coin transfer to your account.'];
            return back()->withNotify($notify);
        }

        if ($payable > $user->coin) {
            $notify[] = ['error', 'You do not have enough coin in your account.'];
            return back()->withNotify($notify);
        }

        $receiver = User::active()->where('wallet_address', $request->wallet_address)->first();

        if (!$receiver) {
            $notify[] = ['error', 'Sorry! The wallet address is incorrect.'];
            return back()->withNotify($notify);
        }

        $user->coin -= $payable;
        $user->save();

        $receiver->coin += $request->amount;
        $receiver->save();

        $trx = getTrx();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->receiver_id  = $receiver->id;
        $transaction->coin_status  = 1;
        $transaction->amount       = $request->amount;
        $transaction->post_balance = $user->coin;
        $transaction->charge       = $charge;
        $transaction->trx_type     = '-';
        $transaction->details      = 'Coin transferred to - ' . $receiver->wallet_address;
        $transaction->trx          = $trx;
        $transaction->remark       = 'transfer';
        $transaction->save();

        notify($user, 'COIN_SENDER', [
            'sender_wallet_address'   => $user->wallet_address,
            'receiver_wallet_address' => $receiver->wallet_address,
            'amount'                  => showAmount($request->amount),
            'charge'                  => showAmount($charge),
            'final_amount'            => showAmount($payable),
            'coin_code'               => $general->coin_code,
            'trx'                     => $trx,
            'post_coin'               => showAmount($user->coin),
        ]);

        $transaction               = new Transaction();
        $transaction->user_id      = $receiver->id;
        $transaction->coin_status  = 1;
        $transaction->amount       = $request->amount;
        $transaction->post_balance = $receiver->coin;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = 'Coin received from - ' . $user->wallet_address;
        $transaction->trx          = $trx;
        $transaction->remark       = 'transfer';
        $transaction->save();

        notify($receiver, 'COIN_RECEIVER', [
            'sender_wallet_address'   => $user->wallet_address,
            'receiver_wallet_address' => $receiver->wallet_address,
            'amount'                  => showAmount($request->amount),
            'coin_code'               => $general->coin_code,
            'trx'                     => $trx,
            'post_coin'               => showAmount($receiver->coin),
        ]);

        $notify[] = ['success', 'Coin transferred successfully'];
        return back()->withNotify($notify);
    }

}
