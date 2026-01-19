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
                                <th>@lang('Image')</th>
                                <th>@lang('Title')</th>
                                <th>@lang('Created At')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($blogs as $blog)
                                <tr>
                                    <td>{{ $blogs->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="user">
                                            <div class="thumb">
                                                <img src="{{ getImage('assets/images/frontend/blog/'.$blog->data_values->image, '400x200') }}" alt="@lang('image')">
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ __($blog->data_values->title) }}</td>
                                    <td>{{ showDateTime($blog->created_at, 'd M, Y h:i A') }}</td>
                                    <td>
                                        <a href="{{ route('admin.frontend.sections.element', ['blog', $blog->id]) }}" class="btn btn-sm btn-outline--primary">
                                            <i class="la la-pencil"></i> @lang('Edit')
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.blog.delete', $blog->id) }}" data-question="@lang('Are you sure to delete this post?')">
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
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($blogs->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($blogs) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection
