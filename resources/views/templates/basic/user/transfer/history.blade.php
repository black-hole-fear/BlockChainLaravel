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
                <th>@lang('Transaction')</th>
                <th>@lang('Receiver | Wallet Address')</th>
                <th>@lang('Created_At')</th>
                <th>@lang('Amount')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transfers as $transfer)
            <tr>
                <td data-label="@lang('Transaction')">
                    <span class="fw-bold"> {{ $transfer->trx }} </span>
                </td>

                <td data-label="@lang('Receiver | Wallet Address')">
                    <div>
                        <span class="fw-bold text--base"> {{ __(@$transfer->receiver->fullname) }} </span>
                        <br>
                        <small> {{ @$transfer->receiver->wallet_address }} </small>
                    </div>
                </td>

                <td data-label="@lang('Created_At')">
                    {{ showDateTime($transfer->created_at) }}<br>{{ diffForHumans($transfer->created_at) }}
                </td>

                <td data-label="@lang('Amount')">
                    <div>
                        {{ __($general->coin_currency) }}{{ showAmount($transfer->amount,8) }} + <span class="text--danger" title="@lang('charge')">{{
                            showAmount($transfer->charge)}} </span>
                        <br>
                        <strong title="@lang('Amount with charge')">
                            {{ showAmount($transfer->amount + $transfer->charge,8) }} {{ __($general->coin_code) }}
                        </strong>
                    </div>
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
{{ $transfers->links() }}
@endsection
