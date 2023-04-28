@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="verification-code-wrapper mx-auto">
                <div class="verification-area">
                    <div class="d-flex justify-content-between border-bottom flex-wrap pb-3 text-center">
                        <h5>@lang('Verify Email')</h5>
                        <a class="text--base" href="{{ route('user.logout') }}"><i class="las la-sign-out-alt"></i> @lang('Logout')</a>
                    </div>
                    <form class="submit-form row gy-3" action="{{ route('user.verify.email') }}" method="POST">
                        @csrf
                        <p class="py-3">@lang('A 6 digit verification code sent to your email address'): {{ showEmailAddress(auth()->user()->email) }}</p>

                        @include($activeTemplate . 'partials.verification_code')
                        <div class="col-12">
                            <button class="btn btn--base btn--md w-100" type="submit">@lang('Submit')</button>
                        </div>
                        <div class="mb-3">
                            <p>
                                @lang('If you don\'t get any code'), <a class="text--base" href="{{ route('user.send.verify.code', 'email') }}"> @lang('Try again')</a>
                            </p>
                            @if ($errors->has('resend'))
                                <small class="text--danger d-block">{{ $errors->first('resend') }}</small>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
