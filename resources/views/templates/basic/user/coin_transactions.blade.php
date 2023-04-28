@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="show-filter mb-3 text-end">
            <button type="button" class="btn btn--base showFilterBtn btn-sm"><i class="las la-filter"></i> @lang('Filter')</button>
        </div>
        <div class="card custom--card responsive-filter-card mb-4">
            <div class="card-body">
                <form action="">
                    <div class="d-flex flex-wrap gap-4">
                        <div class="flex-grow-1">
                            <label>@lang('Transaction Number')</label>
                            <input type="text" name="search" value="{{ request()->search }}" class="form-control form--control">
                        </div>
                        <div class="flex-grow-1">
                            <label>@lang('Type')</label>
                            <select name="type" class="form--control px-2 w-100">
                                <option value="">@lang('All')</option>
                                <option value="+" @selected(request()->type == '+')>@lang('Plus')</option>
                                <option value="-" @selected(request()->type == '-')>@lang('Minus')</option>
                            </select>
                        </div>
                        <div class="flex-grow-1">
                            <label>@lang('Remark')</label>
                            <select class="form--control px-2 w-100" name="remark">
                                <option value="">@lang('Any')</option>
                                @foreach($remarks as $remark)
                                <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>{{
                                    __(keyToTitle($remark->remark)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-grow-1 align-self-end">
                            <button class="btn btn--base form--control w-100"><i class="las la-filter"></i> @lang('Filter')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table custom--table table--responsive--xl">
            <thead>
                <tr>
                    <th>@lang('Trx')</th>
                    <th>@lang('Transacted')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Post Coin Amount')</th>
                    <th>@lang('Detail')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr>
                    <td data-label="@lang('Trx')">
                        <strong>{{ $trx->trx }}</strong>
                    </td>

                    <td data-label="@lang('Transacted')">
                        {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                    </td>

                    <td data-label="@lang('Amount')">
                        <span class="fw-bold @if($trx->trx_type == '+')text--success @else text--danger @endif">
                            {{ $trx->trx_type }} {{showAmount($trx->amount,8)}} @if ($trx->coin_status == 1) {{ $general->coin_code }} @else {{ $general->cur_text }} @endif
                        </span>
                    </td>

                    <td data-label="@lang('Post Coin Amount')">
                        {{ showAmount($trx->post_balance,8) }} {{ $general->coin_code }}
                    </td>

                    <td data-label="@lang('Detail')">{{ __($trx->details) }}</td>
                </tr>
                @empty
                <tr>
                    <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $transactions->links() }}
</div>
    @endsection

    @push('script')
    <script>
        (function($) {
                "use strict";
                $('.showFilterBtn').on('click',function(){
                    $('.responsive-filter-card').slideToggle();
                });
            })(jQuery)
    </script>
    @endpush