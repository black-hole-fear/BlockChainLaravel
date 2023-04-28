@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-xxl-6 col-xl-8 col-lg-10 col-md-8 col-sm-10">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="card-title">@lang('Change Password')</h5>
                </div>
                <div class="card-body">
                    <form class="row gy-3" action="" method="post">
                        @csrf
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="current-pass">@lang('Current Password')</label>
                                <input class="form-control form--control" id="current-pass" name="current_password" type="password" required autocomplete="current-password">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="new-pass">@lang('New Password')</label>
                                <input class="form-control form--control" id="new-pass" name="password" type="password" required autocomplete="current-password">
                                @if ($general->secure_password)
                                    <div class="input-popup">
                                        <p class="error lower">@lang('1 small letter minimum')</p>
                                        <p class="error capital">@lang('1 capital letter minimum')</p>
                                        <p class="error number">@lang('1 number minimum')</p>
                                        <p class="error special">@lang('1 special character minimum')</p>
                                        <p class="error minimum">@lang('6 character password')</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="confirm-pass">@lang('Confirm Password')</label>
                                <input class="form-control form--control" id="confirm-pass" name="password_confirmation" type="password" required autocomplete="current-password">
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn--base btn--md w-100 mt-3" type="submit">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
