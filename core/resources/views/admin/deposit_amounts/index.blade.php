@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($depositAmounts as $depositAmount)
                                    <tr>
                                        <td data-label="@lang('Amount')">
                                            <span class="font-weight-bold">{{ $depositAmount->amount }}</span>
                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if($depositAmount->status)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <div class="button--group">
                                                <a href="{{ route('admin.deposit.amounts.edit', $depositAmount->id) }}" class="btn btn-sm btn-outline--primary">
                                                    <i class="la la-edit"></i> @lang('Edit')
                                                </a>
                                                
                                                <button type="button" class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.deposit.amounts.destroy', $depositAmount->id) }}" data-question="@lang('Are you sure to delete this deposit amount?')">
                                                    <i class="la la-trash"></i> @lang('Delete')
                                                </button>
                                                
                                                <button type="button" class="btn btn-sm btn-outline--{{ $depositAmount->status ? 'danger' : 'success' }} confirmationBtn" data-action="{{ route('admin.deposit.amounts.status', $depositAmount->id) }}" data-question="{{ $depositAmount->status ? 'Are you sure to deactivate this deposit amount?' : 'Are you sure to activate this deposit amount?' }}">
                                                    <i class="la la-{{ $depositAmount->status ? 'ban' : 'check' }}"></i> {{ $depositAmount->status ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </div>
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
                @if($depositAmounts->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($depositAmounts) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- NEW MODAL --}}
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">@lang('Add Deposit Amount')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.deposit.amounts.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Amount')</label>
                            <input type="number" name="amount" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- CONFIRM MODAL --}}
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.deposit.amounts.create') }}" class="btn btn-sm btn-outline--primary">
        <i class="las la-plus"></i>@lang('Add New')
    </a>
@endpush