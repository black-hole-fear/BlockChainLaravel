<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\NotificationLog;
use App\Models\Transaction;
use App\Models\UserLogin;
use Illuminate\Http\Request;

class ReportController extends Controller {
    public function transaction(Request $request) {
        $pageTitle    = 'Transaction Logs';
        $remarks      = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $transactions = Transaction::searchable(['trx', 'user:username'])->filter(['trx_type', 'remark'])->dateFilter()->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function loginHistory(Request $request) {
        $pageTitle = 'User Login History';
        $loginLogs = UserLogin::orderBy('id', 'desc')->searchable(['user:username'])->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs'));
    }

    public function loginIpHistory($ip) {
        $pageTitle = 'Login by - ' . $ip;
        $loginLogs = UserLogin::where('user_ip', $ip)->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs', 'ip'));

    }

    public function notificationHistory(Request $request) {
        $pageTitle = 'Notification History';
        $logs      = NotificationLog::orderBy('id', 'desc')->searchable(['user:username'])->with('user')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs'));
    }

    public function emailDetails($id) {
        $pageTitle = 'Email Details';
        $email     = NotificationLog::findOrFail($id);
        return view('admin.reports.email_details', compact('pageTitle', 'email'));
    }

    public function purchaseHistory(Request $request) {
        $pageTitle = 'Purchase History';
        $purchases = Deposit::where('coin_amount', '!=', 0)->searchable(['trx', 'user:username'])->with('user')->latest()->paginate(getPaginate());
        return view('admin.reports.purchase_history', compact('pageTitle', 'purchases'));
    }

    public function transferHistory(Request $request) {
        $pageTitle = 'Transfer History';
        $transfers = Transaction::where('coin_status', 1)->where('receiver_id', '!=', 0)->where('remark', 'transfer')->searchable(['trx', 'user:username'])->with('user')->latest()->paginate(getPaginate());
        return view('admin.reports.transfer_history', compact('pageTitle', 'transfers'));
    }

    public function exchangeHistory(Request $request) {
        $pageTitle = 'Exchange History';
        $exchanges = Transaction::where('coin_status', 1)->where('remark', 'exchange')->searchable(['trx', 'user:username'])->with('user')->latest()->paginate(getPaginate());
        return view('admin.reports.exchange_history', compact('pageTitle', 'exchanges'));
    }
}
