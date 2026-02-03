@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Image')</label>
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage('/', '/275x180') }})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                <label for="profilePicUpload1" class="bg--success">@lang('Upload Image')</label>
                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg'), @lang('png')</b>. @lang('Image will be resized into 1920x1280px') </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Heading')</label>
                                    <input type="text" class="form-control" name="heading" value="{{ old('heading') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Subheading')</label>
                                    <textarea class="form-control" name="subheading" rows="4" required>{{ old('subheading') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Order')</label>
                                    <input type="number" class="form-control" name="order" value="{{ old('order', 0) }}" min="0" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Status')</label>
                                    <input type="checkbox" data-width="100%" data-height="40px" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')" name="status" checked>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Create Banner')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.banner.index') }}" class="btn btn-outline--primary">
        <i class="las la-angle-double-left"></i>@lang('Go Back')
    </a>
@endpush