@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row mt-5">
    <div class="col-sm-8 col-lg-8 col-xl-6 mx-auto">
        <div class="card custom--card mb-4">
            <div class="card-header">
                <h5 class="title">@lang('Echange Now')</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.exchange.confirm') }}" method="POST">
                    @csrf
                    <div class="row gy-3">
                        <div class="form-group">
                            <label class="form-label">@lang('Coin Amount')<span class="text--danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control form--control" value="{{ old('amount') }}" autocomplete="off" required>
                                <span class="input-group-text">{{ $general->coin_code }}</span>
                            </div>
                        </div>
                        <div class="mt-3 preview-details d-none">
                            <ul class="list-group payment-list-item">
                                @if ($general->cur_text != 'USD')
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>@lang('Conversion rate ')</span> <span><span class="fw-bold"> 1 {{ $general->cur_text }} = </span> {{ showAmount($general->cur_rate) }} @lang('USD')</span>
                                </li>
                                @endif

                                <li class="list-group-item d-flex justify-content-between"><span>@lang('Tetra Rate')</span> <span><span class="fw-bold"> 1 {{ $general->coin_code }} = </span> {{ $general->coin_rate }} @lang('USD')</span></li>
                                @if ($general->cur_text != 'USD')
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>@lang('Tetra to') {{ $general->cur_text }}</span> <span><span class="fw-bold"> 1 {{ $general->coin_code }} = </span> {{ showAmount($general->coin_rate / $general->cur_rate) }} {{ $general->cur_text }}</span>
                                </li>
                                @endif

                                <li class="list-group-item d-flex justify-content-between">
                                    <span>@lang('You will get')</span> <span><span class="payable fw-bold"> 0</span> {{__($general->cur_text)}}</span>
                                </li>

                            </ul>
                        </div>
                        <button type="submit" class="btn btn--base w-100 mt-3">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    (function ($) {
            "use strict";
            $('[name=amount]').on('input',function(){
                if(!$('[name=amount]').val()){
                    $('.preview-details').addClass('d-none');
                    return false;
                }
                var amount = parseFloat($('input[name=amount]').val());
                var usd_charge = parseFloat(`{{ $general->coin_rate }}`);
                var currency_charge = parseFloat(`{{ $general->cur_rate }}`);
                var inUsdRate = parseFloat(amount*usd_charge);
                var payable = parseFloat(inUsdRate / currency_charge).toFixed(2);
                $('.preview-details').removeClass('d-none');
                $('.payable').text(payable);

            });
        })(jQuery);
</script>
@endpush
