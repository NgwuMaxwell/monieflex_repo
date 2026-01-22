@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('Notices Management')</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Content')</th>
                                    <th>@lang('Image')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Sort Order')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notices as $notice)
                                    <tr>
                                        <td data-label="@lang('Title')">{{ Str::limit($notice->title, 30) }}</td>
                                        <td data-label="@lang('Content')">{{ Str::limit($notice->content, 50) }}</td>
                                        <td data-label="@lang('Image')">
                                            @if($notice->image)
                                                <img src="{{ getImage('assets/images/notice/' . $notice->image) }}" alt="Notice Image" width="50" height="30" style="object-fit: cover;">
                                            @else
                                                <span class="text-muted">@lang('No Image')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Status')">
                                            <span class="badge badge--{{ $notice->status ? 'success' : 'danger' }}">
                                                {{ $notice->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td data-label="@lang('Sort Order')">{{ $notice->sort_order }}</td>
                                        <td data-label="@lang('Action')">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.notices.edit', $notice->id) }}" class="btn btn-sm btn-outline--primary">
                                                    <i class="las la-edit"></i> @lang('Edit')
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline--{{ $notice->status ? 'danger' : 'success' }}"
                                                        onclick="if(confirm('Are you sure?')) window.location.href='{{ route('admin.notices.status', $notice->id) }}'">
                                                    <i class="las la-{{ $notice->status ? 'ban' : 'check' }}"></i>
                                                    {{ $notice->status ? 'Disable' : 'Enable' }}
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline--danger"
                                                        onclick="if(confirm('Are you sure you want to delete this notice?')) window.location.href='{{ route('admin.notices.delete', $notice->id) }}'">
                                                    <i class="las la-trash"></i> @lang('Delete')
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage ?? 'No notices found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($notices->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($notices) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.notices.create') }}" class="btn btn-sm btn-outline--primary">
        <i class="las la-plus"></i> @lang('Add New Notice')
    </a>
@endpush
