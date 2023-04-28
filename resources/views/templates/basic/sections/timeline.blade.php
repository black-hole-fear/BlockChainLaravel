@php
    $timeline = getContent('timeline.content',true);
    $timelineElement = getContent('timeline.element',false,null,true);
@endphp
<section class="timeline-section pt-120 pb-120 overflow-hidden">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="section-header text-center">
                    <h2 class="section-header__title text--base">{{ __(@$timeline->data_values->heading) }}</h2>
                    <p>{{ __(@$timeline->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="timeline-wrapper justify-content-md-between justify-content-center">
            @foreach ($timelineElement as $timeline)
            <div class="timeline-item ">
                <div class="timeline-header">
                    <h4 class="year">{{ __(@$timeline->data_values->year) }}</h4>
                </div>
                <div class="timeline-body">
                    <h6 class="title">{{ __(@$timeline->data_values->title) }}</h6>
                    <p>{{ __(@$timeline->data_values->description) }}</p>
                </div>
                <div class="timeline-icon">@php echo @$timeline->data_values->timeline_icon @endphp</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
