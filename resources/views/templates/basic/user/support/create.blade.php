@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-header">
            <h5 class="text-white">{{ __($pageTitle) }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('ticket.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row gy-3">
                    <div class="form-group col-md-6">
                        <label class="form-label">@lang('Name')</label>
                        <input class="form-control form--control" name="name" type="text" value="{{ @$user->firstname . ' ' . @$user->lastname }}" required readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">@lang('Email Address')</label>
                        <input class="form-control form--control" name="email" type="email" value="{{ @$user->email }}" required readonly>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">@lang('Subject')</label>
                        <input class="form-control form--control" name="subject" type="text" value="{{ old('subject') }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">@lang('Priority')</label>
                        <select class="form--control w-100 px-2" name="priority" required>
                            <option value="3">@lang('High')</option>
                            <option value="2">@lang('Medium')</option>
                            <option value="1">@lang('Low')</option>
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <label class="form-label">@lang('Message')</label>
                        <textarea class="form-control form--control" id="inputMessage" name="message" rows="6" required>{{ old('message') }}</textarea>
                    </div>
                    <div class="form-group">
                        <div class="text-end">
                            <button class="btn btn--base btn--sm addFile" type="button">
                                <i class="fa fa-plus"></i> @lang('Add New')
                            </button>
                        </div>
                        <div class="file-upload">
                            <label class="form-label">@lang('Attachments')</label> <small class="text--danger">@lang('Max 5 files can be uploaded').
                                @lang('Maximum upload size is') {{ ini_get('upload_max_filesize') }}</small>
                            <input class="form-control form--control mb-2" id="inputAttachments" name="attachments[]" type="file" />
                            <div id="fileUploadsContainer"></div>
                            <p class="ticket-attachments-message text-white">
                                @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'),
                                .@lang('docx')
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
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
