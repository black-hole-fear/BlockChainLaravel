@php
    $contact = getContent('contact_us.content', true);
@endphp

<div class="header-top">
    <div class="container">
        <div class="header-top-wrapper d-flex justify-content-center justify-content-sm-between align-items-center flex-wrap">

            <ul class="header-contact d-flex justify-content-center flex-wrap text-center">
                <li>
                    <a href="mailto:{{ @$contact->data_values->email_address }}"><i class="las la-envelope-open"></i>{{ __(@$contact->data_values->email_address) }}</a>
                </li>
                <li>
                    <a href="tel:{{ @$contact->data_values->contact_number }}"><i class="las la-phone-volume"></i> {{ @$contact->data_values->contact_number }}</a>
                </li>
            </ul>

            @if ($general->language)
                <select class="language langSel form--control h-auto px-2 py-1">
                    @foreach ($language as $item)
                        <option value="{{ $item->code }}" @if (session('lang') == $item->code) selected @endif>
                            {{ __($item->name) }}
                        </option>
                    @endforeach
                </select>
            @endif

        </div>
    </div>
</div>

<div class="header">
    <div class="header-bottom">
        <div class="container">
            <div class="header-bottom-area align-items-center">
                <div class="logo">
                    <a href="{{ route('home') }}"><img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="logo"></a>
                </div>
                <ul class="menu">
                    <li>
                        <a class="{{ menuActive('home') }}" href="{{ route('home') }}">@lang('Home')</a>
                    </li>
                    @php
                        $pages = App\Models\Page::where('tempname', $activeTemplate)
                            ->where('is_default', Status::NO)
                            ->get();
                    @endphp
                    @foreach ($pages as $k => $data)
                        <li><a class="{{ menuActive('pages', [$data->slug]) }}" href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a></li>
                    @endforeach
                    <li>
                        <a class="{{ menuActive('blog') }}" href="{{ route('blog') }}">@lang('Blog')</a>
                    </li>
                    <li>
                        <a class="{{ menuActive('contact') }}" href="{{ route('contact') }}">@lang('Contact')</a>
                    </li>
                    <li class="d-lg-none">
                        @auth
                            <a class="{{ menuActive('user.home') }}" href="{{ route('user.home') }}">@lang('Dashboard')</a>
                        @else
                            <a class="{{ menuActive('user.login') }}" href="{{ route('user.login') }}">@lang('Login')</a>
                        @endauth
                    </li>
                </ul>
                <ul class="account-login-area bg--section d-none d-lg-block">
                    @auth
                        <li><a class="text--base" href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                    @else
                        <li><a class="text--base" href="{{ route('user.login') }}">@lang('Login')</a></li>
                    @endauth
                </ul>
                <div class="header-trigger-wrapper d-flex d-lg-none align-items-center">
                    <div class="header-trigger">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
