@php
$banner = getContent('banner.content',true);
@endphp
<section class="banner-section position-relative">
    <div class="particles-js" id="particles-js"></div>
    <div class="container">
        <div class="banner-content">
            <h1 class="title text--base">{{ __(@$banner->data_values->heading) }}</h1>
            <p class="banner-pera">{{ __(@$banner->data_values->short_detail) }}</p>
        </div>
        <div class="div d-flex flex-wrap justify-content-center gap-4 mt-5">
            <a href="{{ route('user.register') }}" class="btn btn--base">@lang('Register')</a>
            <a href="{{ route('user.login') }}" class="btn btn--secondary">@lang('Login')</a>
        </div>
    </div>
</section>

@push('script-lib')
<script src="{{ asset($activeTemplateTrue.'js/lib/particle.js') }}"></script>
<script src="{{ asset($activeTemplateTrue.'js/lib/particle-custom.php') }}?favicon={{ getImage(getFilePath('logoIcon') . '/favicon.png') }}"></script>
@endpush
