@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-sm-8 col-lg-8 col-xl-6">
        <form action="{{route('user.purchase.coin.confirm')}}" method="post" class="">
            @csrf
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="title">@lang('Purchase Coin')</h5>
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="form-group">
                            <label class="form-label">@lang('Amount')<span class="text--danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control form--control" autocomplete="off" required>
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
                                    <span>@lang('Payable')</span> <span><span class="payable fw-bold"> 0</span> {{ $general->cur_text }}</span>
                                </li>
                                <li class="list-group-item bonustag d-flex justify-content-between d-none">
                                    <span>@lang('Purchase Bonus')</span> <span><span class="bonus fw-bold"> 0</span> {{ $general->cur_text }}</span>
                                </li>

                            </ul>
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Payment Method')<span class="text--danger">*</span></label>
                            <select name="payment_status" id="" class="form--control w-100 px-2">
                                <option value="" selected disabled>@lang('Select One')</option>
                                <option value="1">@lang('Wallet Balance')</option>
                                <option value="2">@lang('Checkout')</option>
                            </select>
                        </div>

                    </div>
                    <button type="submit" class="btn btn--base w-100 mt-3">@lang('Submit')</button>
                </div>
            </div>
        </form>
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
                $('.preview-details').removeClass('d-none');
                var usd_charge = parseFloat(`{{ $general->coin_rate }}`);
                var currency_charge = parseFloat(`{{ $general->cur_rate }}`);
                var inUsdRate = parseFloat(amount*usd_charge);
                var payable = parseFloat(inUsdRate / currency_charge).toFixed(2);
                var bonus=parseFloat(payable/10).toFixed(2);
                $('.payable').text(payable);
                if(amount>=100000)
                {
                    $('.bonus').text(bonus); 
                    $('.list-group-item.bonustag').removeClass('d-none')
                }
                else{
                    $('.list-group-item.bonustag').addClass('d-none');
                }
                

            });
        })(jQuery);
</script>
@endpush
