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
                                    <th>@lang('User')</th>
                                    <th>@lang('Coin Amount')</th>
                                    <th>@lang('Created_At')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($exchanges as $exchange)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $exchange->trx }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ __(@$exchange->user->fullname) }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $exchange->user_id) }}"><span>@</span>{{ @$exchange->user->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ showAmount($exchange->amount, 8) }} {{ $general->coin_code }}</span>
                                        </td>
                                        <td>
                                            {{ showDateTime($exchange->created_at) }}
                                            <br>
                                            {{ diffForHumans($exchange->created_at) }}
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
                @if ($exchanges->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($exchanges) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Username or TRX" />
@endpush
