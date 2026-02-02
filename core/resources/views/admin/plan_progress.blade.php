@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30">
  <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">@lang('Plan Progress') - {{ $user->fullname }} ({{ $user->email }})</h5>
            <a href="{{ route('admin.plan.subscription.s') }}" class="btn btn-sm btn-outline--primary">
                <i class="la la-arrow-left"></i> @lang('Back to Subscriptions')
            </a>
        </div>
        <div class="card-body">
            <!-- Plan Information -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">@lang('Plan Information')</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>@lang('Plan Name'):</strong> {{ $plan->name }}</p>
                            <p><strong>@lang('Plan Price'):</strong> {{ showAmount($plan->price) }} {{ $general->cur_text }}</p>
                            <p><strong>@lang('ROI Percentage'):</strong> {{ $plan->roi_percentage }}%</p>
                            <p><strong>@lang('Validity'):</strong> {{ $plan->validity }} @lang('Days')</p>
                            <p><strong>@lang('Status'):</strong>
                                @if($isActive)
                                    <span class="badge badge-success">@lang('Active')</span>
                                @else
                                    <span class="badge badge-danger">@lang('Completed/Expired')</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">@lang('Profit Summary')</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>@lang('Total Profits Added'):</strong> {{ showAmount($totalProfitsAdded) }} {{ $general->cur_text }}</p>
                            <p><strong>@lang('Expected Total Profits'):</strong> {{ showAmount($totalExpectedProfits) }} {{ $general->cur_text }}</p>
                            <p><strong>@lang('Remaining Profits'):</strong> {{ showAmount($remainingProfits) }} {{ $general->cur_text }}</p>
                            <p><strong>@lang('Days Elapsed'):</strong> {{ $daysElapsed }} / {{ $totalDays }}</p>
                            <p><strong>@lang('Remaining Days'):</strong> {{ $remainingDays }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profit Activity Log -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">@lang('Profit Activity Log')</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--sm">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('Date')</th>
                                    <th scope="col">@lang('Name of Profit')</th>
                                    <th scope="col">@lang('Amount')</th>
                                    <th scope="col">@lang('Time Added')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($profitActivities as $activity)
                                <tr>
                                    <td data-label="@lang('Date')">{{ $activity->created_at->format('Y-m-d') }}</td>
                                    <td data-label="@lang('Name of Profit')">{{ $activity->name }}</td>
                                    <td data-label="@lang('Amount')" class="font-weight-bold text-success">
                                        +{{ showAmount($activity->amount) }} {{ $general->cur_text }}
                                    </td>
                                    <td data-label="@lang('Time Added')">{{ $activity->created_at->format('H:i:s') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">@lang('No profit transactions recorded for this plan yet.')</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- User Current Wallet Balance -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card border-info">
                        <div class="card-body">
                            <h6>@lang('Current User Balances')</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <p><strong>@lang('Main Balance'):</strong> {{ showAmount($user->balance) }} {{ $general->cur_text }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>@lang('Profit Wallet'):</strong> {{ showAmount($user->profit_wallet) }} {{ $general->cur_text }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>@lang('Total Deposits'):</strong> {{ showAmount($user->deposits->sum('amount')) }} {{ $general->cur_text }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
