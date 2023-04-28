@php
$faqs = getContent('faq.element',false,null,true);
$faqContent = getContent('faq.content',true);
@endphp
<section class="faq-section pt-120 pb-120 bg--section overflow-hidden">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="section-header text-center">
                    <h2 class="section-header__title text--base">{{ __(@$faqContent->data_values->heading) }} </h2>
                    <p>{{ __(@$faqContent->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            <div class="col-lg-6">
                <div class="faq-wrapper">
                    @foreach ($faqs as $faq)
                        @if ($loop->odd)
                        <div class="faq-item">
                            <div class="faq-item__title">
                                <h6 class="title">{{ __(@$faq->data_values->question) }}</h6>
                            </div>
                            <div class="faq-item__content">
                                <p>@php echo @$faq->data_values->answer @endphp</p>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <div class="faq-wrapper">
                    @foreach ($faqs as $faq)
                        @if ($loop->even)
                        <div class="faq-item">
                            <div class="faq-item__title">
                                <h6 class="title">{{ __(@$faq->data_values->question) }}</h6>
                            </div>
                            <div class="faq-item__content">
                                <p>@php echo @$faq->data_values->answer @endphp</p>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
