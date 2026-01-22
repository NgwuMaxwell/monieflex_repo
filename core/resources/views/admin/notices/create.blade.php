@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('Add New Notice')</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.notices.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Title') <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" placeholder="@lang('Enter notice title')" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Sort Order')</label>
                                    <input type="number" name="sort_order" class="form-control" placeholder="0" value="0" min="0">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Content') <span class="text-danger">*</span></label>
                                    <textarea name="content" class="form-control" rows="4" placeholder="@lang('Enter notice content')" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Image')</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    <small class="form-text text-muted">@lang('Supported formats: JPG, JPEG, PNG, GIF. Max size: 2MB')</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Status')</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="1" class="selectgroup-input" checked>
                                            <span class="selectgroup-button">@lang('Active')</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="status" value="0" class="selectgroup-input">
                                            <span class="selectgroup-button">@lang('Inactive')</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary w-100 h-45">@lang('Create Notice')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
