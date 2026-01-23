@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30">
  <div class="col-md-12">
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table--light style--two" style="min-width: 1200px;">
                    <thead>
                        <tr>
                            <th scope="col">@lang('Name')</th>
                            <th scope="col">@lang('Price')</th>
                            <th scope="col">@lang('Limit/Day')</th>
                            <th scope="col">@lang('Validity')</th>
                            <th scope="col">@lang('ROI %')</th>
                            <th scope="col">@lang('Return Capital')</th>
                            <th scope="col">@lang('Referral Commission')</th>
                            <th scope="col">@lang('Status')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                        <tr>
                            <td data-label="@lang('Name')">{{$plan->name}}</td>
                            <td data-label="@lang('Price')" class="font-weight-bold">{{ showAmount($plan->price) }} {{$general->cur_text}}</td>

                            <td data-label="@lang('Limit/Day')">{{ $plan->daily_limit}} @lang('PTC')</td>
                            <td data-label="@lang('Validity')">{{ $plan->validity}} @lang('Day')</td>
                            <td data-label="@lang('ROI %')">{{ $plan->roi_percentage }}%</td>
                            <td data-label="@lang('Return Capital')">
                                @if($plan->return_capital)
                                    <span class="badge badge--success">@lang('Yes')</span>
                                @else
                                    <span class="badge badge--danger">@lang('No')</span>
                                @endif
                            </td>
                            <td data-label="@lang('Referral Commission')">@lang('up to') <span class="font-weight-bold text-primary px-3">{{ $plan->ref_level }} </span>@lang('level')</td>
                            <td data-label="@lang('Status')">
                                @if($plan->status == 1)
                                    <span class="badge badge--success">@lang('Active')</span>
                                    @else
                                    <span class="badge badge--danger">
                                        @lang('Inactive')
                                    </span>
                                @endif
                            </td>
                            <td data-label="@lang('Action')">
                                <button class="btn btn-outline--primary btn-sm planBtn" data-id="{{ $plan->id }}" data-name="{{ $plan->name }}" data-price="{{ getAmount($plan->price) }}" data-daily_limit="{{ $plan->daily_limit }}" data-validity="{{ $plan->validity }}" data-roi_percentage="{{ $plan->roi_percentage }}" data-return_capital="{{ $plan->return_capital }}" data-status="{{ $plan->status }}" data-ref_level="{{ $plan->ref_level}}" data-image="{{ $plan->image }}" data-act="Edit">
                                    <i class="la la-pencil"></i> @lang('Edit')
                                </button>
                                <a class="btn btn-outline--danger btn-sm" href="{{ route('admin.plan.delete', $plan->id) }}" onclick="return confirm('Are you sure you want to delete this plan?')">
                                    <i class="la la-trash"></i> @lang('Delete')
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="planModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title"><span class="act"></span> @lang('Subscription Plan')</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
            </div>
            <form action="{{ route('admin.plan.save') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">@lang('Name') </label>
                        <input type="text" class="form-control" name="name" placeholder="@lang('Plan Name')" required>
                    </div>
                    <div class="form-group">
                        <label for="price">@lang('Price') </label>
                        <div class="input-group">
                            <input type="text" class="form-control has-append" name="price" placeholder="@lang('Price of Plan')" required>
                            <div class="input-group-text">{{ $general->cur_text }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="daily_limit">@lang('Daily Ad Limit')</label>
                        <input type="number" class="form-control" name="daily_limit" placeholder="@lang('Daily Ad Limit')" required>
                    </div>
                    <div class="form-group">
                        <label for="daily_limit">@lang('Validity')</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="validity" placeholder="@lang('Validity')" required>
                            <div class="input-group-text">@lang('Days')</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="roi_percentage">@lang('ROI Percentage')</label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control" name="roi_percentage" placeholder="@lang('ROI Percentage')" required>
                            <div class="input-group-text">%</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="return_capital">@lang('Return Capital')</label>
                        <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')" name="return_capital">
                        <small class="text-muted">@lang('If enabled, the plan price will be returned to profit wallet when the last profit is added')</small>
                    </div>
                    <div class="form-group">
                        <label for="details">@lang('Referral Commission') </label>
                        <select name="ref_level" class="form-control" required>
                            <option value="0"> @lang('NO Referral Commission')</option>
                            @for($i = 1; $i <= $levels; $i++)
                            <option value="{{$i}}"> @lang('Up to') {{$i}}  @lang('Level')</option>
                            @endfor
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="status">@lang('Status')</label>
                        <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="status">
                    </div>
                    <div class="form-group">
                        <label for="image">@lang('Image')</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <small>@lang('Supported formats: jpeg, png, jpg, gif. Max size: 2MB')</small>
                        <img class="img-thumbnail mt-2 current-image" width="100" style="display:none">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary w-100">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
.table-responsive::-webkit-scrollbar {
    height: 8px;
}
.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}
.table-responsive::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}
.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
@endpush

@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary btn-sm planBtn" data-id="0" data-act="Add" data-bs-toggle="modal" data-bs-target="#planModal"><i class="las la-plus"></i> @lang('Add New')</button>
@endpush


@push('script')
<script>
    (function($){
        "use strict";
        $('.planBtn').on('click', function() {
            var modal = $('#planModal');
            modal.find('.act').text($(this).data('act'));
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('input[name=name]').val($(this).data('name'));
            modal.find('input[name=price]').val($(this).data('price'));
            modal.find('input[name=daily_limit]').val($(this).data('daily_limit'));
            modal.find('input[name=validity]').val($(this).data('validity'));
            modal.find('input[name=roi_percentage]').val($(this).data('roi_percentage'));
            modal.find('input[name=return_capital]').bootstrapToggle($(this).data('return_capital') == 1 ? 'on' : 'off');
            modal.find('input[name=status]').bootstrapToggle($(this).data('status') == 1 ? 'on' : 'off');
            modal.find('select[name=ref_level]').val($(this).data('ref_level'));
            if($(this).data('id') == 0){
                modal.find('form')[0].reset();
                modal.find('.current-image').hide();
            } else {
                if($(this).data('image')){
                    modal.find('.current-image').attr('src', '/assets/images/plan/' + $(this).data('image')).show();
                } else {
                    modal.find('.current-image').hide();
                }
            }
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush
