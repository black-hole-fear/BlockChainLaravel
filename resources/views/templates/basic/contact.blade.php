@php
    $contact = getContent('contact_us.content', true);
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="pt-120 pb-120 bg--section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="info-item align-items-center">
                        <div class="info-icon"><i class="las la-phone-volume"></i></div>
                        <div class="info-content">
                            <a href="tel:{{ @$contact->data_values->contact_number }}">{{ @$contact->data_values->contact_number }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="info-item align-items-center">
                        <div class="info-icon"><i class="las la-envelope"></i></div>
                        <div class="info-content">
                            <a href="mailto:{{ __(@$contact->data_values->email_address) }}">{{ __(@$contact->data_values->email_address) }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-7">
                    <div class="info-item align-items-center">
                        <div class="info-icon"><i class="las la-map-marked"></i></div>
                        <div class="info-content">
                            <p>{{ __(@$contact->data_values->contact_details) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="contact-section pt-120 pb-120">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-6">
                    <div class="contact-wrapper">
                        <h3 class="title mb-2">{{ __(@$contact->data_values->title) }}</h3>
                        <p class="mb-sm-5 mb-4">{{ __(@$contact->data_values->short_details) }}</p>
                        <form class="contact-form row gy-3 verify-gcaptcha" method="post" action="">
                            @csrf
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control form--control" id="name" name="name" type="text" value="@if (auth()->user()) {{ auth()->user()->fullname }}@else{{ old('name') }} @endif" placeholder="@lang('Name')" @if (auth()->user()) readonly @endif required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control form--control" id="email" name="email" type="email" value="@if (auth()->user()) {{ auth()->user()->email }}@else{{ old('email') }} @endif" placeholder="@lang('Email')" @if (auth()->user()) readonly @endif required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control form--control" name="subject" type="text" value="{{ old('subject') }}" placeholder="@lang('Subject')">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control form--control" name="message" placeholder="@lang('Message')">{{ old('message') }}</textarea>
                                </div>
                            </div>

                            <x-captcha />

                            <div class="col-12">
                                <button class="btn btn--base w-100" type="submit">@lang('Send Message')</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-thumb">
                        <img src="{{ getImage('assets/images/frontend/contact_us/' . @$contact->data_values->image, '800x600') }}" alt="contact">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="gmaps-area">
        <iframe id="gmaps" src="https://maps.google.com/maps?q={{ __(@$contact->data_values->latitude) }},{{ __(@$contact->data_values->longitude) }}&hl=es;z=14&amp;output=embed" style="border:0;" width="600" height="450" allowfullscreen="" loading="lazy"></iframe>
    </div>
@endsection
