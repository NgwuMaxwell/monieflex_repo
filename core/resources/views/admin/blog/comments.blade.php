@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Post')</th>
                                <th>@lang('Comment Preview')</th>
                                <th>@lang('Date')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($comments as $comment)
                                <tr>
                                    <td>{{ $comments->firstItem() + $loop->index }}</td>
                                    <td>
                                        <span class="fw-bold">{{ $comment->user->username ?? 'N/A' }}</span>
                                        <br>
                                        <span class="small">{{ $comment->user->email ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="d-block">{{ strLimit(__($comment->blog->data_values->title ?? 'N/A'), 30) }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted small">{{ strLimit($comment->comment, 50) }}</span>
                                    </td>
                                    <td>{{ showDateTime($comment->created_at, 'd M, Y') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline--primary viewCommentBtn" 
                                            data-id="{{ $comment->id }}"
                                            data-user="{{ $comment->user->username ?? $comment->user->email }}"
                                            data-email="{{ $comment->user->email }}"
                                            data-post="{{ __($comment->blog->data_values->title ?? 'N/A') }}"
                                            data-comment="{{ $comment->comment }}"
                                            data-date="{{ showDateTime($comment->created_at, 'd M, Y h:i A') }}"
                                            data-post-url="{{ route('user.blog.detail', $comment->blog_id) }}">
                                            <i class="la la-eye"></i> @lang('View Comment')
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.blog.comment.delete', $comment->id) }}" data-question="@lang('Are you sure to delete this comment?')">
                                            <i class="la la-trash"></i> @lang('Delete')
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage ?? 'No comments found') }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($comments->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($comments) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Comment Details Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Comment Details')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">@lang('Commenter')</h6>
                        <p class="mb-1"><strong id="modalUser"></strong></p>
                        <p class="small text-muted mb-0" id="modalEmail"></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">@lang('Blog Post')</h6>
                        <p id="modalPost"></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">@lang('Comment')</h6>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0" id="modalComment" style="white-space: pre-wrap;"></p>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">@lang('Posted On')</h6>
                        <p id="modalDate"></p>
                    </div>
                    
                    <div>
                        <a href="#" id="modalPostLink" class="btn btn-sm btn--primary" target="_blank">
                            <i class="la la-external-link"></i> @lang('View Blog Post')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('script')
<script>
    (function ($) {
        "use strict";
        
        $('.viewCommentBtn').on('click', function() {
            var modal = $('#commentModal');
            
            $('#modalUser').text($(this).data('user'));
            $('#modalEmail').text($(this).data('email'));
            $('#modalPost').text($(this).data('post'));
            $('#modalComment').text($(this).data('comment'));
            $('#modalDate').text($(this).data('date'));
            $('#modalPostLink').attr('href', $(this).data('post-url'));
            
            modal.modal('show');
        });
        
    })(jQuery);
</script>
@endpush
