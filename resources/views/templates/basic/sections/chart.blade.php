@php
    $chart = getContent('chart.content',true);
@endphp
<section class="chart-section bg--section pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="section-header text-center">
                    <h2 class="section-header__title text--base">{{ __(@$chart->data_values->heading) }}</h2>
                    <p>{{ __(@$chart->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="chart-wrapper">
            @include($activeTemplate.'partials.chart')
        </div>
    </div>
</section>
