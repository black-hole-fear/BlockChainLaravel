@props(['isDanger' => ''])
<div class="modal fade" id="confirmationModal" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="question"></p>
                </div>
                <div class="modal-footer">
                    <button class="{{ $isDanger ? 'btn btn--danger' : 'btn btn--dark' }} btn--md" data-bs-dismiss="modal" type="button">@lang('No')</button>
                    <button class="btn btn--primary submitBtn" type="submit">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            "use strict";
            $(document).on('click', '.confirmationBtn', function() {
                var modal = $('#confirmationModal');
                let data = $(this).data();
                modal.find('.question').text(`${data.question}`);
                modal.find('form').attr('action', `${data.action}`);
                if (data.btn_class) {
                    modal.find('.submitBtn').removeClass('btn btn--primary');
                    modal.find('.submitBtn').addClass(`${data.btn_class}`);
                }
                modal.find('.btn-close').addClass(`${data.btn_close}`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
