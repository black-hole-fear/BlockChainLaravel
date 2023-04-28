<div class="dashboard-sidebar">
    <div class="sidebar-close d-lg-none"><i class="las la-times"></i></div>
    <div class="dashboard-sidebar-header dashboard-widget">
        <div class="user">
            <div class="user-thumb">
                <p>@php echo nameThumb(auth()->user()->fullname) @endphp</p>
            </div>
            <h6 class="name">{{ auth()->user()->fullname }}</h6>
            <span class="username"><span>@</span>{{ auth()->user()->username }}</span>
            <p class="wallet-address mt-3 mb-1 text-left">@lang('Wallet Address ')</p>
            <div class="d-flex justify-content-center gap-2" id="walletAddress">
                <span id="walletAddressText">{{ auth()->user()->wallet_address }}</span>
                <span><i class="fas fa-copy"></i></span>
            </div>
        </div>
    </div>
    <div class="dashboard-widget dashbaord-sidebar-body">
        <ul class="dashboard-menu">
            <li><a class="{{ menuActive('user.home') }}" href="{{ route('user.home') }}"><i class="las la-home"></i> @lang('Dashboard')</a></li>
            <li><a href="#0"><i class="las la-wallet"></i> @lang('Deposit')</a>
                <ul class="dashboard-submenu {{ menuActive('user.deposit*') }}">
                    <li><a class="{{ menuActive('user.deposit.index') }}" href="{{ route('user.deposit.index') }}"><i class="las la-money-bill-wave"></i> @lang('Deposit Now')</a></li>
                    <li><a class="{{ menuActive('user.deposit.history') }}" href="{{ route('user.deposit.history') }}"><i class="las la-history"></i> @lang('Deposit History')</a></li>
                </ul>
            </li>
            @if ($general->withdrawal)
                <li><a href="#0"><i class="las la-university"></i> @lang('Withdraw')</a>
                    <ul class="dashboard-submenu {{ menuActive('user.withdraw*') }}">
                        <li><a class="{{ menuActive('user.withdraw') }}" href="{{ route('user.withdraw') }}"><i class="las la-money-check"></i> @lang('Withdraw Now')</a></li>
                        <li><a class="{{ menuActive('user.withdraw.history') }}" href="{{ route('user.withdraw.history') }}"><i class="las la-history"></i> @lang('Withdraw History')</a></li>
                    </ul>
                </li>
            @endif
            <li><a class="{{ menuActive('user.purchase.coin') }}" href="{{ route('user.purchase.coin') }}"> <i class="las la-coins"></i> @lang('Purchase') {{ $general->coin_name }}</a></li>

            @if ($general->exchange)
                <li><a class="{{ menuActive('user.exchange.money') }}" href="{{ route('user.exchange.money') }}"> <i class="las la-exchange-alt"></i>@lang('Exchange') {{ __($general->coin_name) }}</a></a></li>
            @endif

            @if ($general->transfer)
                <li><a class="{{ menuActive('user.transfer.money') }}" href="{{ route('user.transfer.money') }}"><i class="las la-money-bill-wave"></i> @lang('Transfer Now')</a></li>
            @endif
            <li><a href="#0"><i class="las la-ticket-alt"></i> @lang('Support Ticket')</a>
                <ul class="dashboard-submenu {{ menuActive('ticket*') }}">
                    <li><a class="{{ menuActive('ticket.open') }}" href="{{ route('ticket.open') }}"><i class="las la-sticky-note"></i> @lang('Open New Ticket')</a></li>
                    <li><a class="{{ menuActive('ticket.index') }}" href="{{ route('ticket.index') }}"><i class="las la-clipboard-list"></i> @lang('My tickets')</a></li>
                </ul>
            </li>

            <li><a class="{{ menuActive('user.transactions') }}" href="{{ route('user.transactions') }}"><i class="las la-list-ul"></i> @lang('Balance Transactions')</a></li>
            <li><a class="{{ menuActive('user.coin.transactions') }}" href="{{ route('user.coin.transactions') }}"><i class="las la-list-ol"></i> @lang('Coin Transactions')</a></li>
            {{-- <li><a class="{{ menuActive('user.referral') }}" ><i class="las la-users"></i> @lang('My Referred user')</a>
            <ul class="dashboard-submenu {{ menuActive('ticket*') }}">
                    <li><a class="{{ menuActive('ticket.open') }}" href="{{ route('user.referral') }}"><i class="las la-sticky-note"></i> @lang('Level-10%')</a></li>
                    
                </ul>
            </li> --}}
            <li><a href="#0"><i class="las la-users"></i> @lang('My Refered user')</a>
                <ul class="dashboard-submenu {{ menuActive('user.referral*') }}">
                    <li><a class="{{ menuActive('user.referral1') }}" href="{{ route('user.referral1') }}"><i class="las la-sticky-note"></i> @lang('Level-10%')</a></li>
                    <li><a class="{{ menuActive('user.referral2') }}" href="{{ route('user.referral2') }}"><i class="las la-sticky-note"></i> @lang('Level-5%')</a></li>
                    <li><a class="{{ menuActive('user.referral3') }}" href="{{ route('user.referral3') }}"><i class="las la-sticky-note"></i> @lang('Level-5')</a></li>
                    
                    
                </ul>
            </li>
        </ul>
    </div>
</div>
