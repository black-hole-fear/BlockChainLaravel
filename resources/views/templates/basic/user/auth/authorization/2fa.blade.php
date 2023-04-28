@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="verification-code-wrapper">
                    <div class="verification-area">
                        <div class="d-flex justify-content-between border-bottom flex-wrap pb-3 text-center">
                            <h5>@lang('2FA Verification')</h5>
                            <a class="text--base" href="{{ route('user.logout') }}"><i class="las la-sign-out-alt"></i> @lang('Logout')</a>
                        </div>
                        <form class="submit-form" action="{{ route('user.go2fa.verify') }}" method="POST">
                            @csrf
                            <div class="mt-3">
                                @include($activeTemplate . 'partials.verification_code')
                            </div>
                            <div class="form--group">
                                <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
