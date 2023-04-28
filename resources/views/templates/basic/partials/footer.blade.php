@php
$policyPages = getContent('policy_pages.element',false,null,true);
$socialIcons = getContent('social_icon.element', false, null, true);
$contact = getContent('contact_us.content', true);
@endphp
<footer class="footer bg--section">
    <div class="footer-top">
        <div class="container">
            <div class="row justify-content-between gy-4">
                <div class="col-lg-3 col-md-5">
                    <div class="footer-widget">
                        <a href="{{ route('home') }}" class="logo mb-3"><img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="Logo"></a>
                        <p>{{ __($contact->data_values->description) }}</p>
                        <ul class="social-links mt-3">
                            @foreach ($socialIcons as $social)
                                <li>
                                    <a href="{{ @$social->data_values->url }}" target="_blank">
                                        @php
                                            echo @$social->data_values->social_icon;
                                        @endphp
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-xl-2 col-sm-5">
                    <div class="footer-widget">
                        <h6 class="pb-2">@lang('Usefull Link')</h6>
                        <ul class="footer-links">
                            <li>
                                <a href="{{ route('home') }}">@lang('Home')</a>
                            </li>
                            <li>
                                <a href="{{ route('blog') }}">@lang('Blog')</a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}">@lang('Contact')</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-xl-2 col-sm-5">
                    <div class="footer-widget">
                        <h6 class="pb-2">@lang('Policy Pages')</h6>
                        <ul class="footer-links">
                            @foreach ($policyPages as $policy)
                            <li><a href="{{ route('policy.pages',[slug(@$policy->data_values->title),$policy->id]) }}">{{ __(@$policy->data_values->title) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-5">
                    <div class="footer-widget">
                        <h6 class="pb-2">@lang('Contact Us')</h6>
                        <ul class="footer-contact">
                            <li><a href="mailto:{{ @$contact->data_values->email_address }}"><i class="las la-envelope-open"></i> {{ __(@$contact->data_values->email_address) }}</a>
                            </li>
                            <li><a href="tel:{{ @$contact->data_values->contact_number }}"><i class="las la-phone-volume"></i> {{ __(@$contact->data_values->contact_number) }}</a>
                            </li>
                            <li><i class="las la-map-marker"></i> {{ __(@$contact->data_values->contact_details) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-wrapper d-flex flex-wrap justify-content-center text-center">
                <p>@lang('Copyright') &copy; @php echo date('Y') @endphp. @lang('All Rights Reserved')</p>
            </div>
        </div>
    </div>
</footer>
