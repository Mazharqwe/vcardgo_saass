@extends('layouts.admin')
@php
    $profile=asset(Storage::url('uploads/avatar/'));
    $chatgpt_setting= App\Models\Utility::chatgpt_setting(\Auth::user()->creatorId());
@endphp
@section('page-title')
   {{__('Manage Users')}}
@endsection
@section('title')
    {{ $emailTemplate->name }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{__('Email Template')}}</li>
@endsection
@section('action-btn')
<div class="row">
    <div class="text-end">
        {{ Form::model($currEmailTempLang, ['route' => ['updateEmail.settings', $currEmailTempLang->parent_id], 'method' => 'PUT']) }}
        <div class="text-end">
            <div class="d-flex justify-content-end drp-languages">
                @if(isset($chatgpt_setting['chatgpt_key']) && (!empty($chatgpt_setting['chatgpt_key'])))
                <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end"
                    data-bs-placement="top">
                    <a href="#" data-size="lg" class="btn btn-sm btn-primary" data-ajax-popup-over="true"
                        data-url="{{ route('generate', ['email template']) }}" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="{{ __('Generate') }}" data-title="{{ __('Generate content with AI') }}">
                        <i class="fas fa-robot"></i>&nbsp;{{ __('Generate with AI') }}
                    </a>
                </div>  
                @endif
                
                @can('edit email template')
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item drp-language">
                        <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false"
                            id="dropdownLanguage">
                            
                            <span
                                class="drp-text hide-mob text-primary">{{ __('Locale: ') }}{{ ucFirst($languageData->fullName) }}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end"
                            aria-labelledby="dropdownLanguage">
                            @foreach (App\Models\Utility::languages() as $code => $lang)

                                <a href="{{ route('manage.email.language', [ $code,$emailTemplate->id]) }}"
                                    class="dropdown-item {{ $currEmailTempLang->lang == $code ? 'text-primary' : '' }}">{{ ucFirst($lang) }}</a>
                            @endforeach

                        </div>
                    </li>
                </ul>
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item drp-language">
                        <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false"
                            id="dropdownLanguage">
                            <span
                                class="drp-text hide-mob text-primary">{{ __('Template: ') }}{{ $emailTemplate->name }}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end"
                            aria-labelledby="dropdownLanguage">
                            @foreach ($EmailTemplates as $EmailTemplate)
                                <a href="{{ route('manage.email.language', [(Request::segment(2)?Request::segment(2):\Auth::user()->lang),$EmailTemplate->id]) }}"
                                    class="dropdown-item {{$EmailTemplate->name == $emailTemplate->name ? 'text-primary' : '' }}">{{ $EmailTemplate->name }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body ">
              
                    <h5 class="font-weight-bold pb-3 mt-4">{{ __('Placeholders') }}</h5>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class=" card-header card-body">
                                <div class="row text-xs">
                                    <div class="row">
                                        @if($emailTemplate->name=='User Created')
                                            <p class="col-md-4">{{ __('App URL') }} : <span
                                                    class="pull-right text-primary">{app_url}</span></p>
                                            <p class="col-md-4">{{ __('User Name') }} : <span
                                                    class="pull-right text-primary">{user_name}</span></p>
                                            <p class="col-md-4">{{ __('User Email') }} : <span
                                                    class="pull-right text-primary">{user_email}</span></p>
                                            <p class="col-md-4">{{ __('User Password') }} : <span
                                                    class="pull-right text-primary">{user_password}</span></p>
                                            <p class="col-md-4">{{ __('User Type') }} : <span
                                                    class="pull-right text-primary">{user_type}</span></p>
                                        @elseif($emailTemplate->name=='Appointment Created')  
                                            <p class="col-md-4">{{ __('App Name') }} : <span
                                                class="pull-right text-primary">{app_name}</span></p>
                                            <p class="col-md-4">{{ __('Appointment Name') }} : <span
                                                    class="pull-right text-primary">{appointment_name}</span></p>
                                            <p class="col-md-4">{{ __('Appointment Email') }} : <span
                                                    class="pull-right text-primary">{appointment_email}</span></p>
                                            <p class="col-md-4">{{ __('Appointment Phone') }} : <span
                                                    class="pull-right text-primary">{appointment_phone}</span></p>
                                            <p class="col-md-4">{{ __('Appointment Date') }} : <span
                                                    class="pull-right text-primary">{appointment_date}</span></p>
                                            <p class="col-md-4">{{ __('Appointment Time') }} : <span
                                                    class="pull-right text-primary">{appointment_time}</span></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            {{ Form::label('subject', __('Subject'), ['class' => 'col-form-label text-dark']) }}
                            {{ Form::text('subject', null, ['class' => 'form-control font-style', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('from', __('From'), ['class' => 'col-form-label text-dark']) }}
                            {{ Form::text('from', $emailTemplate->from, ['class' => 'form-control font-style', 'required' => 'required']) }}
                        </div>
                        <div class="form-group col-12">
                            {{ Form::label('content', __('Email Message'), ['class' => 'col-form-label text-dark']) }}
                            {{ Form::textarea('content', $currEmailTempLang->content, ['class' => 'summernote-simple']) }}
                        </div>
                    </div> 
                    <div class="card-footer">
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-12 text-end">
                               {{ Form::hidden('lang', null) }}
                               {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-print-invoice  btn-primary m-r-10']) }}
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div><br><br><br>
    </div>
</div>

@endsection
@push('custom-scripts')
<script src="{{ asset('custom/libs/summernote/summernote-bs4.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.summernote').summernote();
    });
</script>
@endpush
