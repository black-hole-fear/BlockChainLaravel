@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="payment-method-item">

                    <div class="payment-method-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="card border--primary mt-3">
                                    <h5 class="card-header bg--primary">@lang('Deposit')</h5>
                                    <div class="card-body">
                                        <form action="{{ route('admin.referral.update','deposit') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>@lang('Amount')</label>
                                                <div class="input-group">
                                                    <input type="number" step="any" class="form-control" name="amount" required value="{{ getAmount(@$deposit->amount) }}" />
                                                    <select name="referral_type" class="input-group-text form-control">
                                                        <option value="1" {{ @$deposit->referral_type == 1 ? 'selected' : '' }}>{{ $general->cur_text }}</option>
                                                        <option value="2" {{ @$deposit->referral_type == 2 ? 'selected' : '' }}>@lang('%')</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="50" data-on="@lang('Enable')" data-off="@lang('Disable')" name="status" @if(@$deposit->status) checked @endif>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="card border--primary mt-3">
                                    <h5 class="card-header bg--primary">@lang('Registration')</h5>
                                    <div class="card-body">
                                        <form action="{{ route('admin.referral.update','register') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>@lang('Amount')</label>
                                                <div class="input-group">
                                                    <input type="number" step="any" class="form-control" name="amount" value="{{ getAmount(@$register->amount) }}" required />
                                                    <div class="input-group-text">{{ __($general->cur_text) }}</div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="50" data-on="@lang('Enable')" data-off="@lang('Disable')" name="status" @if(@$register->status) checked @endif>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection