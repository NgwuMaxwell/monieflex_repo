@extends('admin.layouts.app')

@push('style')
    <style>
        .message-preview {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
@endpush

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Message')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contactMessages as $message)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $message->first_name }} {{ $message->last_name }}</span>
                                        </td>
                                        <td>
                                            {{ $message->email }}
                                        </td>
                                        <td>
                                            <div class="message-preview" style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $message->message }}">
                                                {{ $message->message }}
                                            </div>
                                        </td>
                                        <td>
                                            {{ showDateTime($message->created_at) }}<br>
                                            <small class="text-muted">{{ diffForHumans($message->created_at) }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $statusBadge = '';
                                                switch($message->status) {
                                                    case 'unread':
                                                        $statusBadge = '<span class="badge badge--warning">@lang("Unread")</span>';
                                                        break;
                                                    case 'read':
                                                        $statusBadge = '<span class="badge badge--info">@lang("Read")</span>';
                                                        break;
                                                    case 'replied':
                                                        $statusBadge = '<span class="badge badge--success">@lang("Replied")</span>';
                                                        break;
                                                }
                                                echo $statusBadge;
                                            @endphp
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-outline--info btn-sm view-btn" data-id="{{ $message->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('View Message')">
                                                    <i class="bi bi-eye"></i> @lang('View')
                                                </button>
                                                <button class="btn btn-outline--danger btn-sm delete-btn" data-id="{{ $message->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Delete Message')">
                                                    <i class="bi bi-trash"></i> @lang('Delete')
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
                @if ($contactMessages->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($contactMessages) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- View Message Modal -->
    <div class="modal fade" id="viewMessageModal" tabindex="-1" aria-labelledby="viewMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewMessageModalLabel">@lang('View Message')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="messageContent">
                        <!-- Message content will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">@lang('Confirmation')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure you want to delete this message?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">@lang('Yes')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <form action="" method="GET" class="form-inline float-sm-end">
        <div class="input-group">
            <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search by name, email or message')" value="{{ request()->search }}">
            <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';

            // View Message Modal
            $('.view-btn').on('click', function() {
                var messageId = $(this).data('id');
                var modal = $('#viewMessageModal');
                
                // Show loading state
                $('#messageContent').html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
                modal.modal('show');

                console.log('Attempting to fetch message with ID:', messageId);
                console.log('URL:', '{{ route("admin.contact.messages.show", "") }}/' + messageId);

                $.ajax({
                    url: '{{ route("admin.contact.messages.show", "") }}/' + messageId,
                    type: 'GET',
                    success: function(response) {
                        console.log('Response received:', response);
                        
                        if (response.success) {
                            var message = response.data;
                            var content = `
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">@lang('Full Name')</label>
                                            <p class="form-control-plaintext">${message.first_name} ${message.last_name}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">@lang('Email')</label>
                                            <p class="form-control-plaintext"><a href="mailto:${message.email}">${message.email}</a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">@lang('Date Submitted')</label>
                                            <p class="form-control-plaintext">${message.created_at}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">@lang('Status')</label>
                                            <span class="badge ${getStatusBadgeClass(message.status)}">${message.status}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">@lang('Message')</label>
                                            <div class="border p-3" style="background-color: #f8f9fa; border-radius: 5px;">
                                                ${message.message}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#messageContent').html(content);
                        } else {
                            $('#messageContent').html('<div class="alert alert-danger">Error loading message: ' + (response.message || 'Unknown error') + '</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', xhr, status, error);
                        $('#messageContent').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                    }
                });
            });

            // Delete Message Confirmation
            var deleteMessageId = null;
            var deleteButton = null;

            $('.delete-btn').on('click', function() {
                deleteMessageId = $(this).data('id');
                deleteButton = $(this);
                console.log('Delete button clicked for message ID:', deleteMessageId);
                $('#deleteModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function() {
                if (deleteMessageId) {
                    console.log('Confirming delete for message ID:', deleteMessageId);
                    console.log('Delete URL:', '{{ route("admin.contact.messages.delete", "") }}/' + deleteMessageId);
                    
                    $.ajax({
                        url: '{{ route("admin.contact.messages.delete", "") }}/' + deleteMessageId,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Delete response:', response);
                            $('#deleteModal').modal('hide');
                            if (response.success) {
                                deleteButton.closest('tr').fadeOut(300, function() {
                                    $(this).remove();
                                });
                                notify('success', response.message);
                            } else {
                                notify('error', response.message || '@lang("Error deleting message")');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('Delete AJAX Error:', xhr, status, error);
                            $('#deleteModal').modal('hide');
                            notify('error', 'Delete Error: ' + error);
                        }
                    });
                }
            });

            function getStatusBadgeClass(status) {
                switch(status) {
                    case 'unread': return 'badge-warning';
                    case 'read': return 'badge-info';
                    case 'replied': return 'badge-success';
                    default: return 'badge-secondary';
                }
            }
        })(jQuery);
    </script>
@endpush