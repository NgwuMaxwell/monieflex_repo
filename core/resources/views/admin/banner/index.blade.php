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
                                    <th>@lang('Image')</th>
                                    <th>@lang('Heading')</th>
                                    <th>@lang('Subheading')</th>
                                    <th>@lang('Order')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banners as $banner)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage('assets/images/frontend/banner/' . $banner->image) }}" alt="@lang('image')">
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ __($banner->heading) }}</td>
                                        <td>{{ strLimit(strip_tags($banner->subheading), 50) }}</td>
                                        <td>{{ $banner->sort_order }}</td>
                                        <td>
                                            @if($banner->status)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="button-group">
                                                <a href="{{ route('admin.banner.edit', $banner->id) }}" class="btn btn-sm btn-outline--primary">
                                                    <i class="la la-pen"></i> @lang('Edit')
                                                </a>
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.banner.destroy', $banner->id) }}" data-question="@lang('Are you sure to delete this banner?')">
                                                    <i class="la la-trash"></i> @lang('Delete')
                                                </button>
                                                <button class="btn btn-sm btn-outline--warning" onclick="toggleStatus({{ $banner->id }})">
                                                    <i class="la la-toggle-on"></i> @lang('Toggle Status')
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
                @if($banners->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($banners) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Reorder Modal --}}
    <div class="modal fade" id="reorderModal" tabindex="-1" role="dialog" aria-labelledby="reorderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reorderModalLabel">@lang('Reorder Banners')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Drag and drop the banners to reorder them.')</p>
                    <div id="bannerList" class="list-group">
                        @foreach($banners as $banner)
                            <div class="list-group-item" data-id="{{ $banner->id }}">
                                <i class="fas fa-grip-vertical mr-2"></i>
                                <img src="{{ getImage('assets/images/frontend/banner/' . $banner->image) }}" width="50" height="30" class="mr-2">
                                {{ __($banner->heading) }}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancel')</button>
                    <button type="button" class="btn btn-primary" id="saveOrder">@lang('Save Order')</button>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.banner.edit') }}" class="btn btn-outline--primary">
        <i class="las la-edit"></i>@lang('Edit Banner')
    </a>
    <button class="btn btn-outline--warning" data-toggle="modal" data-target="#reorderModal">
        <i class="las la-sort"></i>@lang('Reorder')
    </button>
@endpush

@push('script')
    <script>
        function toggleStatus(id) {
            $.ajax({
                url: '{{ route("admin.banner.status", "") }}/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                }
            });
        }

        // Drag and drop functionality
        $(document).ready(function() {
            $('#saveOrder').on('click', function() {
                var banners = [];
                $('#bannerList .list-group-item').each(function(index) {
                    banners.push({
                        id: $(this).data('id'),
                        order: index
                    });
                });

                $.ajax({
                    url: '{{ route("admin.banner.reorder") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        banners: banners
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        }
                    }
                });
            });
        });
    </script>
@endpush