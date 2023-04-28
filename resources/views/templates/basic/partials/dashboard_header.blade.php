
<div class="dashboard-top d-flex flex-wrap align-items-center justify-content-between">
    <a href="{{ route('home') }}" class="logo"><img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="logo"></a>
    <div class="d-flex align-items-center gap-3">
        @if ($general->language)
        <div class="d-flex flex-wrap align-items-center gap-3">
            <select class="language langSel form--control px-2 h-auto py-1">
                @foreach ($language as $item)
                <option value="{{ $item->code }}" @if (session('lang')==$item->code) selected @endif>
                    {{ __($item->name) }}
                </option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="user account-menu d-flex flex-wrap align-items-center gap-3">
            <a href="javascript:void(0)" class="d-flex flex-wrap align-items-center gap-3 account-menu-active">
                <p class="d-sm-block d-none fs--14px">{{ auth()->user()->username }} <i class="las la-angle-down"></i></p>
            </a>
            <ul class="account-submenu">
                <li><a href="{{ route('user.profile.setting') }}"><i class="las la-user"></i> @lang('Profile')</a></li>
                <li><a href="{{ route('user.change.password') }}"><i class="las la-lock"></i> @lang('Change Password')</a></li>
                <li><a href="{{ route('user.twofactor') }}"><i class="las la-key"></i> @lang('2FA Security')</a></li>
                <li><a href="{{ route('user.logout') }}"><i class="las la-sign-out-alt"></i> @lang('Logout')</a></li>
            </ul>
        </div>
        <div class="dashboard-sidebar-toggler d-lg-none"><i class="las la-sliders-h"></i></div>
    </div>
</div>