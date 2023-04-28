<div class="input-group flex-fill w-auto">
    <input class="datepicker-here form-control bg--white pe-2" name="date" data-range="true" data-multiple-dates-separator=" - " data-language="en" data-format="Y-m-d" data-position='bottom right' type="search" value="{{ request()->date }}" placeholder="@lang('Start Date - End Date')" autocomplete="off">
    <button class="btn btn--primary input-group-text"><i class="la la-search"></i></button>
</div>

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/admin/css/vendor/datepicker.min.css') }}" rel="stylesheet">
@endpush
