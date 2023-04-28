@php
   $about = getContent('about.content',true);
   $aboutElement = getContent('about.element',false,null,true);
@endphp

<section class="about-section pt-120 pb-120 overflow-hidden">
    <div class="container">
        <div class="row gy-4 gy-sm-5">
            <div class="col-lg-6">
                <div class="about-thumb rtl me-xxl-5 me-lg-4">
                    <img src="{{ getImage('assets/images/frontend/about/' . @$about->data_values->image, '590x390') }}" alt="thumb">
                    <a href="{{ @$about->data_values->video_url }}" class="video-button"><i class="las la-play"></i></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="section-header mb-4">
                        <h2 class="section-header__title text--base">{{ __(@$about->data_values->heading) }}</h2>
                        <p>{{ __(@$about->data_values->subheading) }}</p>
                    </div>
                    <p>{{ __(@$about->data_values->description) }}</p>
                </div>
                <div class="feature-wrapper mt-4">
                    @foreach ($aboutElement as $about)
                    <div class="feature-item">
                        <div class="feature-item__icon">@php echo @$about->data_values->about_icon @endphp</div>
                        <h6 class="title">{{ __(@$about->data_values->title) }}</h6>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@push('style-lib')
<link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/lib/magnific-popup.css') }}">
@endpush

@push('script-lib')
<script src="{{ asset($activeTemplateTrue.'js/lib/magnific-popup.min.js') }}"></script>
@endpush

@push('script')
<script>
    (function($){
            "use strict";
            $(".video-button").magnificPopup({
                type: "iframe",
            });
        })(jQuery)
</script>
@endpush
