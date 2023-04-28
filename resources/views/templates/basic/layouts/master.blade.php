@extends($activeTemplate . 'layouts.app')
@section('app')
    @push('style-lib')
        <link href="{{ asset($activeTemplateTrue . 'css/lib/magnific-popup.css') }}" rel="stylesheet">
    @endpush
    @include($activeTemplate . 'partials.dashboard_header')

    <div class="dashboard-section">

        @include($activeTemplate . 'partials.sidebar')

        <div class="dashboard-body">
            @yield('content')
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/lib/magnific-popup.min.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            $('#walletAddress').on('click', function() {
                let walletAddressText = $('#walletAddressText').html()
                let copyText = document.createElement("input");
                copyText.value = walletAddressText;
                document.body.appendChild(copyText);
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({
                    message: "Copied: " + copyText.value,
                    position: "topRight"
                });
                document.body.removeChild(copyText);
            })
        })(jQuery)
    </script>
@endpush
