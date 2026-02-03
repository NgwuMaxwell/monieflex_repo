@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">@lang('Banner Carousel Management')</h5>
                    <button type="button" class="btn btn--primary" id="addBannerItem">
                        <i class="las la-plus"></i> @lang('Add Banner Item')
                    </button>
                </div>
                <form action="{{ route('admin.banner.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- Carousel Settings -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6>@lang('Carousel Settings')</h6>
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Animation Type')</label>
                                    <select class="form-control" name="animation_type">
                                        <option value="slide" {{ isset($settings) && $settings->animation_type == 'slide' ? 'selected' : '' }}>@lang('Slide')</option>
                                        <option value="fade" {{ isset($settings) && $settings->animation_type == 'fade' ? 'selected' : '' }}>@lang('Fade')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Slide Direction')</label>
                                    <select class="form-control" name="slide_direction">
                                        <option value="left" {{ isset($settings) && $settings->slide_direction == 'left' ? 'selected' : '' }}>@lang('Left')</option>
                                        <option value="right" {{ isset($settings) && $settings->slide_direction == 'right' ? 'selected' : '' }}>@lang('Right')</option>
                                        <option value="up" {{ isset($settings) && $settings->slide_direction == 'up' ? 'selected' : '' }}>@lang('Up')</option>
                                        <option value="down" {{ isset($settings) && $settings->slide_direction == 'down' ? 'selected' : '' }}>@lang('Down')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Display Duration (seconds)')</label>
                                    <input type="number" class="form-control" name="display_duration" value="{{ isset($settings) ? $settings->display_duration : 5 }}" min="1" max="30">
                                </div>
                            </div>
                        </div>

                        <!-- Banner Items -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6>@lang('Banner Items')</h6>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div id="bannerItemsContainer">
                                    @if(isset($bannerItems) && $bannerItems->count() > 0)
                                        @foreach($bannerItems as $index => $item)
                                            <div class="banner-item-card card mb-3" data-index="{{ $index }}">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>@lang('Image')</label>
                                                                <input type="file" name="banner_items[{{ $index }}][image]" class="form-control" accept=".jpg,.jpeg,.png">
                                                                <small class="text-muted">Supported files: jpeg, jpg, png. Will be resized to 1920x1280 px.</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>@lang('Heading')</label>
                                                                        <input type="text" class="form-control" name="banner_items[{{ $index }}][heading]" value="{{ $item->heading }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>@lang('Order')</label>
                                                                        <input type="number" class="form-control" name="banner_items[{{ $index }}][sort_order]" value="{{ $item->sort_order }}" min="0" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>@lang('Subheading')</label>
                                                                        <textarea class="form-control" name="banner_items[{{ $index }}][subheading]" rows="3">{{ $item->subheading }}</textarea>
                                                                    </div>
                                                                </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>@lang('Status')</label>
                                                                    <input type="hidden" name="banner_items[{{ $index }}][status]" value="0">
                                                                    <input type="checkbox" name="banner_items[{{ $index }}][status]" value="1" {{ $item->status ? 'checked' : '' }} data-width="100%" data-height="40px" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')">
                                                                </div>
                                                            </div>
                                                                <div class="col-md-6 text-end">
                                                                    <button type="button" class="btn btn--danger remove-banner-item mt-4">
                                                                        <i class="las la-trash"></i> @lang('Remove')
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Always show at least one banner item when no records exist -->
                                        <div class="banner-item-card card mb-3" data-index="0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>@lang('Image')</label>
                                                            <input type="file" name="banner_items[0][image]" class="form-control" accept=".jpg,.jpeg,.png">
                                                            <small class="text-muted">Supported files: jpeg, jpg, png. Will be resized to 1920x1280 px.</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>@lang('Heading')</label>
                                                                    <input type="text" class="form-control" name="banner_items[0][heading]" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>@lang('Order')</label>
                                                                    <input type="number" class="form-control" name="banner_items[0][sort_order]" value="0" min="0" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>@lang('Subheading')</label>
                                                                    <textarea class="form-control" name="banner_items[0][subheading]" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>@lang('Status')</label>
                                                                    <input type="hidden" name="banner_items[0][status]" value="0">
                                                                    <input type="checkbox" name="banner_items[0][status]" value="1" checked data-width="100%" data-height="40px" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 text-end">
                                                                <button type="button" class="btn btn--danger remove-banner-item mt-4" disabled>
                                                                    <i class="las la-trash"></i> @lang('Remove')
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Save Banner Carousel')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Banner Item Template -->
    <template id="bannerItemTemplate">
        <div class="banner-item-card card mb-3" data-index="__INDEX__">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('Image')</label>
                            <input type="file" name="banner_items[__INDEX__][image]" class="form-control" accept=".jpg,.jpeg,.png">
                            <small class="text-muted">Supported files: jpeg, jpg, png. Will be resized to 1920x1280 px.</small>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Heading')</label>
                                    <input type="text" class="form-control" name="banner_items[__INDEX__][heading]" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Order')</label>
                                    <input type="number" class="form-control" name="banner_items[__INDEX__][sort_order]" value="0" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Subheading')</label>
                                    <textarea class="form-control" name="banner_items[__INDEX__][subheading]" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Status')</label>
                                    <input type="hidden" name="banner_items[__INDEX__][status]" value="0">
                                    <input type="checkbox" name="banner_items[__INDEX__][status]" value="1" checked data-width="100%" data-height="40px" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')">
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn btn--danger remove-banner-item mt-4">
                                    <i class="las la-trash"></i> @lang('Remove')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.banner.index') }}" class="btn btn-outline--primary">
        <i class="las la-angle-double-left"></i>@lang('Go Back')
    </a>
@endpush

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let bannerIndex = {{ isset($bannerItems) ? $bannerItems->count() : 0 }};

        // Add new banner item
        document.getElementById('addBannerItem').addEventListener('click', function() {
            const template = document.getElementById('bannerItemTemplate');
            const clone = template.content.cloneNode(true);
            
            // Replace __INDEX__ with actual index
            const html = clone.innerHTML.replace(/__INDEX__/g, bannerIndex);
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html;
            
            document.getElementById('bannerItemsContainer').appendChild(wrapper.firstElementChild);
            
            // Initialize toggle buttons for new items
            initToggleButtons();
            bannerIndex++;
        });

        // Remove banner item
        document.getElementById('bannerItemsContainer').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-banner-item') || e.target.closest('.remove-banner-item')) {
                const card = e.target.closest('.banner-item-card');
                if (document.querySelectorAll('.banner-item-card').length > 1) {
                    card.remove();
                } else {
                    alert('@lang("You must have at least one banner item")');
                }
            }
        });

        // Initialize toggle buttons
        function initToggleButtons() {
            const toggles = document.querySelectorAll('input[type="checkbox"][data-bs-toggle="toggle"]');
            toggles.forEach(toggle => {
                if (!toggle.hasAttribute('data-initialized')) {
                    $(toggle).bootstrapToggle();
                    toggle.setAttribute('data-initialized', 'true');
                }
            });
        }

        // Initialize existing toggles
        initToggleButtons();
    });
</script>
@endpush
