@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $kyc = getContent('kyc.content', true);
    @endphp

    <div class="d-flex justify-content-end my-3">
        <p class="fs--18px">{{ $general->coin_name }} @lang('Rate'):
            <span class="text--base fs--30px">${{ showAmount($general->coin_rate, 8) }}</span>
        </p>
    </div>
    <div class="row justify-content-end">
        <div class="col-md-7 col-lg-7 col-xxl-5">
            <div class="">
                <h6 class="mb-1">@lang('Referral Link')</h6>
                <div class="input-group">
                    <input class="form-control form--control referralURL" type="text" value="{{ route('home') }}?reference={{ auth()->user()->username }}" readonly>
                    <button class="input-group-text bg--base copytext" id="copyBoard"><i class="fas fa-copy"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (auth()->user()->kv == 0)
                <div class="alert alert-info mt-4" role="alert">
                    <h4 class="alert-heading">@lang('KYC Verification required')</h4>
                    <hr>
                    <p class="mb-0">{{ __($kyc->data_values->verification_content) }} <a class="text--base" href="{{ route('user.kyc.form') }}">@lang('Click Here to Verify')</a></p>
                </div>
            @elseif(auth()->user()->kv == 2)
                <div class="alert alert-warning mt-4" role="alert">
                    <h4 class="alert-heading">@lang('KYC Verification pending')</h4>
                    <hr>
                    <p class="mb-0">{{ __($kyc->data_values->pending_content) }} <a class="text--base" href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a></p>
                </div>
            @endif
        </div>
    </div>

    <div class="row gy-4 pt-5">
        <div class="col-lg-6 col-xxl-3 col-md-6 col-sm-6">
            <div class="dashboard-card">
                <div class="dashboard-card__content">
                    <p class="title">@lang('MY BALANCE')</p>
                    <h3 class="value text--base">{{ $general->cur_sym }}<span>{{ showAmount($user['balance']) }}</span></h3>
                </div>
                <div class="dashboard-card__icon">
                    <i class="las la-money-bill-wave"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xxl-3 col-md-6 col-sm-6">
            <div class="dashboard-card">
                <div class="dashboard-card__content">
                    <p class="title">@lang('MY') {{ strtoupper($general->coin_name) }} @lang('COIN')</p>
                    <h3 class="value text--base">{{ $general->coin_currency }}<span><span>{{ showAmount($user['coin']) }}</span></h3>
                </div>
                <div class="dashboard-card__icon">
                    <i class="las la-coins"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xxl-3 col-md-6 col-sm-6">
            <div class="dashboard-card">
                <div class="dashboard-card__content">
                    <p class="title">@lang('PURCHASED COIN')</p>
                    <h3 class="value text--base">{{ $general->coin_currency }}<span>{{ showAmount($data['total_purchased']) }}</span></h3>
                </div>
                <div class="dashboard-card__icon">
                    <i class="lab la-bitcoin"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xxl-3 col-md-6 col-sm-6">
            <div class="dashboard-card">
                <div class="dashboard-card__content">
                    <p class="title">@lang('TOTAL DEPOSITED')</p>
                    <h3 class="value text--base">{{ $general->cur_sym }}<span>{{ showAmount($data['total_deposited']) }}</span></h3>
                </div>
                <div class="dashboard-card__icon">
                    <i class="las la-wallet"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xxl-3 col-md-6 col-sm-6">
            <div class="dashboard-card">
                <div class="dashboard-card__content">
                    <p class="title">@lang('PENDING DEPOSITS')</p>
                    <h3 class="value text--base">{{ $general->cur_sym }}<span>{{ showAmount($data['pending_deposited']) }}</span></h3>
                </div>
                <div class="dashboard-card__icon">
                    <i class="las la-spinner"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xxl-3 col-md-6 col-sm-6">
            <div class="dashboard-card">
                <div class="dashboard-card__content">
                    <p class="title">@lang('REJECTED DEPOSITS')</p>
                    <h3 class="value text--base">{{ $general->cur_sym }}<span>{{ showAmount($data['rejected_deposited']) }}</span></h3>
                </div>
                <div class="dashboard-card__icon">
                    <i class="las la-ban"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xxl-3 col-md-6 col-sm-6">
            <div class="dashboard-card">
                <div class="dashboard-card__content">
                    <p class="title">@lang('TOTAL EXCHANGED COIN')</p>
                    <h3 class="value text--base">{{ $general->coin_currency }}<span><span>{{ showAmount($data['total_exchanged']) }}</span></h3>
                </div>
                <div class="dashboard-card__icon">
                    <i class="las la-exchange-alt"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xxl-3 col-md-6 col-sm-6">
            <div class="dashboard-card">
                <div class="dashboard-card__content">
                    <p class="title">@lang('TOTAL WITHDRWAN')</p>
                    <h3 class="value text--base">{{ $general->cur_sym }}<span>{{ showAmount($data['total_withdrawn']) }}</span></h3>
                </div>
                <div class="dashboard-card__icon">
                    <i class="las la-money-bill-alt"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xxl-3 col-md-6 col-sm-6">
            <div class="dashboard-card">
                <div class="dashboard-card__content">
                    <p class="title">@lang('PENDING WITHDRAWALS')</p>
                    <h3 class="value text--base">{{ $general->cur_sym }}<span>{{ showAmount($data['pending_withdrawn']) }}</span></h3>
                </div>
                <div class="dashboard-card__icon">
                    <i class="las la-hourglass-start"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xxl-3 col-md-6 col-sm-6">
            <div class="dashboard-card">
                <div class="dashboard-card__content">
                    <p class="title">@lang('REJECTED WITHDRAWALS')</p>
                    <h3 class="value text--base">{{ $general->cur_sym }}<span>{{ showAmount($data['rejected_withdrawn']) }}</span></h3>
                </div>
                <div class="dashboard-card__icon">
                    <i class="las la-times-circle"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xxl-3 col-md-6 col-sm-6">
            <div class="dashboard-card">
                <div class="dashboard-card__content">
                    <p class="title">@lang('TOTAL TRANSFERRED')</p>
                    <h3 class="value text--base">{{ $general->coin_currency }}<span><span>{{ showAmount($data['total_transferred']) }}</span></h3>
                </div>
                <div class="dashboard-card__icon">
                    <i class="las la-share-square"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xxl-3 col-md-6 col-sm-6">
            <div class="dashboard-card">
                <div class="dashboard-card__content">
                    <p class="title">@lang('Support Ticket')</p>
                    <h3 class="value text--base">{{ $data['tickets'] }}</h3>
                </div>
                <div class="dashboard-card__icon">
                    <i class="las la-ticket-alt"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-5">
        <h6 class="mb-2">@lang('EBC Price History')</h6>
        @include($activeTemplate . 'partials.chart')
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('#copyBoard').click(function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 5500);
            });
        })(jQuery);
    </script>
@endpush
