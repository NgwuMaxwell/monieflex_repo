@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Title')</th>
                                <th>@lang('URL')</th>
                                <th>@lang('Icon')</th>
                                <th>@lang('Order')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($links as $link)
                                <tr>
                                    <td>{{ $link->title }}</td>
                                    <td><small>{{ $link->url }}</small></td>
                                    <td>{{ $link->icon ?? 'N/A' }}</td>
                                    <td>{{ $link->order }}</td>
                                    <td>
                                        @php
                                            echo $link->status ? '<span class="badge badge--success">Active</span>' : '<span class="badge badge--warning">Inactive</span>'
                                        @endphp
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline--primary editBtn"
                                                data-id="{{ $link->id }}"
                                                data-title="{{ $link->title }}"
                                                data-url="{{ $link->url }}"
                                                data-icon="{{ $link->icon }}"
                                                data-order="{{ $link->order }}"
                                                data-status="{{ $link->status }}"
                                                data-type="{{ $link->type }}">
                                            <i class="la la-pencil"></i> @lang('Edit')
                                        </button>

                                        <button type="button" class="btn btn-sm btn-outline--{{ $link->status ? 'warning' : 'success' }} toggleStatusBtn"
                                                data-id="{{ $link->id }}"
                                                data-status="{{ $link->status }}">
                                            <i class="la la-{{ $link->status ? 'eye-slash' : 'eye' }}"></i> 
                                            @lang($link->status ? 'Deactivate' : 'Activate')
                                        </button>

                                        <button type="button" class="btn btn-sm btn-outline--danger deleteBtn"
                                                data-id="{{ $link->id }}">
                                            <i class="la la-trash"></i> @lang('Delete')
                                        </button>
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
                @if ($links->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($links) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add New Link')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.dashboard.links.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Title')</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('URL')</label>
                            <input type="text" class="form-control" name="url" placeholder="https://example.com" required>
                            <small class="text-muted">@lang('Full URL including https://')</small>
                        </div>

                        <div class="form-group">
                            <label>@lang('Icon (Optional)')</label>
                            <input type="text" class="form-control" name="icon" placeholder="assets/img/icon-service.png">
                            <small class="text-muted">@lang('Path to icon image')</small>
                        </div>

                        <input type="hidden" name="type" value="{{ request()->routeIs('admin.dashboard.links.service') ? 'service' : 'contact' }}">

                        <div class="form-group">
                            <label>@lang('Order')</label>
                            <input type="number" class="form-control" name="order" value="0">
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                                <label class="form-check-label" for="status">
                                    @lang('Active')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit Link')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST" id="editForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Title')</label>
                            <input type="text" class="form-control" name="title" id="edit_title" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('URL')</label>
                            <input type="text" class="form-control" name="url" id="edit_url" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('Icon (Optional)')</label>
                            <input type="text" class="form-control" name="icon" id="edit_icon">
                        </div>

                        <div class="form-group">
                            <label>@lang('Order')</label>
                            <input type="number" class="form-control" name="order" id="edit_order">
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status" id="edit_status">
                                <label class="form-check-label" for="edit_status">
                                    @lang('Active')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="GET" id="deleteForm">
                    @csrf
                    <div class="modal-body">
                        <p>@lang('Are you sure you want to delete this link?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--danger">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal></x-confirmation-modal>
@endsection

@push('breadcrumb-plugins')
    <button type="button" class="btn btn-sm btn-outline--primary" data-bs-toggle="modal" data-bs-target="#createModal">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";

            $('.editBtn').on('click', function () {
                var modal = $('#editModal');
                var data = $(this).data();
                
                modal.find('#edit_title').val(data.title);
                modal.find('#edit_url').val(data.url);
                modal.find('#edit_icon').val(data.icon);
                modal.find('#edit_order').val(data.order);
                modal.find('#edit_status').prop('checked', data.status == 1);
                
                var action = "{{ route('admin.dashboard.links.update', ':id') }}";
                action = action.replace(':id', data.id);
                modal.find('#editForm').attr('action', action);
                
                modal.modal('show');
            });

            $('.deleteBtn').on('click', function () {
                var modal = $('#deleteModal');
                var id = $(this).data('id');
                
                var action = "{{ route('admin.dashboard.links.delete', ':id') }}";
                action = action.replace(':id', id);
                modal.find('#deleteForm').attr('action', action);
                
                modal.modal('show');
            });

            $('.toggleStatusBtn').on('click', function () {
                var id = $(this).data('id');
                var url = "{{ route('admin.dashboard.links.toggle', ':id') }}";
                url = url.replace(':id', id);
                window.location.href = url;
            });

        })(jQuery);
    </script>
@endpush
