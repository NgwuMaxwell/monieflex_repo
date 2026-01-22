Let me update the task progress and provide a summary of what has been implemented.@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Plan Name')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Purchase Date')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($subscriptions as $subscription)
                                @php
                                    // Extract plan name from transaction details
                                    preg_match('/Subscribe\s+(.+?)\s+Plan/', $subscription->details, $matches);
                                    $planName = $matches[1] ?? 'Plan';
                                    
                                    // Check if subscription is active
                                    $isActive = $subscription->user && $subscription->user->expire_date && $subscription->user->expire_date > now();
                                @endphp
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ $subscription->user->username ?? 'N/A' }}</span>
                                        <br>
                                        <span class="small">
                                            <a href="{{ route('admin.users.detail', $subscription->user_id) }}"><span>@</span>{{ $subscription->user->username ?? 'N/A' }}</a>
                                        </span>
                                    </td>
                                    <td>{{ $subscription->user->email ?? 'N/A' }}</td>
                                    <td><span class="fw-bold">{{ $planName }}</span></td>
                                    <td>
                                        <span class="fw-bold">{{ showAmount($subscription->amount) }}</span> {{ __($general->cur_text) }}
                                    </td>
                                    <td>{{ showDateTime($subscription->created_at, 'd M, Y') }}</td>
                                    <td>
                                        @if($isActive)
                                            <span class="badge badge--success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge--secondary">@lang('Completed')</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button type="button" class="btn btn-sm btn-outline--primary manageBtn"
                                                    data-id="{{ $subscription->id }}"
                                                    data-url="{{ route('admin.plan.subscription.details', $subscription->id) }}">
                                                <i class="la la-cog"></i> @lang('Manage')
                                            </button>
                                            <a href="{{ route('admin.plan.subscription.progress', [$subscription->user_id, $subscription->user->plan_id ?? 1]) }}"
                                               class="btn btn-sm btn-outline--success">
                                                <i class="la la-eye"></i> @lang('View Progress')
                                            </a>
                                        </div>
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
                @if($subscriptions->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($subscriptions) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Manage Subscription Modal --}}
    <div id="manageModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Manage Subscription')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form method="POST" id="updateForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('User')</label>
                                    <input type="text" class="form-control" id="modal_username" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email')</label>
                                    <input type="text" class="form-control" id="modal_email" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Plan Name')</label>
                                    <input type="text" class="form-control" id="modal_plan_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Amount Paid')</label>
                                    <input type="text" class="form-control" id="modal_amount" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Purchase Date')</label>
                                    <input type="text" class="form-control" id="modal_purchase_date" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Transaction ID')</label>
                                    <input type="text" class="form-control" id="modal_trx" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Validity Period (Days)') <span class="text-danger">*</span></label>
                                    <input type="number" name="validity" class="form-control" id="modal_validity" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Daily Task Limit') <span class="text-danger">*</span></label>
                                    <input type="number" name="daily_limit" class="form-control" id="modal_daily_limit" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Expiry Date')</label>
                                    <input type="text" class="form-control" id="modal_expire_date" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Status')</label>
                                    <input type="text" class="form-control" id="modal_status" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Update Subscription')</button>
                        <button type="button" class="btn btn--warning h-45 w-100 deactivateBtn" id="deactivateBtn">
                            @lang('Deactivate Subscription')
                        </button>
                        <button type="button" class="btn btn--danger h-45 w-100 deleteBtn" id="deleteBtn">
                            @lang('Delete Subscription')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center">
        <form action="" method="GET" class="form-inline">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="@lang('Username/Email')" value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
        <select class="form-control" id="statusFilter">
            <option value="">@lang('All Status')</option>
            <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>@lang('Active')</option>
            <option value="expired" {{ request()->status == 'expired' ? 'selected' : '' }}>@lang('Completed')</option>
        </select>
    </div>
@endpush

@push('script')
<script>
    (function ($) {
        "use strict";

        let subscriptionId = 0;

        $('.manageBtn').on('click', function () {
            subscriptionId = $(this).data('id');
            let url = $(this).data('url');

            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
                    $('#modal_username').val(response.user.username);
                    $('#modal_email').val(response.user.email);
                    $('#modal_plan_name').val(response.plan_name);
                    $('#modal_amount').val(response.subscription.amount + ' {{ $general->cur_text }}');
                    $('#modal_purchase_date').val(new Date(response.subscription.created_at).toLocaleDateString());
                    $('#modal_trx').val(response.subscription.trx);
                    $('#modal_validity').val(response.validity);
                    $('#modal_daily_limit').val(response.daily_limit);
                    $('#modal_expire_date').val(new Date(response.expire_date).toLocaleDateString());
                    $('#modal_status').val(response.is_active ? 'Active' : 'Completed');

                    // Update form action
                    $('#updateForm').attr('action', '{{ route("admin.plan.subscription.update", "") }}/' + subscriptionId);

                    $('#manageModal').modal('show');
                },
                error: function (error) {
                    notify('error', 'Error loading subscription details');
                }
            });
        });

        $('#deactivateBtn').on('click', function () {
            if (confirm('Are you sure you want to deactivate this subscription?')) {
                window.location.href = '{{ route("admin.plan.subscription.deactivate", "") }}/' + subscriptionId;
            }
        });

        $('#deleteBtn').on('click', function () {
            if (confirm('Are you sure you want to delete this subscription? This action cannot be undone.')) {
                window.location.href = '{{ route("admin.plan.subscription.delete", "") }}/' + subscriptionId;
            }
        });

        $('#statusFilter').on('change', function () {
            let status = $(this).val();
            let url = new URL(window.location.href);
            if (status) {
                url.searchParams.set('status', status);
            } else {
                url.searchParams.delete('status');
            }
            window.location.href = url.toString();
        });

    })(jQuery);
</script>
@endpush
