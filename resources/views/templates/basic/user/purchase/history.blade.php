@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row">
    <div class="d-flex flex-wrap justify-content-end ms-auto mb-3">
        <form action="">
            <div class="input-group">
                <input type="text" name="search" class="form-control form--control" value="{{ request()->search }}" placeholder="@lang('Search by transactions')">
                <button class="input-group-text bg--base text-white">
                    <i class="las la-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<div class="mb-3">
    <table class="table custom--table table--responsive--xl">
        <thead>
            <tr>
                <th>@lang('TRX')</th>
                <th class="text-center">@lang('Payment Type')</th>
                <th class="text-center">@lang('Created_at')</th>
                <th class="text-center">@lang('Coin Amount')</th>
                <th class="text-center">@lang('Price')</th>
                <th>@lang('Status')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($purchaseCoin as $purchase)
            <tr>
                <td data-label="@lang('TRX')">
                    <span class="fw-bold">{{ $purchase->trx }}</span>
                </td>
                <td class="text-center" data-label="@lang('Payment Type')">
                    <span class="fw-bold">@if($purchase->method_code == 0) @lang('Wallet Balance') @else @lang('Checkout') @endif </span>
                </td>

                <td class="text-center" data-label="@lang('Created_at')">
                    {{ showDateTime($purchase->created_at) }}<br>{{ diffForHumans($purchase->created_at) }}
                </td>
                <td class="text-center" data-label="@lang('Coin Amount')">
                    <span class="fw-bold">{{showAmount($purchase->coin_amount,8)}} {{ $general->coin_code }} </span><br>
                </td>
                <td class="text-center"  data-label="@lang('Amount')">
                    <div>
                        {{ __($general->cur_sym) }}{{ showAmount($purchase->amount ) }} + <span class="text--danger" title="@lang('charge')">{{
                            showAmount($purchase->charge)}} </span>
                        <br>
                        <strong title="@lang('Amount with charge')">
                            {{ showAmount($purchase->amount+$purchase->charge) }} {{ __($general->cur_text) }}
                        </strong>
                    </div>
                </td>
                <td data-label="@lang('Status')">
                    @php echo $purchase->statusBadge @endphp
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $purchaseCoin->links() }}

<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Details')</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group userData mb-2 payment-list-item">
                </ul>
                <div class="feedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--danger btn--sm w-100" data-bs-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    (function ($) {
            "use strict";
            $('.detailBtn').on('click', function () {
                var modal = $('#detailModal');

                var userData = $(this).data('info');
                var html = '';
                if(userData){
                    userData.forEach(element => {
                        if(element.type != 'file'){
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                if($(this).data('admin_feedback') != undefined){
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                }else{
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);


                modal.modal('show');
            });
        })(jQuery);

</script>
@endpush