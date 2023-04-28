@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <h4 class="my-3">@lang('Site Setting')</h4>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group ">
                                <label> @lang('Site Title')</label>
                                <input class="form-control" type="text" name="site_name" required value="{{$general->site_name}}">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group ">
                                <label>@lang('Currency')</label>
                                <input class="form-control" type="text" name="cur_text" required value="{{$general->cur_text}}">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group ">
                                <label>@lang('Currency Symbol')</label>
                                <input class="form-control" type="text" name="cur_sym" required value="{{$general->cur_sym}}">
                            </div>
                        </div>


                        <div class="form-group col-md-4 col-sm-6">
                            <label> @lang('Timezone')</label>
                            <select class="select2-basic" name="timezone">
                                @foreach($timezones as $timezone)
                                <option value="'{{ @$timezone}}'">{{ __($timezone) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label> @lang('Site Base Color')</label>
                            <div class="input-group">
                                <span class="input-group-text p-0 border-0">
                                    <input type='text' class="form-control colorPicker" value="{{$general->base_color}}" />
                                </span>
                                <input type="text" class="form-control colorCode" name="base_color" value="{{ $general->base_color }}" />
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="form-group ">
                                <label>@lang('Currency Rate')</label>
                                <div class="input-group">
                                    <span class="input-group-text">1 &nbsp;<span class="currency_rate text--dark">{{$general->cur_text}}</span></span>
                                    <input class="form-control" type="number" step="any" name="cur_rate" required value="{{getAmount($general->cur_rate)}}">
                                    <span class="input-group-text">@lang('USD')</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <h4 class="my-3">@lang('Coin Setting')</h4>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group ">
                                <label> @lang('Coin Name')</label>
                                <input class="form-control" type="text" name="coin_name" required value="{{$general->coin_name}}">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group ">
                                <label> @lang('Coin Code')</label>
                                <input class="form-control" type="text" name="coin_code" required value="{{$general->coin_code}}">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group ">
                                <label>@lang('Coin Symbol')</label>
                                <input class="form-control" type="text" name="coin_currency" required value="{{$general->coin_currency}}">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group ">
                                <label>@lang('Wallet Address')</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="wallet_address" value="{{ $general->wallet_address }}" />
                                    <span class="input-group-text">@lang('Digit')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group ">
                                <label>@lang('Coin Initial Price')</label>
                                <div class="input-group">
                                    <input class="form-control" type="number" step="any" name="coin_init_price" required value="{{getAmount($general->coin_init_price,8)}}">
                                    <span class="input-group-text">@lang('USD')</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="form-group ">
                                <label>@lang('Increase Price Per Thousand')</label>
                                <div class="input-group">
                                    <input class="form-control" type="number" step="any" name="per_thousand_rate" required value="{{getAmount($general->per_thousand_rate,8)}}">
                                    <span class="input-group-text">@lang('USD')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group ">
                                <label>@lang('Price Up/Down From')</label>
                                <div class="input-group">
                                    <input class="form-control" type="number" step="any" name="start_value" required value="{{getAmount($general->start_value)}}">
                                    <div class="input-group-text">%</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group ">
                                <label>@lang('Price Up/Down To')</label>
                                <div class="input-group">
                                    <input class="form-control" type="number" step="any" name="end_value" required value="{{getAmount($general->end_value)}}">
                                    <div class="input-group-text">%</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-center my-3">
                                <h3 class="text--primary">
                                    1 {{ $general->coin_code }} = {{$general->coin_rate}} @lang('USD') <button type="button" data-bs-toggle="modal" data-bs-target="#calculation" class="btn btn-sm btn-outline--primary">@lang('Calculation')</button>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <h4 class="my-3">@lang('Referral')</h4>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group ">
                                        <label>@lang('Deposit Bonus')</label>
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" name="deposit_bonus" required value="{{ getAmount(@$general->deposit_bonus) }}" />
                                            <select name="bonus_type" class="input-group-text form-control">
                                                <option value="1" {{ @$general->bonus_type == 1 ? 'selected' : '' }}>{{ $general->cur_text }}</option>
                                                <option value="2" {{ @$general->bonus_type == 2 ? 'selected' : '' }}>@lang('%')</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('Register Bonus')</label>
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" name="register_bonus" value="{{ getAmount(@$general->register_bonus) }}" required />
                                            <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <h4 class="my-3">@lang('Transfer ') {{ $general->coin_name }}</h4>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group ">
                                        <label>@lang('Fixed Charge')</label>
                                        <div class="input-group">
                                            <input class="form-control" type="number" step="any" name="transfer_fixed_charge" required value="{{getAmount($general->transfer_fixed_charge)}}">
                                            <span class="input-group-text">{{ $general->coin_code }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group ">
                                        <label>@lang('Percentage Charge')</label>
                                        <div class="input-group">
                                            <input class="form-control" type="number" step="any" name="transfer_percentage_charge" required value="{{getAmount($general->transfer_percentage_charge)}}">
                                            <span class="input-group-text">@lang('%')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <div class="modal fade" id="calculation">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">@lang('Current Price Calculation')</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
          </div>
          <form action="" method="post">
              @csrf
                <div class="modal-body">
                    <p><code>IA</code> = Initial Amount</p>
                    <p><code>IPT</code> = Increase Price Per Thousand</p>
                    <p><code>TS</code> = Total Coin Sale</p>
                    <p><code>FLC</code> = Some random value between <code>`Price Up/Down From`</code> and <code>`Price Up/Down To`</code></p>
                    <h5>Current Coin Rate  = <code>(<span class="text--primary">IA</span> + <span class="text--primary">IPT</span>*(<span class="text--primary">TS/1000</span>)) +- <span class="text--primary">FLC</span> %</code></h5>
                </div>
            </form>
        </div>
      </div>
    </div>
@endsection

@push('script-lib')
<script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
<link rel="stylesheet" href="{{ asset('assets/admin/css/spectrum.css') }}">
@endpush

@push('style')
    <style>
        .select2-container{
            z-index: 999 !important;
        }
    </style>
@endpush

@push('script')
<script>
    (function ($) {
            "use strict";
            $('.colorPicker').spectrum({
                color: $(this).data('color'),
                change: function (color) {
                    $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
                }
            });

            $('.colorCode').on('input', function () {
                var clr = $(this).val();
                $(this).parents('.input-group').find('.colorPicker').spectrum({
                    color: clr,
                });
            });

            $('select[name=timezone]').val("'{{ config('app.timezone') }}'").select2();
            $('.select2-basic').select2({
                dropdownParent:$('.card-body')
            });

            $('[name=coin_code]').on('input', function () {
                $('.coin_code').text($(this).val());
            });
            $('[name=cur_text]').on('input', function () {
                $('.currency_rate').text($(this).val());
            });
        })(jQuery);

</script>
@endpush
