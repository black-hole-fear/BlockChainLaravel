@php
$service = getContent('service.content',true);
$services = getContent('service.element',false,null,true);
@endphp
<section class="what-section bg--section pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="section-header text-center">
                    <h2 class="section-header__title text--base">{{ __(@$service->data_values->heading) }}</h2>
                    <p>{{ __(@$service->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach ($services as $service)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10">
                <div class="what-item">
                    <div class="what-item__icon">
                        @php
                            echo @$service->data_values->service_icon
                        @endphp
                    </div>
                    <div class="what-item__content">
                        <h4 class="title">{{ __(@$service->data_values->title) }}</h4>
                        <p>{{ __(@$service->data_values->description) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
