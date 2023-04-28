@extends($activeTemplate . 'layouts.' . $layout)
@section('content')
    @if ($layout == 'frontend')
        <div class="pt-120 pb-120 container">
            <div class="row justify-content-center">
                <div class="col-md-12">
    @endif
    <div class="card custom--card">
        <div class="card-header card-header-bg d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="mt-0 text-white">
                @php echo $myTicket->statusBadge; @endphp
                [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
            </h5>
            @if ($myTicket->status != Status::TICKET_CLOSE && $myTicket->user)
                <button class="btn btn-danger close-button btn--sm confirmationBtn" data-question="@lang('Are you sure to close this ticket?')" data-action="{{ route('ticket.close', $myTicket->id) }}" data-btn_class="btn btn--base btn--md" data-btn_close="btn-close-white" type="button"><i class="fa fa-lg fa-times-circle"></i>
                </button>
            @endif
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('ticket.reply', $myTicket->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-between">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea class="form-control form--control" name="message" rows="4" placeholder="@lang('Write here')...">{{ old('message') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <a class="btn btn--base btn--sm addFile" href="javascript:void(0)"><i class="fa fa-plus"></i> @lang('Add New')</a>
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Attachments')</label> <small class="text--danger">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is') {{ ini_get('upload_max_filesize') }}</small>
                    <input class="form-control form--control" name="attachments[]" type="file" />
                    <div id="fileUploadsContainer"></div>
                    <p class="ticket-attachments-message my-2 text-white">
                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                    </p>
                </div>
                <button class="btn btn--base w-100" type="submit"> <i class="fa fa-reply"></i> @lang('Reply')</button>
            </form>
        </div>
    </div>

    <div class="card custom--card mt-4">
        <div class="card-body">
            @foreach ($messages as $message)
                @if ($message->admin_id == 0)
                    <div class="row border-warning my-3 mx-2 border py-3">
                        <div class="col-md-3 border-end text-end">
                            <h5 class="my-3 text-white">{{ $message->ticket->name }}</h5>
                        </div>
                        <div class="col-md-9">
                            <p class="fw-bold my-3 text-white">@lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                            <p class="text-white">{{ $message->message }}</p>
                            @if ($message->attachments->count() > 0)
                                <div class="mt-2">
                                    @foreach ($message->attachments as $k => $image)
                                        <a class="text--base me-3" href="{{ route('ticket.download', encrypt($image->id)) }}"><i class="fa fa-file"></i> @lang('Attachment') {{ ++$k }} </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="row border-primary my-3 mx-2 border py-3">
                        <div class="col-md-3 border-end text-end">
                            <h5 class="my-3 text-white">{{ $message->admin->name }}</h5>
                            <p class="lead text-white">@lang('Staff')</p>
                        </div>
                        <div class="col-md-9">
                            <p class="fw-bold my-3 text-white">
                                @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                            <p>{{ $message->message }}</p>
                            @if ($message->attachments->count() > 0)
                                <div class="mt-2">
                                    @foreach ($message->attachments as $k => $image)
                                        <a class="text--base me-3" href="{{ route('ticket.download', encrypt($image->id)) }}"><i class="fa fa-file"></i> @lang('Attachment') {{ ++$k }} </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    @if ($layout == 'frontend')
        </div>
        </div>
        </div>
    @endif

    <x-confirmation-modal isDanger="yes" />
@endsection
@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control form--control" required />
                        <button class="input-group-text btn--danger remove-btn text--danger" type="button"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
