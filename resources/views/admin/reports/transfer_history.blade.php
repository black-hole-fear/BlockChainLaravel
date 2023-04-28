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
                                    <th>@lang('TRX')</th>
                                    <th>@lang('Sender')</th>
                                    <th>@lang('Coin Amount')</th>
                                    <th>@lang('Charge')</th>
                                    <th>@lang('Created_At')</th>
                                    <th>@lang('Detail')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transfers as $transfer)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $transfer->trx }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ @$transfer->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $transfer->user_id) }}"><span>@</span>{{ @$transfer->user->username }}</a>
                                            </span>
                                        </td>

                                        <td>
                                            <span class="fw-bold">{{ showAmount($transfer->amount, 8) }} {{ $general->coin_code }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ showAmount($transfer->charge) }} {{ $general->coin_code }}</span>
                                        </td>
                                        <td>
                                            {{ showDateTime($transfer->created_at) }}
                                            <br>
                                            {{ $transfer->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            <span>{{ __(@$transfer->details) }}</span>
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
                @if ($transfers->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($transfers) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Sender or TRX" />
@endpush
