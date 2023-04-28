@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('TRX')</th>
                                    <th>@lang('Created_At')</th>
                                    <th>@lang('Coin Amount')</th>
                                    <th>@lang('Paid Balance')</th>
                                    <th>@lang('Payment Type')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchases as $purchase)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ @$purchase->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $purchase->user_id) }}"><span>@</span>{{ @$purchase->user->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $purchase->trx }}</span>
                                        </td>
                                        <td>
                                            {{ showDateTime($purchase->created_at) }}
                                            <br>
                                            {{ $purchase->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ showAmount($purchase->coin_amount) }} {{ $general->coin_code }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ showAmount($purchase->amount) }} {{ $general->cur_text }}</span>
                                        </td>
                                        <td>
                                            @if ($purchase->method_code == 0)
                                                <span class="fw-bold">@lang('Wallet Balance')</span>
                                            @else
                                                <span class="fw-bold">@lang('Checkout')</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($purchases->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($purchases) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Username or TRX" />
@endpush
