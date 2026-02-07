@extends($activeTemplate.'layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card custom--card">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                    <h5 class="card-title">@lang('Referral Bonuses')</h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge badge--primary">@lang('Total Earned'): {{ showAmount($user->referral_bonus) }} {{ $general->cur_text }}</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($bonuses->count())
                        <div class="table-responsive">
                            <table class="table table--responsive--md">
                                <thead>
                                    <tr>
                                        <th>@lang('Date')</th>
                                        <th>@lang('Referral')</th>
                                        <th>@lang('Type')</th>
                                        <th>@lang('Description')</th>
                                        <th>@lang('Amount')</th>
                                        <th>@lang('Status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bonuses as $bonus)
                                        <tr>
                                            <td data-label="@lang('Date')">
                                                {{ showDateTime($bonus->created_at) }}
                                            </td>
                                            <td data-label="@lang('Referral')">
                                                @if($bonus->referral)
                                                    <span>{{ $bonus->referral->username }}</span>
                                                @else
                                                    <span class="text--danger">@lang('N/A')</span>
                                                @endif
                                            </td>
                                            <td data-label="@lang('Type')">
                                                @if($bonus->type == 'signup')
                                                    <span class="badge badge--success">@lang('Signup Bonus')</span>
                                                @elseif($bonus->type == 'deposit')
                                                    <span class="badge badge--primary">@lang('Deposit Bonus')</span>
                                                @elseif($bonus->type == 'investment')
                                                    <span class="badge badge--info">@lang('Investment Bonus')</span>
                                                @else
                                                    <span class="badge badge--warning">{{ ucfirst($bonus->type) }}</span>
                                                @endif
                                            </td>
                                            <td data-label="@lang('Description')">
                                                {{ __($bonus->description) }}
                                            </td>
                                            <td data-label="@lang('Amount')">
                                                <span class="text--success">+ {{ showAmount($bonus->amount) }} {{ $general->cur_text }}</span>
                                            </td>
                                            <td data-label="@lang('Status')">
                                                @if($bonus->paid)
                                                    <span class="badge badge--success">@lang('Paid')</span>
                                                @else
                                                    <span class="badge badge--warning">@lang('Pending')</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($bonuses->hasPages())
                            <div class="mt-3">
                                {{ paginateLinks($bonuses) }}
                            </div>
                        @endif
                    @else
                        <div class="text-center">
                            <h6 class="text-muted">@lang('No referral bonuses found')</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection