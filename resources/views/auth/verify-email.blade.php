@extends('layouts.auth')

@php
    $logo = asset(Storage::url('uploads/logo/'));
    $company_logo = Utility::getValByName('company_logo');
@endphp

@section('content')
    <div class="card-body">
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600 text-primary">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif
        <div>
            <h2 class="mb-3 f-w-600">{{ __('Verification') }} <span class="text-primary">{{ __('') }}</span></h2>
            <p>{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </p>
        </div>

        <div class="custom-login-form">
            <div class="form-group mb-3">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>
            </div>
            <div class="form-group mb-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm"> {{ __('Logout') }}</button>
                </form>
            </div>
        </div>

    </div>
@endsection
@section('content')
@endsection
