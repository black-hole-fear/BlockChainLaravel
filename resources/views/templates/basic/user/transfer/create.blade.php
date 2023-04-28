@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-sm-8 col-lg-8 col-xl-6">
        <form action="{{route('user.transfer.confirm')}}" method="post" class="">
            @csrf
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="title">@lang('Transfer') {{ $general->coin_name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="form-group">
                            <label class="form-label">@lang('Wallet Address')<span class="text--danger">*</span></label>
                            <input type="text" name="wallet_address" class="form-control form--control checkWalletAddress" value="{{ old('wallet_address') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Amount')<span class="text--danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control form--control" value="{{ old('amount') }}"
                                    autocomplete="off" required>
                                <span class="input-group-text">{{ $general->coin_code }}</span>
                            </div>
                            <small><i>@lang('Charge'): {{ showAmount($general->transfer_fixed_charge) }} {{ $general->coin_code }} + {{ showAmount($general->transfer_percentage_charge) }}%</i></small>
                        </div>
                        <div class="mt-3 preview-details d-none">
                            <ul class="list-group payment-list-item">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>@lang('Charge')</span>
                                    <span><span class="charge fw-bold">0</span> {{__($general->coin_code)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>@lang('Payable')</span> <span><span class="payable fw-bold"> 0</span> {{__($general->coin_code)}}</span>
                                </li>
                                <li class="list-group-item justify-content-between d-none rate-element">

                                </li>
                            </ul>
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

            $('.checkWalletAddress').on('focusout',function(e){
                var url = '{{ route('user.transfer.check.walletAddress') }}';
                var walletAddress = $(this).val();
                var token = '{{ csrf_token() }}';
                var data = {walletAddress:walletAddress,_token:token}
                $.post(url,data,function(response) {
                    iziToast.error({message: response.message, position: "topRight"});
                });
            });
            $('[name=amount]').on('input',function(){
                if(!$('[name=amount]').val()){
                    $('.preview-details').addClass('d-none');
                    return false;
                }
                var fixed_charge = parseFloat(`{{ $general->transfer_fixed_charge }}`);
                var percentage_charge = parseFloat(`{{ $general->transfer_percentage_charge }}`);
                var amount = parseFloat($('input[name=amount]').val());

                $('.preview-details').removeClass('d-none');
                var charge = parseFloat(fixed_charge + (amount * percentage_charge / 100)).toFixed(2);
                $('.charge').text(charge);

                var payable = parseFloat((parseFloat(amount) + parseFloat(charge))).toFixed(2);
                $('.payable').text(payable);

            });
        })(jQuery);
</script>
@endpush
