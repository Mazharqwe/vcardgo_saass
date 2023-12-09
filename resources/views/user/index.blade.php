@extends('layouts.admin')
@php
    // $profile=asset(Storage::url('uploads/avatar/'));
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
@endphp
@section('page-title')
    {{ __('Manage Users') }}
@endsection
@section('title')
    {{ __('Manage Users') }}
@endsection
@section('action-btn')
    @can('create user')
        <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end"
            data-bs-placement="top">
            <a href="#" data-size="md" data-url="{{ route('users.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip"
                title="{{ __('Create') }}" data-title="{{ __('Create New User') }}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
            @if (Auth::user()->type == 'company')
                <a href="{{ route('userlogs.index') }}" class="btn btn-sm btn-primary btn-icon m-1" data-size="lg"
                    data-bs-whatever="{{ __('UserlogDetail') }}"> <span class="text-white">
                        <i class="ti ti-user" data-bs-toggle="tooltip"
                            data-bs-original-title="{{ __('Userlog Detail') }}"></i></span>
                </a>
            @endif
        </div>
    @endcan
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('User') }}</li>
@endsection
@section('content')
    <div class="row">
        @foreach ($users as $user)
            <div class="col-xl-3 mb-3">
                <div class="card text-center">
                    <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                        <div class="border-0 pb-0 ">
                            <h6 class="mb-0">
                                <div class="badge p-2 px-3 rounded bg-primary">{{ ucfirst($user->type) }}</div>
                            </h6>
                        </div>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                <button type="button" class="btn" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="feather icon-more-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @can('edit user')
                                        <a href="#" class="dropdown-item user-drop"
                                            data-url="{{ route('users.edit', $user->id) }}" data-ajax-popup="true"
                                            data-title="{{ __('Update User') }}"><i class="ti ti-edit"></i><span
                                                class="ml-2">{{ __('Edit') }}</span></a>
                                    @endcan
                                    @can('change password account')
                                        <a href="#" class="dropdown-item user-drop" data-ajax-popup="true"
                                            data-title="{{ __('Reset Password') }}"
                                            data-url="{{ route('user.reset', \Crypt::encrypt($user->id)) }}"><i
                                                class="ti ti-key"></i>
                                            <span class="ml-2">{{ __('Reset Password') }}</span></a>
                                    @endcan
                                    @can('delete user')
                                        <a href="#" class="bs-pass-para dropdown-item user-drop"
                                            data-confirm="{{ __('Are You Sure?') }}"
                                            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                            data-confirm-yes="delete-form-{{ $user->id }}" title="{{ __('Delete') }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top"><i class="ti ti-trash"></i><span
                                                class="ml-2">{{ __('Delete') }}</span></a>
                                        {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['users.destroy', $user->id],
                                            'id' => 'delete-form-' . $user->id,
                                        ]) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                    @if (\Auth::user()->type == 'company')
                                        <a href="{{ route('userlogs.index', ['month' => '', 'user' => $user->id]) }}"
                                            class="dropdown-item user-drop" data-bs-toggle="tooltip"
                                            data-bs-original-title="{{ __('User Log') }}">
                                            <i class="ti ti-history"></i>
                                            <span class="ml-2">{{ __('Logged Details') }}</span></a>
                                    @endif
                                    @if (Auth::user()->type == 'super admin')
                                        <a href="{{ route('login.with.company', $user->id) }}" class="dropdown-item user-drop"
                                            data-bs-original-title="{{ __('Login As Company') }}">
                                            <i class="ti ti-replace"></i>
                                            <span class="ml-2"> {{ __('Login As Company') }}</span>
                                        </a>
                                    @endif
                                    @if ($user->is_enable_login == 1)
                                        <a href="{{ route('users.login', \Crypt::encrypt($user->id)) }}"
                                            class="dropdown-item user-drop">
                                            <i class="ti ti-road-sign"></i>
                                            <span class="text-danger ml-2"> {{ __('Login Disable') }}</span>
                                        </a>
                                    @elseif ($user->is_enable_login == 0 && $user->password == null)
                                        <a href="#" data-url="{{ route('users.reset', \Crypt::encrypt($user->id)) }}"
                                            data-ajax-popup="true" data-size="md" class="dropdown-item login_enable user-drop"
                                            data-title="{{ __('New Password') }}">
                                            <i class="ti ti-road-sign"></i>
                                            <span class="text-success ml-2"> {{ __('Login Enable') }}</span>
                                        </a>
                                    @else
                                        <a href="{{ route('users.login', \Crypt::encrypt($user->id)) }}"
                                            class="dropdown-item user-drop">
                                            <i class="ti ti-road-sign"></i>
                                            <span class="text-success ml-2"> {{ __('Login Enable') }}</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="avatar">
                            <a href="{{ !empty($user->avatar) ? asset(Storage::url('uploads/avatar/' . $user->avatar)) : asset(Storage::url('uploads/avatar/avatar.png')) }}"
                                target="_blank">
                                <img src="{{ !empty($user->avatar) ? asset(Storage::url('uploads/avatar/' . $user->avatar)) : asset(Storage::url('uploads/avatar/avatar.png')) }}"
                                    class="rounded-circle img_users_fix_size">
                            </a>
                        </div>
                        <h4 class="mt-2">{{ $user->name }}</h4>
                        <small>{{ $user->email }}</small>
                        @if (\Auth::user()->type == 'super admin')
                            <div class=" mb-0 mt-3">
                                <div class=" p-3">
                                    <div class="row">
                                        <div class="col-5 text-start">
                                            <h6 class="mb-0  mt-1">
                                                {{ !empty($user->currentPlan) ? $user->currentPlan->name : '' }}</h6>
                                        </div>
                                        <div class="col-7 text-end">
                                            <a href="#" data-url="{{ route('plan.upgrade', $user->id) }}"
                                                class="btn btn-sm btn-primary btn-icon" data-size="lg"
                                                data-ajax-popup="true"
                                                data-title="{{ __('Upgrade Plan') }}">{{ __('Upgrade Plan') }}</a>
                                        </div>

                                        <div class="col-6 text-start mt-4">
                                            <h6 class="mb-0 px-3">{{ $user->getTotalAppoinments() }}</h6>
                                            <p class="text-muted text-sm mb-0">{{ __('Appointments') }}</p>
                                        </div>

                                        <div class="col-6 text-end mt-4">
                                            <a href="#" data-url="{{ route('business.upgrade', $user->id) }}"
                                                class="btn btn-sm btn-primary btn-icon" data-size="lg"
                                                data-ajax-popup="true"
                                                data-title="{{ __('Business Info') }}">{{ __('Businesses') }}</a>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <p class="mt-2 mb-0">

                                <button class="btn btn-sm btn-neutral mt-3 font-weight-500">
                                    <a>{{ __('Plan Expired : ') }}
                                        {{ !empty($user->plan_expire_date) ? \Auth::user()->dateFormat($user->plan_expire_date) : __('Lifetime') }}</a>
                                </button>

                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        @can('create user')
            <div class="col-md-3">
                <a href="#" class="btn-addnew-project" data-ajax-popup="true" data-size="md"
                    data-title="{{ __('Create New User') }}" data-url="{{ route('users.create') }}">
                    <div class="badge bg-primary proj-add-icon">
                        <i class="ti text-light ti-plus"></i>
                    </div>
                    <h6 class="mt-4 mb-2">{{ __('New User') }}</h6>
                    <p class="text-center">{{ __('Click here to add New User') }}</p>
                </a>
            </div>
        @endcan
    </div>
@endsection
