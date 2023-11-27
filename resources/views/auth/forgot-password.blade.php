@php
 $languages = App\Models\Utility::languages();
    $settings = App\Models\Utility::settings(); 
    $recaptcha = \App\Models\Utility::setCaptchaConfig();
@endphp
@extends('layouts.auth')
@section('page-title')
    {{ __('Reset Password') }}
@endsection

@section('language-bar')
    <div class="lang-dropdown-only-desk">
        <li class="dropdown dash-h-item drp-language">
            <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="drp-text"> {{ $languages[$lang] }}
                </span>
            </a>
            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                @foreach($languages as $code => $language)
                <a href="{{ route('password.request',$code) }}"tabindex="0"
                class="dropdown-item {{ $code == $lang ? 'active' : '' }} ">
                <span>{{ Str::upper($language) }}</span>
            </a>
                @endforeach
            </div>
        </li>
    </div>
@endsection
@push('custom-scripts')
    @if ($settings['RECAPTCHA_MODULE'] == 'yes')
        {!! NoCaptcha::renderJs() !!}
    @endif
    <script src="{{ asset('custom/libs/jquery/dist/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#loginForm").submit(function(e) {
                $("#saveBtn").attr("disabled", true);
                return true;
            });
        });
    </script>
@endpush
@section('content')
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-primary">
                {{ session('status') }}
            </div>
        @endif
        <div>
            <h2 class="mb-3 f-w-600">{{ __('Forgot') }} {{ __('Password !') }}</h2>
            <p>{{ __('We will send a link to reset your password') }} </p>
        </div>
        {{ Form::open(['route' => 'password.email', 'method' => 'post', 'id' => 'form_data']) }}
        <div class="custom-login-form">
            <div class="form-group mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                    placeholder="Enter Your Email">
                @error('email')
                    <span class="error invalid-email text-danger" role="alert">
                        <small>{{ $message }}</small>
                    </span>
                @enderror
            </div>

            @if ($settings['RECAPTCHA_MODULE'] == 'yes')
                
                <div class="form-group col-lg-12 col-md-12 mt-3">
                    <h1>
                    {!! NoCaptcha::display($settings['cust_darklayout']=='on' ? ['data-theme' => 'dark'] : []) !!}
                    @error('g-recaptcha-response')
                        <span class="error small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            @endif

            <div class="d-grid">
                <button class="btn btn-primary mt-2">{{ __('Send Password Reset Link') }} </button>
            </div>
            <p class="my-4 text-center">{{ __('Back to') }}
                <a href="{{ route('login') }}" tabindex="0">{{ __('Login') }}</a>
            </p>
        </div>
        {{ Form::close() }}

    </div>

@endsection
