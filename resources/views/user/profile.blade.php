@extends('layouts.admin')
@php
    $profile = \App\Models\Utility::get_file('uploads/avatar');
    
    $users = \Auth::user();
@endphp
@section('page-title')
    {{ __('Profile Account') }}
@endsection
@push('custom-scripts')
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })
    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}</li>
@endsection
@section('content')
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#useradd-2"
                                class="list-group-item list-group-item-action border-0 ">{{ __('Personal info') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#useradd-3"
                                class="list-group-item list-group-item-action border-0">{{ __('Change Password') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div id="useradd-2" class="card">
                        <div class="card-header">
                            <h5>{{ __('Personal info') }}</h5>
                            <small class="text-muted">{{ __('Edit details about your personal information') }}</small>
                        </div>
                        {{ Form::model($userDetail, ['route' => ['update.account'], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                        <div class="card-body pb-0">

                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control font-style', 'placeholder' => __('Enter User Name')]) }}
                                        @error('name')
                                            <span class="invalid-name" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                                        {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Enter User Email')]) }}
                                        @error('email')
                                            <span class="invalid-email" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-lg-6 col-md-6 mt-2 mb-2">
                                    <div class="choose-files">
                                        <label for="avatar">
                                            <div class=" bg-primary company_logo_update" style="cursor: pointer;"> <i
                                                    class="ti ti-upload px-1"></i>{{ __('Choose file here') }}</div>
                                                    
                                            <input type="file" class="form-control file d-none" id="avatar" name="profile"
                                                data-filename="profiles"
                                                onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                                <span class="text-xs text-muted mb-5">{{__('Please upload a valid image file. Size of image should not be more than 2MB.')}}</span>
                                        </label>

                                    </div>
                                    <img src="{{ !empty($users->avatar) ? $profile . '/' . $users->avatar : $profile . '/avatar.png' }}"
                                        id="blah" width="25%" />
                                    <span class="profiles"></span>
                                </div>

                            </div>


                        </div>
                        <div class="card-footer">
                            <div class="text-end">
                                {{ Form::submit(__('Save Change'), ['class' => 'btn btn-print-invoice btn-primary ']) }}
                            </div>

                        </div>
                        {{ Form::close() }}

                    </div>

                    <div id="useradd-3" class="card">
                        <div class="card-header">
                            <h5>{{ __('Change Password') }}</h5>
                            <small class="text-muted">{{ __('Edit details about your Password') }}</small>
                        </div>
                        {{ Form::model($userDetail, ['route' => ['update.password', $userDetail->id], 'method' => 'post']) }}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('current_password', __('Current Password'), ['class' => 'form-label']) }}
                                        {{ Form::password('current_password', ['class' => 'form-control', 'placeholder' => __('Enter Current Password')]) }}
                                        @error('current_password')
                                            <span class="invalid-current_password" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('new_password', __('New Password'), ['class' => 'form-label']) }}
                                        {{ Form::password('new_password', ['class' => 'form-control', 'placeholder' => __('Enter New Password')]) }}
                                        @error('new_password')
                                            <span class="invalid-new_password" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('confirm_password', __('Re-type New Password'), ['class' => 'form-label']) }}
                                        {{ Form::password('confirm_password', ['class' => 'form-control', 'placeholder' => __('Enter Re-type New Password')]) }}
                                        @error('confirm_password')
                                            <span class="invalid-confirm_password" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            {{ Form::submit(__('Save Change'), ['class' => 'btn btn-print-invoice  btn-primary ']) }}
                        </div>
                        {{ Form::close() }}



                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
@endsection
