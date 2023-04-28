@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="pt-80 pb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-5">
                    <div class="card custom--card">
                        <div class="card-body">
                            <form class="verify-gcaptcha" method="POST" action="{{ route('user.login') }}">
                                @csrf

                                <div class="form-group">
                                    <label class="form-label" for="email">@lang('Username or Email')</label>
                                    <input class="form-control form--control" name="username" type="text" value="{{ old('username') }}" required>
                                </div>

                                <div class="form-group">
                                    <div class="d-flex justify-content-between mb-2 flex-wrap">
                                        <label class="form-label mb-0" for="password">@lang('Password')</label>
                                        <a class="fw-bold forgot-pass" href="{{ route('user.password.request') }}">
                                            @lang('Forgot your password?')
                                        </a>
                                    </div>
                                    <input class="form-control form--control" id="password" name="password" type="password" required>
                                </div>

                                <x-captcha />

                                <div class="form-group form-check">
                                    <input class="form-check-input" id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        @lang('Remember Me')
                                    </label>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn--base w-100" id="recaptcha" type="submit">
                                        @lang('Login')
                                    </button>
                                </div>
                                <p class="mb-0">@lang('Don\'t have any account?') <a class="text--base" href="{{ route('user.register') }}">@lang('Register')</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
