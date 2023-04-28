@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $policyPages = getContent('policy_pages.element', false, null, true);
    @endphp

    <section class="pt-80 pb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-5">
                    <div class="card custom--card">
                        <div class="card-body">

                            <form class="verify-gcaptcha" action="{{ route('user.register') }}" method="POST">
                                @csrf
                                @if (session()->get('reference') != null)
                                    <div class="form-group">
                                        <label>@lang('Reference')</label>
                                        <input class="form-control form--control" id="referenceBy" name="referBy" type="text" value="{{ session()->get('reference') }}" placeholder="@lang('Reference By')" readonly>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="form-label" for="uname">@lang('Username')</label>
                                    <input class="form-control form--control checkUser" id="uname" name="username" type="text" value="{{ old('username') }}" required>
                                    <small class="text--danger usernameExist"></small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="email">@lang('Email')</label>
                                    <input class="form-control form--control checkUser" id="email" name="email" type="email" value="{{ old('email') }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="country">@lang('Country')</label>
                                    <select class="w-100 form--control px-2" id="country" name="country" required>
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" data-code="{{ $key }}" value="{{ $country->country }}">
                                                {{ __($country->country) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="mobile">@lang('Mobile')</label>
                                    <div class="input-group">
                                        <span class="input-group-text mobile-code"></span>
                                        <input name="mobile_code" type="hidden">
                                        <input name="country_code" type="hidden">
                                        <input class="form-control form--control checkUser" id="mobile" name="mobile" type="number" value="{{ old('mobile') }}" required>
                                    </div>
                                    <small class="text--danger mobileExist"></small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="password">@lang('Password')</label>
                                    <input class="form-control form--control" id="password" name="password" type="password" required>
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
                                <div class="form-group">
                                    <label class="form-label" for="cpassword">@lang('Confirm Password')</label>
                                    <input class="form-control form--control" id="cpassword" name="password_confirmation" type="password" required>
                                </div>

                                <x-captcha />

                                @if ($general->agree)
                                    <div class="form-group custom--checkbox">
                                        <input class="form-check me-2" id="agree" name="agree" type="checkbox" @checked(old('agree')) required>
                                        <label class="form-label" for="agree">@lang('I agree with')</label>
                                        <span>
                                            @foreach ($policyPages as $policy)
                                                <a class="text--base" href="{{ route('policy.pages', [slug(@$policy->data_values->title), $policy->id]) }}">
                                                    {{ __(@$policy->data_values->title) }} @if (!$loop->last)
                                                        ,
                                                    @endif
                                                </a>
                                            @endforeach
                                        </span>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <button class="btn btn--base w-100 mt-3" type="submit">@lang('Submit')</button>
                                </div>
                                <p class="mt-4">@lang('Already have an Account') ?
                                    <a class="ms-1 text--base fw-bold" href="{{ route('user.login') }}">@lang('Login')</a>
                                </p>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="existModalCenter" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark btn--sm" data-bs-dismiss="modal" type="button">@lang('Close')</button>
                    <a class="btn btn--base btn--sm" href="{{ route('user.login') }}">@lang('Login')</a>
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

@push('script')
    <script>
        "use strict";
        (function($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
