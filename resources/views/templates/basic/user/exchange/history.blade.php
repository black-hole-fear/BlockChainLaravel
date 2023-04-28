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
                <th>@lang('Coin Exchange')</th>
                <th>@lang('Created_At')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($exchanges as $exchange)
            <tr>
                <td data-label="@lang('Transaction')">
                    <span class="fw-bold"> {{ $exchange->trx }} </span>
                </td>

                <td data-label="@lang('Coin Exchange')">
                    <strong>
                        {{ showAmount($exchange->amount,8) }} {{ __($general->coin_code) }}
                    </strong>
                </td>

                <td data-label="@lang('Created_At')">
                    {{ showDateTime($exchange->created_at) }}<br>{{ diffForHumans($exchange->created_at) }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $exchanges->links() }}
</div>


@endsection
