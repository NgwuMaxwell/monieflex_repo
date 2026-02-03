@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('carousel.settings.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Animation Type')</label>
                                    <select class="form-control" name="animation_type" required>
                                        <option value="slide" {{ $settings->animation_type == 'slide' ? 'selected' : '' }}>@lang('Slide')</option>
                                        <option value="fade" {{ $settings->animation_type == 'fade' ? 'selected' : '' }}>@lang('Fade')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Direction')</label>
                                    <select class="form-control" name="direction" required>
                                        <option value="left" {{ $settings->direction == 'left' ? 'selected' : '' }}>@lang('Left')</option>
                                        <option value="right" {{ $settings->direction == 'right' ? 'selected' : '' }}>@lang('Right')</option>
                                        <option value="up" {{ $settings->direction == 'up' ? 'selected' : '' }}>@lang('Up')</option>
                                        <option value="down" {{ $settings->direction == 'down' ? 'selected' : '' }}>@lang('Down')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Display Duration (seconds)')</label>
                                    <input type="number" class="form-control" name="display_duration" value="{{ $settings->display_duration }}" min="1" max="60" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Update Settings')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.banner.index') }}" class="btn btn-outline--primary">
        <i class="las la-angle-double-left"></i>@lang('Go Back to Banners')
    </a>
@endpush