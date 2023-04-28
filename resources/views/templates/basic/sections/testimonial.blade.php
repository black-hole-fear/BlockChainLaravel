@php
$content = getContent('testimonial.content',true);
$testimonials = getContent('testimonial.element',false,null,true);
@endphp


<section class="testimonial-section pt-120 pb-120 bg--section overflow-hidden">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="section-header text-center">
                    <h2 class="section-header__title text--base">{{__(@$content->data_values->heading)}}</h2>
                    <p>{{__(@$content->data_values->subheading)}}</p>
                </div>
            </div>
        </div>
        <div class="testimonial-slider">
            @foreach ($testimonials as $testimonial)
            <div class="single-slide">
                <div class="testimonial-item">
                    <div class="testimonial-item__thumb">
                        <img src="{{ getImage('assets/images/frontend/testimonial/'.@$testimonial->data_values->image,'150x150') }}" alt="testimonial">
                        <div class="quote-icon"><i class="las la-quote-left"></i></div>
                    </div>
                    <div class="testimonial-item__content">
                        <h4 class="name">{{__(@$testimonial->data_values->name)}}</h5>
                            <span class="designation text--base">{{__(@$testimonial->data_values->designation)}}</span>
                            <p>{{__(@$testimonial->data_values->comment)}}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@push('style-lib')
<link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/lib/slick.css') }}">
@endpush

@push('script-lib')
<script src="{{ asset($activeTemplateTrue .'js/lib/slick.min.js') }}"></script>
@endpush

@push('script')
<script>
    (function($){
            "use strict";
            $(".testimonial-slider").slick({
                fade: false,
                slidesToShow: 2,
                slidesToScroll: 1,
                infinite: true,
                autoplay: true,
                pauseOnHover: true,
                centerMode: false,
                dots: true,
                arrows: false,
                nextArrow: '<i class="las la-arrow-right arrow-right"></i>',
                prevArrow: '<i class="las la-arrow-left arrow-left"></i> ',
                responsive: [
                    {
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 2,
                        },
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 1,
                        },
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 1,
                        },
                    },
                    {
                        breakpoint: 575,
                        settings: {
                            slidesToShow: 1,
                        },
                    },
                ],
            });
        })(jQuery)
</script>
@endpush