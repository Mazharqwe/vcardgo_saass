@extends('layouts.admin')
@php
    $settings = Utility::settings();
    $dir = asset(Storage::url('uploads/plan'));
    $admin_payment_setting = Utility::getAdminPaymentSetting();
@endphp
@section('page-title')
    {{ __('Plans') }}
@endsection

@section('title')
    {{ __('Manage Plan') }}
@endsection
@section('action-btn')
    @can('create plan')
        <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end"
            data-bs-placement="top">
            @if (App\Models\Utility::getPaymentIsOn() && \Auth::user()->type == 'super admin')
                <a href="#" data-size="lg" data-url="{{ route('plans.create') }}" data-ajax-popup="true"
                    data-bs-toggle="tooltip" title="{{ __('Create') }}" data-title="{{ __('Create New Plan') }}"
                    class="btn btn-sm btn-primary">
                    <i class="ti ti-plus"></i>
                </a>
            @endif
        </div>
    @endcan
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Plans') }}</li>
@endsection
@section('content')
    <div class="row">
        @foreach ($plans as $plan)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="plan_card">
                    <div class="card price-card price-1 wow animate__fadeInUp" data-wow-delay="0.2s"
                        style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                        <div class="card-body">
                            <span class="price-badge bg-primary">{{ $plan->name }}</span>
                            @if (\Auth::user()->type == 'company' && \Auth::user()->plan == $plan->id)
                                <div class="d-flex flex-row-reverse m-0 p-0 ">
                                    <span class="d-flex align-items-center ">
                                        <i class="f-10 lh-1 fas fa-circle text-success"></i>
                                        <span class="ms-2">{{ __('Active') }}</span>
                                    </span>
                                </div>
                            @endif
                            @if (\Auth::user()->type == 'super admin')
                                @can('edit plan')
                                    <div class="col-12 text-end">
                                        <div class="action-btn bg-primary ms-2">
                                            <a data-url="{{ route('plans.edit', $plan->id) }}" data-size="lg"
                                                data-ajax-popup="true" data-bs-placement="top" data-bs-toggle="tooltip"
                                                data-bs-original-title="{{ __('Edit') }}" data-title="{{ __('Edit Plan') }}"
                                                data-toggle="tooltip" data-original-title="{{ __('Edit') }}"
                                                class="mx-3 btn btn-sm d-inline-flex align-items-center">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endcan
                            @endif
                            <span class="mb-4 p-price m"><span
                                    style="font-weight: 600">{{ !empty($admin_payment_setting['CURRENCY_SYMBOL']) ? $admin_payment_setting['CURRENCY_SYMBOL'] : '$' }}{{ $plan->price }}</span><small
                                    class="text-sm">{{ __('/ Duration : ') . __(ucfirst($plan->duration)) }}</small></span>
                            <p class="mb-0">
                                {{ $plan->description }}
                            </p>

                            
                            <ul class="list-unstyled my-4">
                                <li>
                                    <span class="theme-avtar">
                                        <i class="text-primary ti ti-circle-plus"></i></span>
                                    {{ count($plan->getThemes()) }} {{ __('Themes') }}
                                </li>
                                <li>
                                    <span class="theme-avtar">
                                        <i class="text-primary ti ti-circle-plus"></i></span>
                                    {{ $plan->business == '-1' ? 'Unlimited' : $plan->business }} {{ __('Business') }}
                                </li>
                                <li>
                                    <span class="theme-avtar">
                                        <i class="text-primary ti ti-circle-plus"></i></span>
                                    {{ $plan->max_users == '-1' ? 'Unlimited' : $plan->max_users }} {{ __('Users') }}
                                </li>
                                @if ($plan->enable_custdomain == 'on')
                                    <li>
                                        <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>
                                        {{ __('Custom Domain') }}
                                    </li>
                                @else
                                    <li>

                                        <span class="theme-avtar">
                                            <i data-feather="x" class="text-danger"></i></span>
                                        <span class="text-danger"> {{ __('Custom Domain') }}</span>

                                    </li>
                                @endif
                                @if ($plan->enable_custsubdomain == 'on')
                                    <li>
                                        <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>
                                        {{ __('Sub Domain') }}
                                    </li>
                                @else
                                    <li>
                                        <span class="theme-avtar">
                                            <i data-feather="x" class="text-danger"></i></span>
                                        <span class="text-danger"> {{ __('Sub Domain') }}</span>

                                    </li>
                                @endif
                                @if ($plan->enable_branding == 'on')
                                    <li>
                                        <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>
                                        {{ __('Branding') }}
                                    </li>
                                @else
                                    <li>
                                        <span class="theme-avtar">
                                            <i data-feather="x" class="text-danger"></i></span>
                                        <span class="text-danger">{{ __('Branding') }}</span>
                                    </li>
                                @endif
                                @if ($plan->enable_qr_code == 'on')
                                    <li>
                                        <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>
                                        {{ __('QR Code') }}
                                    </li>
                                @else
                                    <li>
                                        <span class="theme-avtar">
                                            <i data-feather="x" class="text-danger"></i></span>
                                        <span class="text-danger">{{ __('QR Code') }}</span>
                                    </li>
                                @endif

                                @if ($plan->pwa_business == 'on')
                                    <li>
                                        <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>
                                        {{ __('Progressive Web App (PWA)') }}
                                    </li>
                                @else
                                    <li>
                                        <span class="theme-avtar">
                                            <i data-feather="x" class="text-danger"></i></span>
                                        <span class="text-danger">{{ __('Progressive Web App (PWA)') }}</span>
                                    </li>
                                @endif
                                @if ($plan->enable_chatgpt == 'on')
                                    <li>
                                        <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>
                                        {{ __('Chatgpt') }}
                                    </li>
                                @else
                                    <li>
                                        <span class="theme-avtar">
                                            <i data-feather="x" class="text-danger"></i></span>
                                        <span class="text-danger">{{ __('Chatgpt') }}</span>
                                    </li>
                                @endif
                                <li>
                                    <span class="theme-avtar">
                                        <i class="text-primary ti ti-circle-plus"></i>
                                    </span>
                                    {{ $plan->storage_limit }} {{ __('MB Storage Limit') }}
                                </li>
                            </ul>

                            @if (\Auth::user()->type == 'company' && \Auth::user()->plan == $plan->id)
                                @if ($plan->duration !== 'Lifetime')
                                    @if (
                                        \Auth::user()->type == 'company' &&
                                            (empty(\Auth::user()->plan_expire_date) || \Auth::user()->plan_expire_date < date('Y-m-d')))
                                        <p class="plan-expired text-dark mb-0">
                                            {{ __('Plan Expired') }}
                                        </p>
                                    @else
                                        <p class="plan-expired text-dark mb-0">
                                            {{ __('Plan Expired : ') }}
                                            {{ !empty(\Auth::user()->plan_expire_date) ? date('d-m-Y', strtotime(\Auth::user()->plan_expire_date)) : 'Lifetime' }}
                                        </p>
                                    @endif
                                @else
                                    <p class="plan-expired text-dark mb-0">
                                        {{ __('Plan Expired : Lifetime') }}
                                    </p>
                                @endif
                            @endif

                            <div class="row d-flex justify-content-between">
                                <div class="col-8">
                                    @if (
                                        \Auth::user()->type == 'company' &&
                                            (empty(\Auth::user()->plan_expire_date) || \Auth::user()->plan_expire_date < date('Y-m-d')))
                                        @if (App\Models\Utility::getPaymentIsOn())
                                            @if ($plan->id != \Auth::user()->plan && \Auth::user()->type == 'company')
                                                @if ($plan->price > 0)
                                                    @can('buy plan')
                                                        <div class="d-grid text-center">
                                                            <a href="{{ route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                                                class="btn  btn-primary d-flex justify-content-center align-items-center ">{{ __('Subscribe') }}
                                                                <i class="fas fa-arrow-right m-1"></i></a>
                                                            <p></p>
                                                        </div>
                                                    @endcan
                                                @endif
                                            @endif
                                        @endif
                                    @else
                                        @if (App\Models\Utility::getPaymentIsOn())
                                            @if ($plan->id != \Auth::user()->plan && \Auth::user()->type == 'company')
                                                @if ($plan->price > 0)
                                                    @can('buy plan')
                                                        <div class="d-grid text-center">
                                                            <a href="{{ route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                                                class="btn btn-primary btn-md d-flex justify-content-center align-items-center">{{ __('Subscribe') }}
                                                                <i class="ti ti-arrow-right ms-1"></i></a>
                                                            <p></p>
                                                        </div>
                                                    @endcan
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                </div>
                                @if (\Auth::user()->type != 'super admin' && \Auth::user()->plan != $plan->id)
                                    @if ($plan->id != 1)
                                        @if (\Auth::user()->requested_plan != $plan->id)
                                            <div class="col-4">
                                                <a href="{{ route('send.request', [\Illuminate\Support\Facades\Crypt::encrypt($plan->id)]) }}"
                                                    class="btn btn-primary btn-icon btn-md"
                                                    data-title="{{ __('Send Request') }}" data-bs-placement="top"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-original-title="{{ __('Send Request') }}"
                                                    data-toggle="tooltip">
                                                    <span class="btn-inner--icon"><i
                                                            class="ti ti-arrow-forward-up"></i></span>
                                                </a>
                                            </div>
                                        @else
                                            <div class="col-4">
                                                <a href="{{ route('request.cancel', \Auth::user()->id) }}"
                                                    class="btn btn-icon  btn-danger btn-md" data-bs-placement="top"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-original-title="{{ __('Cancel Request') }}">
                                                    <span class="btn-inner--icon"><i class="ti ti-x"></i></span>
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
