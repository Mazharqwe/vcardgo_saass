@extends('layouts.admin')
@section('page-title')
    {{ __('Settings') }}
@endsection
@php
    // $logo=asset(Storage::url('uploads/'));
    $logo = \App\Models\Utility::get_file('uploads/logo/');
    
    $lang = \App\Models\Utility::getValByName('default_language');
    
    $file_type = config('files_types');
    $setting = App\Models\Utility::settings();
    
    $local_storage_validation = $setting['local_storage_validation'];
    $local_storage_validations = explode(',', $local_storage_validation);
    
    $s3_storage_validation = $setting['s3_storage_validation'];
    $s3_storage_validations = explode(',', $s3_storage_validation);
    
    $wasabi_storage_validation = $setting['wasabi_storage_validation'];
    $wasabi_storage_validations = explode(',', $wasabi_storage_validation);
    
    $logo_light = \App\Models\Utility::getValByName('company_logo_light');
    $logo_dark = \App\Models\Utility::getValByName('company_logo');
    
    $chatgpt_setting = App\Models\Utility::chatgpt_setting(\Auth::user()->creatorId());
    
@endphp
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Settings') }}</li>
@endsection
@section('title')
    {{ __('Settings') }}
@endsection
@php
    // $color = Cookie::get('color');
    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';
@endphp

@if ($color == 'theme-3')
    <style>
        .btn-check:checked+.btn-outline-success,
        .btn-check:active+.btn-outline-success,
        .btn-outline-success:active,
        .btn-outline-success.active,
        .btn-outline-success.dropdown-toggle.show {
            color: #ffffff;
            background-color: #6fd943 !important;
            border-color: #6fd943 !important;

        }

        .btn-outline-success:hover {
            color: #ffffff;
            background-color: #6fd943 !important;
            border-color: #6fd943 !important;
        }

        .btn.btn-outline-success {
            color: #6fd943;
            border-color: #6fd943 !important;
        }
    </style>
@endif
@if ($color == 'theme-2')
    <style>
        .btn-check:checked+.btn-outline-success,
        .btn-check:active+.btn-outline-success,
        .btn-outline-success:active,
        .btn-outline-success.active,
        .btn-outline-success.dropdown-toggle.show {
            color: #ffffff;
            background: linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #4ebbd3 99.86%)#1f3996 !important;
            border-color: #1F3996 !important;

        }

        .btn-outline-success:hover {
            color: #ffffff;
            background: linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #4ebbd3 99.86%)#1f3996 !important;
            border-color: #1F3996 !important;
        }

        .btn.btn-outline-success {
            color: #1F3996;
            border-color: #1F3996 !important;
        }
    </style>
@endif
@if ($color == 'theme-4')
    <style>
        .btn-check:checked+.btn-outline-success,
        .btn-check:active+.btn-outline-success,
        .btn-outline-success:active,
        .btn-outline-success.active,
        .btn-outline-success.dropdown-toggle.show {
            color: #ffffff;
            background-color: #584ed2 !important;
            border-color: #584ed2 !important;

        }

        .btn-outline-success:hover {
            color: #ffffff;
            background-color: #584ed2 !important;
            border-color: #584ed2 !important;
        }

        .btn.btn-outline-success {
            color: #584ed2;
            border-color: #584ed2 !important;
        }
    </style>
@endif
@if ($color == 'theme-1')
    <style>
        .btn-check:checked+.btn-outline-success,
        .btn-check:active+.btn-outline-success,
        .btn-outline-success:active,
        .btn-outline-success.active,
        .btn-outline-success.dropdown-toggle.show {
            color: #ffffff;
            background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
            border-color: #51459d !important;

        }

        .btn-outline-success:hover {
            color: #ffffff;
            background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
            border-color: #51459d !important;
        }

        .btn.btn-outline-success {
            color: #51459d;
            border-color: #51459d !important;
        }
    </style>
@endif
@push('custom-scripts')
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        });
        var multipleCancelButton = new Choices(
            '#choices-multiple-remove-button', {
                removeItemButton: true,
            }
        );
        var multipleCancelButton = new Choices(
            '#choices-multiple-remove-button1', {
                removeItemButton: true,
            }
        );
        var multipleCancelButton = new Choices(
            '#choices-multiple-remove-button2', {
                removeItemButton: true,
            }
        );
    </script>
    <script>
        $(document).ready(function() {
            if ($('.gdpr_fulltime').is(':checked')) {

                $('.fulltime').show();
            } else {

                $('.fulltime').hide();
            }

            $('#gdpr_cookie').on('change', function() {
                if ($('.gdpr_fulltime').is(':checked')) {

                    $('.fulltime').show();
                } else {

                    $('.fulltime').hide();
                }
            });
        });
    </script>
    <script src="{{ asset('custom/libs/jquery-mask-plugin/dist/jquery.mask.min.js') }}"></script>
    <script>
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            show_toastr('Success', "{{ __('Link copied') }}", 'success');
        }

        $(document).on('click', 'input[name="theme_color"]', function() {
            var eleParent = $(this).attr('data-theme');
            $('#themefile').val(eleParent);
            var imgpath = $(this).attr('data-imgpath');
            $('.' + eleParent + '_img').attr('src', imgpath);
        });

        $(document).ready(function() {
            setTimeout(function(e) {
                var checked = $("input[type=radio][name='theme_color']:checked");
                $('#themefile').val(checked.attr('data-theme'));
                $('.' + checked.attr('data-theme') + '_img').attr('src', checked.attr('data-imgpath'));
            }, 300);
        });
    </script>
    <script>
        function check_theme(color_val) {
            $('.theme-color').prop('checked', false);
            $('input[value="' + color_val + '"]').prop('checked', true);
        }
    </script>

    <script type="text/javascript">
        $(document).on("click", '.send_email', function(e) {
            e.preventDefault();
            var title = $(this).attr('data-title');
            var size = 'md';
            var url = $(this).attr('data-url');

            if (typeof url != 'undefined') {
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $("#commonModal").modal('show');

                $.post(url, {
                    _token: '{{ csrf_token() }}',
                    mail_driver: $("#mail_driver").val(),
                    mail_host: $("#mail_host").val(),
                    mail_port: $("#mail_port").val(),
                    mail_username: $("#mail_username").val(),
                    mail_password: $("#mail_password").val(),
                    mail_encryption: $("#mail_encryption").val(),
                    mail_from_address: $("#mail_from_address").val(),
                    mail_from_name: $("#mail_from_name").val(),

                }, function(data) {
                    $('#commonModal .modal-body').html(data);
                });
            }
        });
        $(document).on('submit', '#test_email', function(e) {
            e.preventDefault();
            $("#email_sending").show();
            var post = $(this).serialize();
            var url = $(this).attr('action');
            $.ajax({
                type: "post",
                url: url,
                data: post,
                cache: false,
                beforeSend: function() {
                    $('#test_email .btn-create').attr('disabled', 'disabled');
                },
                success: function(data) {

                    if (data.is_success) {
                        toastrs('Success', data.message, 'success');
                    } else {
                        toastrs('Error', data.message, 'error');
                    }
                    $("#email_sending").hide();
                    $('#commonModal').modal('hide');

                },
                complete: function() {
                    $('#test_email .btn-create').removeAttr('disabled');
                },
            });
        });
    </script>

    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {

            target: '#useradd-sidenav',
            offset: 300,
        })
        $(".list-group-item").click(function() {
            $('.list-group-item').filter(function() {
                // alert('fghyht');
                // return this.href == id ;
            }).parent().removeClass('text-primary');
        });

        function check_theme(color_val) {
            $('#theme_color').prop('checked', false);
            $('input[value="' + color_val + '"]').prop('checked', true);
        }

        $(document).on('change', '[name=storage_setting]', function() {
            if ($(this).val() == 's3') {
                $('.s3-setting').removeClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').addClass('d-none');
            } else if ($(this).val() == 'wasabi') {
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').removeClass('d-none');
                $('.local-setting').addClass('d-none');
            } else {
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').removeClass('d-none');
            }
        });
    </script>
    <script>
        var custthemebg = document.querySelector("#cust-theme-bg");
        custthemebg.addEventListener("click", function() {
            if (custthemebg.checked) {
                document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.add("transprent-bg");
            } else {
                document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.remove("transprent-bg");
            }
        });
    </script>
    <script>
        if ($('#cust-darklayout').length > 0) {
            var custthemedark = document.querySelector("#cust-darklayout");
            custthemedark.addEventListener("click", function() {
                if (custthemedark.checked) {
                    $('#main-style-link').attr('href', '{{ env('APP_URL') }}' +
                        '/public/assets/css/style-dark.css');
                    $('.dash-sidebar .main-logo a img').attr('src', '{{ $logo . $logo_light }}');
                } else {
                    $('#main-style-link').attr('href', '{{ env('APP_URL') }}' + '/public/assets/css/style.css');
                    $('.dash-sidebar .main-logo a img').attr('src', '{{ $logo . $logo_dark }}');
                }
            });
        }
    </script>

    <script type="text/javascript">
        function enablecookie() {
            const element = $('#enable_cookie').is(':checked');
            $('.cookieDiv').addClass('disabledCookie');
            if (element == true) {
                $('.cookieDiv').removeClass('disabledCookie');
                $("#cookie_logging").attr('checked', true);
            } else {
                $('.cookieDiv').addClass('disabledCookie');
                $("#cookie_logging").attr('checked', false);
            }
        }
    </script>
@endpush
@section('content')
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#brand-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('Brand Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#email-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('Email Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#payment-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('Payment Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#recaptcha-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('ReCaptcha Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#storage-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('Storage Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#cache-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('Cache Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#cookie-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('Cookie Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#chatgpt-settings"
                                class="list-group-item list-group-item-action border-0">{{ __('ChatGPT Settings') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div id="brand-settings" class="">
                        <div class="card">
                            {{ Form::model($settings, ['url' => 'systems', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                            <div class="card-header">
                                <h5>{{ __('Brand Settings') }}</h5>
                                <small class="text-muted">{{ __('Edit your brand details') }}</small>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Logo Dark') }}</h5>
                                            </div>
                                            <div class="card-body pt-1 min-250">
                                                <div class=" setting-card">
                                                    <div class="logo-content mt-5">
                                                        <a href="{{ $logo . 'logo-dark.png' }}" target="_blank">
                                                            <img id="dark-logo" alt="your image"
                                                                src="{{ $logo . 'logo-dark.png' . '?' . time() }}"
                                                                width="150px" class="big-logo">
                                                        </a>
                                                    </div>
                                                    <div class="choose-files mt-5">
                                                        <label for="logo">
                                                            <div class="mt-3 bg-primary logo_update"> <i
                                                                    class="ti ti-upload px-1"></i>{{ __('Select image') }}
                                                            </div>
                                                            <input type="file" class="form-control file" name="logo"
                                                                id="logo" data-filename="editlogo"
                                                                onchange="document.getElementById('dark-logo').src = window.URL.createObjectURL(this.files[0])">
                                                        </label>
                                                    </div>
                                                    @error('logo')
                                                        <span class="invalid-logo text-xs text-danger"
                                                            role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Logo Light') }}</h5>
                                            </div>
                                            <div class="card-body pt-1 min-250">
                                                <div class=" setting-card">
                                                    <div class="logo-content mt-5">

                                                        <a href="{{ $logo . 'logo-light.png' }}" target="_blank">
                                                            <img id="light-logo" alt="your image"
                                                                src="{{ $logo . 'logo-light.png' . '?' . time() }}"
                                                                width="150px" class="big-logo img_setting">
                                                        </a>

                                                    </div>
                                                    <div class="choose-files mt-5 ">
                                                        <label for="landing_logo">
                                                            <div class="mt-3 bg-primary company_favicon_update"> <i
                                                                    class="ti ti-upload px-1"></i>{{ __('Select image') }}
                                                            </div>
                                                            <input type="file" class="form-control file"
                                                                name="landing_logo" id="landing_logo"
                                                                data-filename="landing_logo_update"
                                                                onchange="document.getElementById('light-logo').src = window.URL.createObjectURL(this.files[0])">
                                                        </label>
                                                    </div>
                                                    @error('landing_logo')
                                                        <span class="invalid-company_favicon text-xs text-danger"
                                                            role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{ __('Favicon') }}</h5>
                                            </div>
                                            <div class="card-body min-250">
                                                <div class=" setting-card">
                                                    <div class="logo-content mt-4">

                                                        <a href="{{ $logo . (isset($logo) && !empty($logo) ? $logo : 'favicon.png') }}"
                                                            target="_blank">
                                                            <img id="favicon-logo" alt="your image"
                                                                src="{{ $logo . 'favicon.png' . '?' . time() }}"
                                                                width="50px" class="img_setting">
                                                        </a>
                                                    </div>
                                                    <div class="choose-files mt-5 ">
                                                        <label for="favicon">
                                                            <div class="mt-3 bg-primary company_favicon_update"> <i
                                                                    class="ti ti-upload px-1"></i>{{ __('Select image') }}
                                                            </div>
                                                            <input type="file" class="form-control file"
                                                                name="favicon" id="favicon"
                                                                data-filename="favicon_update"
                                                                onchange="document.getElementById('favicon-logo').src = window.URL.createObjectURL(this.files[0])">
                                                        </label>
                                                    </div>
                                                    @error('favicon')
                                                        <span class="invalid-company_favicon text-xs text-danger"
                                                            role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12 col-md-612">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    {{ Form::label('title_text', __('Title Text'), ['class' => 'form-label']) }}
                                                    {{ Form::text('title_text', null, ['class' => 'form-control', 'placeholder' => __('Title Text')]) }}
                                                    @error('title_text')
                                                        <span class="invalid-title_text" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    {{ Form::label('footer_text', __('Footer Text'), ['class' => 'form-label']) }}
                                                    {{ Form::text('footer_text', null, ['class' => 'form-control', 'placeholder' => __('Footer Text')]) }}
                                                    @error('footer_text')
                                                        <span class="invalid-title_text" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    {{ Form::label('default_language', __('Default Language'), ['class' => 'form-label']) }}
                                                    <div class="changeLanguage">
                                                        <select name="default_language" id="default_language"
                                                            class="form-control select2">
                                                            @foreach (App\Models\Utility::languages() as $code => $language)
                                                                <option @if ($lang == $code) selected @endif
                                                                    value="{{ $code }}">
                                                                    {{ ucFirst($language) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-4 col-6">
                                                <div class="form-group">
                                                    {{ Form::label('SITE_RTL', __('Enable RTL'), ['class' => 'form-label']) }}

                                                    <div
                                                        class="d-flex align-items-center  justify-content-between border-0  py-2 borderleft">
                                                        <input type="checkbox" data-toggle="switchbutton"
                                                            data-onstyle="primary" name="SITE_RTL" id="SITE_RTL"
                                                            {{ env('SITE_RTL') == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="form-label" for="SITE_RTL"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-4 col-6">
                                                <div class="form-group">
                                                    {{ Form::label('Enable Landing Page', __('Enable Landing Page'), ['class' => 'form-label']) }}
                                                    <div
                                                        class="d-flex align-items-center  justify-content-between border-0  py-2 borderleft">
                                                        <input type="checkbox" data-toggle="switchbutton"
                                                            data-onstyle="primary" name="display_landing_page"
                                                            id="display_landing_page"
                                                            {{ $settings['display_landing_page'] == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label form-control-label"
                                                            for="display_landing_page"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-4 col-6">
                                                <div class="form-group">
                                                    {{ Form::label('signup_button', __('Enable Sign-Up Page')) }}
                                                    <div
                                                        class="d-flex align-items-center  justify-content-between border-0  py-2 borderleft">
                                                        <input type="checkbox" data-toggle="switchbutton"
                                                            data-onstyle="primary" name="signup_button"
                                                            id="signup_button"
                                                            {{ isset($settings['signup_button']) && $settings['signup_button'] == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class=" form-label" for="signup_button"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-4 col-6">
                                                <div class="form-group">
                                                    {{ Form::label('email_verification', __('Enable Email Verification')) }}
                                                    <div
                                                        class="d-flex align-items-center  justify-content-between border-0  py-2 borderleft">
                                                        <input type="checkbox" name="email_verification"
                                                            id="email_verification" data-toggle="switchbutton"
                                                            {{ isset($settings['email_verification']) && $settings['email_verification'] == 'on' ? 'checked="checked"' : '' }}
                                                            data-onstyle="primary">
                                                        <label class=" form-label" for="email_verification"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="setting-card setting-logo-box p-3">
                                            <div class="row">
                                                <h4 class="small-title">{{ __('Theme Customizer') }}</h4>
                                                <div class="col-lg-4 col-xl-4 col-md-4 my-auto">
                                                    <h6 class="mt-2">
                                                        <i data-feather="credit-card"
                                                            class="me-2"></i>{{ __('Primary Color Settings') }}
                                                    </h6>
                                                    <hr class="my-2" />
                                                    <div class="theme-color themes-color">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-1' ? 'active_color' : '' }}"
                                                            data-value="theme-1" onclick="check_theme('theme-1')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-1" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-2' ? 'active_color' : '' }} "
                                                            data-value="theme-2" onclick="check_theme('theme-2')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-2" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-3' ? 'active_color' : '' }}"
                                                            data-value="theme-3" onclick="check_theme('theme-3')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-3" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-4' ? 'active_color' : '' }}"
                                                            data-value="theme-4" onclick="check_theme('theme-4')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-4" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-5' ? 'active_color' : '' }}"
                                                            data-value="theme-5" onclick="check_theme('theme-5')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-5" style="display: none;">
                                                        <br>
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-6' ? 'active_color' : '' }}"
                                                            data-value="theme-6" onclick="check_theme('theme-6')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-6" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-7' ? 'active_color' : '' }}"
                                                            data-value="theme-7" onclick="check_theme('theme-7')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-7" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-8' ? 'active_color' : '' }}"
                                                            data-value="theme-8" onclick="check_theme('theme-8')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-8" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-9' ? 'active_color' : '' }}"
                                                            data-value="theme-9" onclick="check_theme('theme-9')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-9" style="display: none;">
                                                        <a href="#!"
                                                            class="{{ $settings['color'] == 'theme-10' ? 'active_color' : '' }}"
                                                            data-value="theme-10" onclick="check_theme('theme-10')"></a>
                                                        <input type="radio" class="theme_color" name="color"
                                                            value="theme-10" style="display: none;">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xl-4 col-md-4  my-auto mt-2">
                                                    <h6>
                                                        <i data-feather="layout"
                                                            class="me-2"></i>{{ __('Sidebar Settings') }}
                                                    </h6>
                                                    <hr class="my-2" />
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="cust-theme-bg" name="cust_theme_bg"
                                                            {{ Utility::getValByName('cust_theme_bg') == 'on' ? 'checked' : '' }} />
                                                        <label class="form-check-label f-w-600 pl-1"
                                                            for="cust-theme-bg">{{ __('Transparent layout') }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xl-4 col-md-4 my-auto mt-2">
                                                    <h6>
                                                        <i data-feather="sun"
                                                            class="me-2"></i>{{ __('Layout Settings') }}
                                                    </h6>
                                                    <hr class="my-2" />
                                                    <div class="form-check form-switch mt-2">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="cust-darklayout" name="cust_darklayout"
                                                            {{ Utility::getValByName('cust_darklayout') == 'on' ? 'checked' : '' }} />
                                                        <label class="form-check-label f-w-600 pl-1"
                                                            for="cust-darklayout">{{ __('Dark Layout') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer text-end">
                                {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-print-invoice  btn-primary ']) }}
                            </div>
                            {{ Form::close() }}
                        </div>

                        <div id="email-settings" class="card">
                            <div class="card-header">
                                <h5>{{ __('Email Settings') }}</h5>
                                <small class="text-muted">{{ __('Edit your email details') }}</small>
                            </div>
                            {{ Form::open(['route' => 'email.settings', 'method' => 'post']) }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_driver', __('Mail Driver'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_driver', $settings['mail_driver'], ['class' => 'form-control', 'placeholder' => __('Enter Mail Driver')]) }}
                                            @error('mail_driver')
                                                <span class="invalid-mail_driver" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_host', __('Mail Host'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_host', $settings['mail_host'], ['class' => 'form-control ', 'placeholder' => __('Enter Mail Host')]) }}
                                            @error('mail_host')
                                                <span class="invalid-mail_driver" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_port', __('Mail Port'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_port', $settings['mail_port'], ['class' => 'form-control', 'placeholder' => __('Enter Mail Port')]) }}
                                            @error('mail_port')
                                                <span class="invalid-mail_port" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_username', __('Mail Username'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_username', $settings['mail_username'], ['class' => 'form-control', 'placeholder' => __('Enter Mail Username')]) }}
                                            @error('mail_username')
                                                <span class="invalid-mail_username" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_password', __('Mail Password'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_password', $settings['mail_password'], ['class' => 'form-control', 'placeholder' => __('Enter Mail Password')]) }}
                                            @error('mail_password')
                                                <span class="invalid-mail_password" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_encryption', __('Mail Encryption'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_encryption', $settings['mail_encryption'], ['class' => 'form-control', 'placeholder' => __('Enter Mail Encryption')]) }}
                                            @error('mail_encryption')
                                                <span class="invalid-mail_encryption" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_from_address', __('Mail From Address'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_from_address', $settings['mail_from_address'], ['class' => 'form-control', 'placeholder' => __('Enter Mail From Address')]) }}
                                            @error('mail_from_address')
                                                <span class="invalid-mail_from_address" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            {{ Form::label('mail_from_name', __('Mail From Name'), ['class' => 'form-label']) }}
                                            {{ Form::text('mail_from_name', $settings['mail_from_name'], ['class' => 'form-control', 'placeholder' => __('Enter Mail From Name')]) }}
                                            @error('mail_from_name')
                                                <span class="invalid-mail_from_name" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-auto form-group">
                                        <a href="#" data-url="{{ route('test.mail') }}" data-ajax-popup="true"
                                            data-title="{{ __('Send Test Mail') }}"
                                            class="send_email btn m-r-10 mt-1 btn-primary">
                                            {{ __('Send Test Mail') }}
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-print-invoice  btn-primary']) }}
                                    </div>
                                </div>

                            </div>
                            {{ Form::close() }}
                        </div>

                        <div id="payment-settings" class="card">
                            {{ Form::open(['route' => 'payment.settings', 'method' => 'post']) }}
                            <div class="card-header">
                                <h5>{{ __('Payment Settings') }}</h5>
                                <small
                                    class="text-muted">{{ __('These details will be used to collect subscription plan payments.Each subscription plan will have a payment button based on the below configuration.') }}</small>
                            </div>
                        
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('currency', __('Currency'), ['class' => 'form-label']) }}
                                            {{ Form::text('currency', isset($admin_payment_setting['CURRENCY']) ? $admin_payment_setting['CURRENCY'] : '', ['class' => 'form-control font-style', 'required', 'placeholder' => __('Enter Currency')]) }}
                                            <small> {{ __('Note: Add currency code as per three-letter ISO code.') }}<a
                                                    href="https://stripe.com/docs/currencies"
                                                    target="_blank">{{ __(' You can find out how to do that here.') }}</a></small>
                                            <br>
                                            @error('currency')
                                                <span class="invalid-currency" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('currency_symbol', __('Currency Symbol *'), ['class' => 'form-label']) }}
                                            {{ Form::text('currency_symbol', isset($admin_payment_setting['CURRENCY_SYMBOL']) ? $admin_payment_setting['CURRENCY_SYMBOL'] : '' , ['class' => 'form-control', 'required', 'placeholder' => __('Enter Currency Symbol')]) }}

                                            @error('currency_symbol')
                                                <span class="invalid-currency_symbol" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="faq">
                                    <div class="accordion accordion-flush setting-accordion" id="accordionExample">
                                        {{-- Manually --}}
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingFourteen">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseFourteen" aria-expanded="true"
                                                    aria-controls="collapseFourteen">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Manually') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_manually_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_manually_enabled"
                                                                value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_manually_enabled" id="is_manually_enabled"
                                                                {{ isset($admin_payment_setting['is_manually_enabled']) && $admin_payment_setting['is_manually_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>

                                            <div id="collapseFourteen" class="accordion-collapse collapse"
                                                aria-labelledby="headingFourteen" data-bs-parent="#accordionExample">
                                                <div class="row p-3">
                                                    <p class="text-muted">
                                                        {{ __('Requesting manual payment for the planned amount for the subscriptions plan.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End manually --}}
                                        {{-- Bank Transfer --}}
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingFifteen">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseFifteen" aria-expanded="true"
                                                    aria-controls="collapseFifteen">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Bank Transfer') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_bank_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_bank_enabled" value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_bank_enabled" id="is_bank_enabled"
                                                                {{ isset($admin_payment_setting['is_bank_enabled']) && $admin_payment_setting['is_bank_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>

                                            <div id="collapseFifteen" class="accordion-collapse collapse"
                                                aria-labelledby="headingFifteen" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                @php
                                                                    $bank_detail = !empty($admin_payment_setting['bank_detail']) ? $admin_payment_setting['bank_detail'] : '';
                                                                @endphp
                                                                {{ Form::label('bank_detail', __('Bank Details'), ['class' => 'form-label']) }}
                                                                <textarea name="bank_detail" class="form-control" rows="6" cols="30">{{ $bank_detail }}</textarea>
                                                                @if ($errors->has('bank_detail'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('bank_detail') }}
                                                                    </span>
                                                                @endif
                                                                <small
                                                                    class="text-muted">{{ __('Example:Bank:bank name</br>Account Number:0000 0000</br>') }}</small>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- End Bank Transfer --}}
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Stripe') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_stripe_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_stripe_enabled"
                                                                value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_stripe_enabled" id="is_stripe_enabled"
                                                                {{ isset($admin_payment_setting['is_stripe_enabled']) && $admin_payment_setting['is_stripe_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>

                                            <div id="collapseOne" class="accordion-collapse collapse"
                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('stripe_key', __('Stripe Key'), ['class' => 'form-label']) }}
                                                                {{ Form::text('stripe_key', isset($admin_payment_setting['stripe_key']) ? $admin_payment_setting['stripe_key'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Stripe Key')]) }}<br>
                                                                @if ($errors->has('stripe_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('stripe_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('stripe_secret', __('Stripe Secret'), ['class' => 'form-label']) }}
                                                                {{ Form::text('stripe_secret', isset($admin_payment_setting['stripe_secret']) ? $admin_payment_setting['stripe_secret'] : '', ['class' => 'form-control ', 'placeholder' => __('Enter Stripe Secret')]) }}
                                                                @if ($errors->has('stripe_secret'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('stripe_secret') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('PayPal') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_paypal_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_paypal_enabled"
                                                                value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_paypal_enabled" id="is_paypal_enabled"
                                                                {{ isset($admin_payment_setting['is_paypal_enabled']) && $admin_payment_setting['is_paypal_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                            <div class="row pt-2">
                                                                <label class="pb-2"
                                                                    for="paypal_mode">{{ __('Paypal Mode') }}</label>
                                                                <div class="col-lg-3">
                                                                    <div class="border card p-3">
                                                                        <div class="form-check">
                                                                            <input type="radio"
                                                                                class="form-check-input input-primary"
                                                                                name="paypal_mode" value="sandbox"
                                                                                {{ (isset($admin_payment_setting['paypal_mode']) && $admin_payment_setting['paypal_mode'] == '') || (isset($admin_payment_setting['paypal_mode']) && $admin_payment_setting['paypal_mode'] == 'sandbox') ? 'checked="checked"' : '' }}>
                                                                            <label class="form-check-label d-block"
                                                                                for="">
                                                                                <span>
                                                                                    <span class="h5 d-block"><strong
                                                                                            class="float-end"></strong>{{ __('Sandbox') }}</span>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="border card p-3">
                                                                        <div class="form-check">
                                                                            <input type="radio"
                                                                                class="form-check-input input-primary"
                                                                                name="paypal_mode" value="live"
                                                                                {{ isset($admin_payment_setting['paypal_mode']) && $admin_payment_setting['paypal_mode'] == 'live' ? 'checked="checked"' : '' }}>
                                                                            <label class="form-check-label d-block"
                                                                                for="">
                                                                                <span>
                                                                                    <span class="h5 d-block"><strong
                                                                                            class="float-end"></strong>{{ __('Live') }}</span>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="paypal_client_id"
                                                                    class="form-label">{{ __('Client ID') }}</label>
                                                                <input type="text" name="paypal_client_id"
                                                                    id="paypal_client_id" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['paypal_client_id']) ? $admin_payment_setting['paypal_client_id'] : '' }}"
                                                                    placeholder="{{ __('Client ID') }}" />
                                                                @if ($errors->has('paypal_client_id'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('paypal_client_id') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="paypal_secret_key"
                                                                    class="form-label">{{ __('Secret Key') }}</label>
                                                                <input type="text" name="paypal_secret_key"
                                                                    id="paypal_secret_key" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['paypal_secret_key']) ? $admin_payment_setting['paypal_secret_key'] : '' }}"
                                                                    placeholder="{{ __('Secret Key') }}" /><br>
                                                                @if ($errors->has('paypal_secret_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('paypal_secret_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    <span class="d-flex align-items-center">

                                                        {{ __('Paystack') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_paystack_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_paystack_enabled"
                                                                value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_paystack_enabled" id="is_paystack_enabled"
                                                                {{ isset($admin_payment_setting['is_paystack_enabled']) && $admin_payment_setting['is_paystack_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse"
                                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="paypal_client_id"
                                                                    class="form-label">{{ __('Public Key') }}</label>
                                                                <input type="text" name="paystack_public_key"
                                                                    id="paystack_public_key"
                                                                    class="form-control form-control-label"
                                                                    value="{{ isset($admin_payment_setting['paystack_public_key']) ? $admin_payment_setting['paystack_public_key'] : '' }}"
                                                                    placeholder="{{ __('Public Key') }}" />
                                                                @if ($errors->has('paystack_public_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('paystack_public_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="paystack_secret_key"
                                                                    class="form-label">{{ __('Secret Key') }}</label>
                                                                <input type="text" name="paystack_secret_key"
                                                                    id="paystack_secret_key"
                                                                    class="form-control form-control-label"
                                                                    value="{{ isset($admin_payment_setting['paystack_secret_key']) ? $admin_payment_setting['paystack_secret_key'] : '' }}"
                                                                    placeholder="{{ __('Secret Key') }}" /><br>
                                                                @if ($errors->has('paystack_secret_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('paystack_secret_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingFour">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                                    aria-expanded="false" aria-controls="collapseFour">
                                                    <span class="d-flex align-items-center">

                                                        {{ __('Flutterwave') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_flutterwave_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_flutterwave_enabled"
                                                                value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_flutterwave_enabled" id="is_flutterwave_enabled"
                                                                {{ isset($admin_payment_setting['is_flutterwave_enabled']) && $admin_payment_setting['is_flutterwave_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseFour" class="accordion-collapse collapse"
                                                aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="paypal_client_id"
                                                                    class="form-label">{{ __('Public Key') }}</label>
                                                                <input type="text" name="flutterwave_public_key"
                                                                    id="flutterwave_public_key" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['flutterwave_public_key']) ? $admin_payment_setting['flutterwave_public_key'] : '' }}"
                                                                    placeholder="{{ __('Public Key') }}" />
                                                                @if ($errors->has('flutterwave_public_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('flutterwave_public_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="paystack_secret_key"
                                                                    class="form-label">{{ __('Secret Key') }}</label>
                                                                <input type="text" name="flutterwave_secret_key"
                                                                    id="flutterwave_secret_key" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['flutterwave_secret_key']) ? $admin_payment_setting['flutterwave_secret_key'] : '' }}"
                                                                    placeholder="{{ __('Secret Key') }}" /><br>
                                                                @if ($errors->has('flutterwave_secret_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('flutterwave_secret_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingFive">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                                    aria-expanded="false" aria-controls="collapseFive">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Razorpay') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_razorpay_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_razorpay_enabled"
                                                                value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_razorpay_enabled" id="is_razorpay_enabled"
                                                                {{ isset($admin_payment_setting['is_razorpay_enabled']) && $admin_payment_setting['is_razorpay_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseFive" class="accordion-collapse collapse"
                                                aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="paypal_client_id"
                                                                    class="form-label">{{ __('Public Key') }}</label>

                                                                <input type="text" name="razorpay_public_key"
                                                                    id="razorpay_public_key" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['razorpay_public_key']) ? $admin_payment_setting['razorpay_public_key'] : '' }}"
                                                                    placeholder="{{ __('Public Key') }}" />
                                                                @if ($errors->has('razorpay_public_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('razorpay_public_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="paystack_secret_key"
                                                                    class="form-label">{{ __('Secret Key') }}</label>
                                                                <input type="text" name="razorpay_secret_key"
                                                                    id="razorpay_secret_key" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['razorpay_secret_key']) ? $admin_payment_setting['razorpay_secret_key'] : '' }}"
                                                                    placeholder="{{ __('Secret Key') }}" /><br>
                                                                @if ($errors->has('razorpay_secret_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('razorpay_secret_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingSix">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseSix"
                                                    aria-expanded="false" aria-controls="collapseSix">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Mercado Pago') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_mercado_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_mercado_enabled"
                                                                value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_mercado_enabled" id="is_mercado_enabled"
                                                                {{ isset($admin_payment_setting['is_mercado_enabled']) && $admin_payment_setting['is_mercado_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseSix" class="accordion-collapse collapse"
                                                aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                            <div class="row pt-2">
                                                                <label class="pb-2"
                                                                    for="paypal_mode">{{ __('Mercado Mode') }}</label>
                                                                <div class="col-lg-3">
                                                                    <div class="border card p-3">
                                                                        <div class="form-check">
                                                                            <input type="radio" name="mercado_mode"
                                                                                class="form-check-input input-primary"
                                                                                value="sandbox"
                                                                                {{ (isset($admin_payment_setting['mercado_mode']) && $admin_payment_setting['mercado_mode'] == '') || (isset($admin_payment_setting['mercado_mode']) && $admin_payment_setting['mercado_mode'] == 'sandbox') ? 'checked="checked"' : '' }}>
                                                                            <label class="form-check-label d-block"
                                                                                for="">
                                                                                <span>
                                                                                    <span class="h5 d-block"><strong
                                                                                            class="float-end"></strong>{{ __('Sandbox') }}</span>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="border card p-3">
                                                                        <div class="form-check">
                                                                            <input type="radio"
                                                                                class="form-check-input input-primary"
                                                                                name="mercado_mode" value="live"
                                                                                {{ isset($admin_payment_setting['mercado_mode']) && $admin_payment_setting['mercado_mode'] == 'live' ? 'checked="checked"' : '' }}>
                                                                            <label class="form-check-label d-block"
                                                                                for="">
                                                                                <span>
                                                                                    <span class="h5 d-block"><strong
                                                                                            class="float-end"></strong>{{ __('Live') }}</span>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="mercado_access_token"
                                                                    class="form-label">{{ __('Access Token') }}</label>
                                                                <input type="text" name="mercado_access_token"
                                                                    id="mercado_app_id" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['mercado_access_token']) ? $admin_payment_setting['mercado_access_token'] : '' }}"
                                                                    placeholder="{{ __('App ID') }}" /><br>
                                                                @if ($errors->has('mercado_access_token'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('mercado_access_token') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingSeven">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseSeven"
                                                    aria-expanded="false" aria-controls="collapseSeven">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Paytm') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_paytm_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_paytm_enabled" value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_paytm_enabled" id="is_paytm_enabled"
                                                                {{ isset($admin_payment_setting['is_paytm_enabled']) && $admin_payment_setting['is_paytm_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseSeven" class="accordion-collapse collapse"
                                                aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                            <div class="row pt-2">
                                                                <label class="pb-2"
                                                                    for="paypal_mode">{{ __('Paytm Environment') }}</label>
                                                                <div class="col-lg-3">
                                                                    <div class="border card p-3">
                                                                        <div class="form-check">

                                                                            <label class="form-check-label d-block"
                                                                                for="">
                                                                                <input type="radio" name="paytm_mode"
                                                                                    class="form-check-input input-primary"
                                                                                    value="local"
                                                                                    {{ (isset($admin_payment_setting['paytm_mode']) && $admin_payment_setting['paytm_mode'] == '') || (isset($admin_payment_setting['paytm_mode']) && $admin_payment_setting['paytm_mode'] == 'local') ? 'checked="checked"' : '' }}>
                                                                                {{ __('Local') }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="border card p-3">
                                                                        <div class="form-check">

                                                                            <label class="form-check-label d-block"
                                                                                for="">
                                                                                <input type="radio" name="paytm_mode"
                                                                                    class="form-check-input input-primary"
                                                                                    value="production"
                                                                                    {{ isset($admin_payment_setting['paytm_mode']) && $admin_payment_setting['paytm_mode'] == 'production' ? 'checked="checked"' : '' }}>
                                                                                {{ __('Production') }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="paytm_public_key"
                                                                    class="form-label">{{ __('Merchant ID') }}</label>
                                                                <input type="text" name="paytm_merchant_id"
                                                                    id="paytm_merchant_id" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['paytm_merchant_id']) ? $admin_payment_setting['paytm_merchant_id'] : '' }}"
                                                                    placeholder="{{ __('Merchant ID') }}" />
                                                                @if ($errors->has('paytm_merchant_id'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('paytm_merchant_id') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="paytm_secret_key"
                                                                    class="form-label">{{ __('Merchant Key') }}</label>
                                                                <input type="text" name="paytm_merchant_key"
                                                                    id="paytm_merchant_key" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['paytm_merchant_key']) ? $admin_payment_setting['paytm_merchant_key'] : '' }}"
                                                                    placeholder="{{ __('Merchant Key') }}" />
                                                                @if ($errors->has('paytm_merchant_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('paytm_merchant_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="paytm_industry_type" class="form-label">
                                                                    {{ __('Industry Type') }}</label>
                                                                <input type="text" name="paytm_industry_type"
                                                                    id="paytm_industry_type" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['paytm_industry_type']) ? $admin_payment_setting['paytm_industry_type'] : '' }}"
                                                                    placeholder="{{ __('Industry Type') }}" /><br>
                                                                @if ($errors->has('paytm_industry_type'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('paytm_industry_type') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingEight">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseEight"
                                                    aria-expanded="false" aria-controls="collapseEight">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Mollie') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_mollie_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_mollie_enabled"
                                                                value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_mollie_enabled" id="is_mollie_enabled"
                                                                {{ isset($admin_payment_setting['is_mollie_enabled']) && $admin_payment_setting['is_mollie_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseEight" class="accordion-collapse collapse"
                                                aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="mollie_api_key"
                                                                    class="form-label">{{ __('Mollie Api Key') }}</label>
                                                                <input type="text" name="mollie_api_key"
                                                                    id="mollie_api_key" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['mollie_api_key']) ? $admin_payment_setting['mollie_api_key'] : '' }}"
                                                                    placeholder="{{ __('Mollie Api Key') }}" />
                                                                @if ($errors->has('mollie_api_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('mollie_api_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="mollie_profile_id"
                                                                    class="form-label">{{ __('Mollie Profile Id') }}</label>
                                                                <input type="text" name="mollie_profile_id"
                                                                    id="mollie_profile_id" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['mollie_profile_id']) ? $admin_payment_setting['mollie_profile_id'] : '' }}"
                                                                    placeholder="{{ __('Mollie Profile Id') }}" />
                                                                @if ($errors->has('mollie_profile_id'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('mollie_profile_id') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="mollie_partner_id"
                                                                    class="form-label">{{ __('Mollie Partner Id') }}</label>
                                                                <input type="text" name="mollie_partner_id"
                                                                    id="mollie_partner_id" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['mollie_partner_id']) ? $admin_payment_setting['mollie_partner_id'] : '' }}"
                                                                    placeholder="{{ __('Mollie Partner Id') }}" /><br>
                                                                @if ($errors->has('mollie_partner_id'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('mollie_partner_id') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingNine">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseNine"
                                                    aria-expanded="false" aria-controls="collapseNine">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Skrill') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_skrill_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_skrill_enabled"
                                                                value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_skrill_enabled" id="is_skrill_enabled"
                                                                {{ isset($admin_payment_setting['is_skrill_enabled']) && $admin_payment_setting['is_skrill_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseNine" class="accordion-collapse collapse"
                                                aria-labelledby="headingNine" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="mollie_api_key"
                                                                    class="form-label">{{ __('Skrill Email') }}</label>
                                                                <input type="email" name="skrill_email"
                                                                    id="skrill_email" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['skrill_email']) ? $admin_payment_setting['skrill_email'] : '' }}"
                                                                    placeholder="{{ __('Skrill Email') }}" /><br>
                                                                @if ($errors->has('skrill_email'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('skrill_email') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingTen">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTen"
                                                    aria-expanded="false" aria-controls="collapseTen">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('CoinGate') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_coingate_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_coingate_enabled"
                                                                value="off">
                                                            <input type="checkbox" class="form-check-input input-primary"
                                                                name="is_coingate_enabled" id="is_coingate_enabled"
                                                                {{ isset($admin_payment_setting['is_coingate_enabled']) && $admin_payment_setting['is_coingate_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseTen" class="accordion-collapse collapse"
                                                aria-labelledby="headingTen" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                            <div class="row pt-2">
                                                                <label class="pb-2"
                                                                    for="paypal_mode">{{ __('CoinGate Mode') }}</label>
                                                                <div class="col-lg-3">
                                                                    <div class="border card p-3">
                                                                        <div class="form-check">

                                                                            <label class="form-check-label d-block"
                                                                                for="">
                                                                                <input type="radio" name="coingate_mode"
                                                                                    class="form-check-input input-primary"
                                                                                    value="sandbox"
                                                                                    {{ (isset($admin_payment_setting['coingate_mode']) && $admin_payment_setting['coingate_mode'] == '') || (isset($admin_payment_setting['coingate_mode']) && $admin_payment_setting['coingate_mode'] == 'sandbox') ? 'checked="checked"' : '' }}>
                                                                                {{ __('Sandbox') }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="border card p-3">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label d-block"
                                                                                for="">
                                                                                <input type="radio"
                                                                                    class="form-check-input input-primary"
                                                                                    name="coingate_mode" value="live"
                                                                                    {{ isset($admin_payment_setting['coingate_mode']) && $admin_payment_setting['coingate_mode'] == 'live' ? 'checked="checked"' : '' }}>{{ __('Live') }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="coingate_auth_token"
                                                                    class="form-label">{{ __('CoinGate Auth Token') }}</label>
                                                                <input type="text" name="coingate_auth_token"
                                                                    id="coingate_auth_token" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['coingate_auth_token']) ? $admin_payment_setting['coingate_auth_token'] : '' }}"
                                                                    placeholder="{{ __('CoinGate Auth Token') }}" /><br>
                                                                @if ($errors->has('coingate_auth_token'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('coingate_auth_token') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingEleven">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseEleven"
                                                    aria-expanded="false" aria-controls="collapseEleven">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('PaymentWall') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_paymentwall_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_paymentwall_enabled"
                                                                value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_paymentwall_enabled"
                                                                id="is_paymentwall_enabled"
                                                                {{ isset($admin_payment_setting['is_paymentwall_enabled']) && $admin_payment_setting['is_paymentwall_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseEleven" class="accordion-collapse collapse"
                                                aria-labelledby="headingEleven" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="paymentwall_public_key"
                                                                    class="form-label">{{ __('Public Key') }}</label>
                                                                <input type="text" name="paymentwall_public_key"
                                                                    id="paymentwall_public_key" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['paymentwall_public_key']) ? $admin_payment_setting['paymentwall_public_key'] : '' }}"
                                                                    placeholder="{{ __('Public Key') }}" />
                                                                @if ($errors->has('paymentwall_public_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('paymentwall_public_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="paymentwall_private_key"
                                                                    class="form-label">{{ __('Private Key') }}</label>
                                                                <input type="text" name="paymentwall_private_key"
                                                                    id="paymentwall_private_key"
                                                                    class="form-control form-control-label"
                                                                    value="{{ isset($admin_payment_setting['paymentwall_private_key']) ? $admin_payment_setting['paymentwall_private_key'] : '' }}"
                                                                    placeholder="{{ __('Private Key') }}" /><br>
                                                                @if ($errors->has('paymentwall_private_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('paymentwall_private_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingtwelve">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwelve"
                                                    aria-expanded="false" aria-controls="collapseTwelve">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Toyyibpay') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_toyyibpay_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_toyyibpay_enabled"
                                                                value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_toyyibpay_enabled" id="is_toyyibpay_enabled"
                                                                {{ isset($admin_payment_setting['is_toyyibpay_enabled']) && $admin_payment_setting['is_toyyibpay_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseTwelve" class="accordion-collapse collapse"
                                                aria-labelledby="headingtwelve" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="toyyibpay_secret_key"
                                                                    class="form-label">{{ __('Secret Key') }}</label>
                                                                <input type="text" name="toyyibpay_secret_key"
                                                                    id="toyyibpay_secret_key" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['toyyibpay_secret_key']) ? $admin_payment_setting['toyyibpay_secret_key'] : '' }}"
                                                                    placeholder="{{ __('Secret Key') }}" />
                                                                @if ($errors->has('toyyibpay_secret_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('toyyibpay_secret_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="toyyibpay_category_code"
                                                                    class="form-label">{{ __('Category Code') }}</label>
                                                                <input type="text" name="toyyibpay_category_code"
                                                                    id="toyyibpay_category_code"
                                                                    class="form-control form-control-label"
                                                                    value="{{ isset($admin_payment_setting['toyyibpay_category_code']) ? $admin_payment_setting['toyyibpay_category_code'] : '' }}"
                                                                    placeholder="{{ __('Category Code') }}" /><br>
                                                                @if ($errors->has('toyyibpay_category_code'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('toyyibpay_category_code') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- payfast --}}
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingThirteen">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseThirteen"
                                                    aria-expanded="false" aria-controls="collapseThirteen">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Payfast') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_payfast_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_payfast_enabled"
                                                                value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_payfast_enabled" id="is_payfast_enabled"
                                                                {{ isset($admin_payment_setting['is_payfast_enabled']) && $admin_payment_setting['is_payfast_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseThirteen" class="accordion-collapse collapse"
                                                aria-labelledby="headingThirteen" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="row pt-2">
                                                            <label class="pb-2"
                                                                for="payfast_mode">{{ __('Payfast Mode') }}</label>
                                                            <div class="col-lg-3">
                                                                <div class="border card p-3">
                                                                    <div class="form-check">
                                                                        <input type="radio"
                                                                            class="form-check-input input-primary"
                                                                            name="payfast_mode" value="sandbox"
                                                                            {{ (isset($admin_payment_setting['payfast_mode']) && $admin_payment_setting['payfast_mode'] == '') || (isset($admin_payment_setting['payfast_mode']) && $admin_payment_setting['payfast_mode'] == 'sandbox') ? 'checked="checked"' : '' }}>
                                                                        <label class="form-check-label d-block"
                                                                            for="">
                                                                            <span>
                                                                                <span class="h5 d-block"><strong
                                                                                        class="float-end"></strong>{{ __('Sandbox') }}</span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="border card p-3">
                                                                    <div class="form-check">
                                                                        <input type="radio"
                                                                            class="form-check-input input-primary"
                                                                            name="payfast_mode" value="live"
                                                                            {{ isset($admin_payment_setting['payfast_mode']) && $admin_payment_setting['payfast_mode'] == 'live' ? 'checked="checked"' : '' }}>
                                                                        <label class="form-check-label d-block"
                                                                            for="">
                                                                            <span>
                                                                                <span class="h5 d-block"><strong
                                                                                        class="float-end"></strong>{{ __('Live') }}</span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row pt-2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="payfast_merchant_id"
                                                                    class="form-label">{{ __('Merchant Id') }}</label>
                                                                <input type="text" name="payfast_merchant_id"
                                                                    id="payfast_merchant_id" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['payfast_merchant_id']) ? $admin_payment_setting['payfast_merchant_id'] : '' }}"
                                                                    placeholder="{{ __('Merchant Id') }}" />
                                                                @if ($errors->has('payfast_merchant_id'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('payfast_merchant_id') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="payfast_merchant_key"
                                                                    class="form-label">{{ __('Merchant Key') }}</label>
                                                                <input type="text" name="payfast_merchant_key"
                                                                    id="payfast_merchant_key"
                                                                    class="form-control form-control-label"
                                                                    value="{{ isset($admin_payment_setting['payfast_merchant_key']) ? $admin_payment_setting['payfast_merchant_key'] : '' }}"
                                                                    placeholder="{{ __('Merchant Key') }}" /><br>
                                                                @if ($errors->has('payfast_merchant_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('payfast_merchant_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="payfast_signature"
                                                                    class="form-label">{{ __('Salt Passphrase') }}</label>
                                                                <input type="text" name="payfast_signature"
                                                                    id="payfast_signature"
                                                                    class="form-control form-control-label"
                                                                    value="{{ isset($admin_payment_setting['payfast_signature']) ? $admin_payment_setting['payfast_signature'] : '' }}"
                                                                    placeholder="{{ __('Salt Passphrase') }}" /><br>
                                                                @if ($errors->has('payfast_signature'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('payfast_signature') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- payfast --}}
                                        {{-- iyzifast --}}
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingsixteen">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsesixteen"
                                                    aria-expanded="false" aria-controls="collapsesixteen">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Iyzipay') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_iyzipay_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_iyzipay_enabled"
                                                                value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_iyzipay_enabled" id="is_iyzipay_enabled"
                                                                {{ isset($admin_payment_setting['is_iyzipay_enabled']) && $admin_payment_setting['is_iyzipay_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapsesixteen" class="accordion-collapse collapse"
                                                aria-labelledby="headingsixteen" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="row pt-2">
                                                            <label class="pb-2"
                                                                for="iyzipay_mode">{{ __('Iyzipay Mode') }}</label>
                                                            <div class="col-lg-3">
                                                                <div class="border card p-3">
                                                                    <div class="form-check">
                                                                        <input type="radio"
                                                                            class="form-check-input input-primary"
                                                                            name="iyzipay_mode" value="sandbox"
                                                                            {{ (isset($admin_payment_setting['iyzipay_mode']) && $admin_payment_setting['iyzipay_mode'] == '') || (isset($admin_payment_setting['iyzipay_mode']) && $admin_payment_setting['iyzipay_mode'] == 'sandbox') ? 'checked="checked"' : '' }}>
                                                                        <label class="form-check-label d-block"
                                                                            for="">
                                                                            <span>
                                                                                <span class="h5 d-block"><strong
                                                                                        class="float-end"></strong>{{ __('Sandbox') }}</span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="border card p-3">
                                                                    <div class="form-check">
                                                                        <input type="radio"
                                                                            class="form-check-input input-primary"
                                                                            name="iyzipay_mode" value="live"
                                                                            {{ isset($admin_payment_setting['iyzipay_mode']) && $admin_payment_setting['iyzipay_mode'] == 'live' ? 'checked="checked"' : '' }}>
                                                                        <label class="form-check-label d-block"
                                                                            for="">
                                                                            <span>
                                                                                <span class="h5 d-block"><strong
                                                                                        class="float-end"></strong>{{ __('Live') }}</span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row pt-2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="iyzipay_key"
                                                                    class="form-label">{{ __('Iyzipay Key') }}</label>
                                                                <input type="text" name="iyzipay_key"
                                                                    id="iyzipay_key"
                                                                    class="form-control form-control-label"
                                                                    value="{{ isset($admin_payment_setting['iyzipay_key']) ? $admin_payment_setting['iyzipay_key'] : '' }}"
                                                                    placeholder="{{ __('Iyzipay Key') }}" /><br>
                                                                @if ($errors->has('iyzipay_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('iyzipay_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="iyzipay_secret"
                                                                    class="form-label">{{ __('Iyzipay Secret') }}</label>
                                                                <input type="text" name="iyzipay_secret"
                                                                    id="iyzipay_secret" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['iyzipay_secret']) ? $admin_payment_setting['iyzipay_secret'] : '' }}"
                                                                    placeholder="{{ __('Iyzipay Secret') }}" />
                                                                @if ($errors->has('iyzipay_secret'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('iyzipay_secret') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- iyzifastfast End  --}}
                                        {{-- ssPay --}}
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingseventeen">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseseventeen"
                                                    aria-expanded="false" aria-controls="collapseseventeen">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('SSpay') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_sspay_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_sspay_enabled"
                                                                value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_sspay_enabled" id="is_sspay_enabled"
                                                                {{ isset($admin_payment_setting['is_sspay_enabled']) && $admin_payment_setting['is_sspay_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseseventeen" class="accordion-collapse collapse"
                                                aria-labelledby="headingseventeen" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="sspay_secret_key"
                                                                    class="form-label">{{ __('Secret Key') }}</label>
                                                                <input type="text" name="sspay_secret_key"
                                                                    id="sspay_secret_key" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['sspay_secret_key']) ? $admin_payment_setting['sspay_secret_key'] : '' }}"
                                                                    placeholder="{{ __('Secret Key') }}" />
                                                                @if ($errors->has('sspay_secret_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('sspay_secret_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="sspay_category_code"
                                                                    class="form-label">{{ __('Category Code') }}</label>
                                                                <input type="text" name="sspay_category_code"
                                                                    id="sspay_category_code"
                                                                    class="form-control form-control-label"
                                                                    value="{{ isset($admin_payment_setting['sspay_category_code']) ? $admin_payment_setting['sspay_category_code'] : '' }}"
                                                                    placeholder="{{ __('Category Code') }}" /><br>
                                                                @if ($errors->has('sspay_category_code'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('sspay_category_code') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- ssPay End --}}
                                        {{-- Paytab --}}
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingeightteen">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseeightteen"
                                                    aria-expanded="false" aria-controls="collapseeightteen">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Paytab') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_paytab_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_paytab_enabled"
                                                                value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_paytab_enabled" id="is_paytab_enabled"
                                                                {{ isset($admin_payment_setting['is_paytab_enabled']) && $admin_payment_setting['is_paytab_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseeightteen" class="accordion-collapse collapse"
                                                aria-labelledby="headingeightteen" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="paytab_profile_id"
                                                                    class="form-label">{{ __('Profile Id') }}</label>
                                                                <input type="text" name="paytab_profile_id"
                                                                    id="paytab_profile_id" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['paytab_profile_id']) ? $admin_payment_setting['paytab_profile_id'] : '' }}"
                                                                    placeholder="{{ __('Profile Id') }}" />
                                                                @if ($errors->has('paytab_profile_id'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('paytab_profile_id') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="paytab_server_key"
                                                                    class="form-label">{{ __('Server Key') }}</label>
                                                                <input type="text" name="paytab_server_key"
                                                                    id="paytab_server_key"
                                                                    class="form-control form-control-label"
                                                                    value="{{ isset($admin_payment_setting['paytab_server_key']) ? $admin_payment_setting['paytab_server_key'] : '' }}"
                                                                    placeholder="{{ __('Server Key') }}" /><br>
                                                                @if ($errors->has('paytab_server_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('paytab_server_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="paytab_region"
                                                                    class="form-label">{{ __('Region') }}</label>
                                                                <input type="text" name="paytab_region"
                                                                    id="paytab_region"
                                                                    class="form-control form-control-label"
                                                                    value="{{ isset($admin_payment_setting['paytab_region']) ? $admin_payment_setting['paytab_region'] : '' }}"
                                                                    placeholder="{{ __('Region') }}" /><br>
                                                                @if ($errors->has('paytab_region'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('paytab_region') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- PayTab End --}}
                                        {{-- Benefit --}}
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingNineteen">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseNineteen"
                                                    aria-expanded="false" aria-controls="collapseNineteen">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Benefit') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_benefit_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_benefit_enabled"
                                                                value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_benefit_enabled" id="is_benefit_enabled"
                                                                {{ isset($admin_payment_setting['is_benefit_enabled']) && $admin_payment_setting['is_benefit_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseNineteen" class="accordion-collapse collapse"
                                                aria-labelledby="headingNineteen" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                            <div class="row pt-2">
                                                                <label class="pb-2"
                                                                    for="benefit_mode">{{ __('Benefit Mode') }}</label>
                                                                <div class="col-lg-3">
                                                                    <div class="border card p-3">
                                                                        <div class="form-check">
                                                                            <input type="radio"
                                                                                class="form-check-input input-primary"
                                                                                name="benefit_mode" value="sandbox"
                                                                                {{ (isset($admin_payment_setting['benefit_mode']) && $admin_payment_setting['benefit_mode'] == '') || (isset($admin_payment_setting['benefit_mode']) && $admin_payment_setting['benefit_mode'] == 'sandbox') ? 'checked="checked"' : '' }}>
                                                                            <label class="form-check-label d-block"
                                                                                for="">
                                                                                <span>
                                                                                    <span class="h5 d-block"><strong
                                                                                            class="float-end"></strong>{{ __('Sandbox') }}</span>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="border card p-3">
                                                                        <div class="form-check">
                                                                            <input type="radio"
                                                                                class="form-check-input input-primary"
                                                                                name="benefit_mode" value="live"
                                                                                {{ isset($admin_payment_setting['benefit_mode']) && $admin_payment_setting['benefit_mode'] == 'live' ? 'checked="checked"' : '' }}>
                                                                            <label class="form-check-label d-block"
                                                                                for="">
                                                                                <span>
                                                                                    <span class="h5 d-block"><strong
                                                                                            class="float-end"></strong>{{ __('Live') }}</span>
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="benefit_secret_key"
                                                                    class="form-label">{{ __('Secret Key') }}</label>
                                                                <input type="text" name="benefit_secret_key"
                                                                    id="benefit_secret_key" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['benefit_secret_key']) ? $admin_payment_setting['benefit_secret_key'] : '' }}"
                                                                    placeholder="{{ __('Secret Key') }}" />
                                                                @if ($errors->has('benefit_secret_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('benefit_secret_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="benefit_publishable_key"
                                                                    class="form-label">{{ __('Publishable Key') }}</label>
                                                                <input type="text" name="benefit_publishable_key"
                                                                    id="benefit_publishable_key" class="form-control"
                                                                    value="{{ isset($admin_payment_setting['benefit_publishable_key']) ? $admin_payment_setting['benefit_publishable_key'] : '' }}"
                                                                    placeholder="{{ __('Publishable Key') }}" /><br>
                                                                @if ($errors->has('benefit_publishable_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('benefit_publishable_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Benefit End --}}
                                        {{-- Cashfree --}}
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingTwenty">
                                                <button class="accordion-button" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwenty"
                                                    aria-expanded="true" aria-controls="collapseTwenty">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Cashfree') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_cashfree_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_cashfree_enabled"
                                                                value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_cashfree_enabled" id="is_cashfree_enabled"
                                                                {{ isset($admin_payment_setting['is_cashfree_enabled']) && $admin_payment_setting['is_cashfree_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseTwenty" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwenty" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('cashfree_key', __('Cashfree Key'), ['class' => 'form-label']) }}
                                                                {{ Form::text('cashfree_key', isset($admin_payment_setting['cashfree_key']) ? $admin_payment_setting['cashfree_key'] : '', ['class' => 'form-control', 'placeholder' => __('Cashfree Key')]) }}<br>
                                                                @if ($errors->has('cashfree_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('cashfree_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('cashfree_secret', __('Cashfree Secret'), ['class' => 'form-label']) }}
                                                                {{ Form::text('cashfree_secret', isset($admin_payment_setting['cashfree_secret']) ? $admin_payment_setting['cashfree_secret'] : '', ['class' => 'form-control ', 'placeholder' => __('Cashfree Secret')]) }}
                                                                @if ($errors->has('cashfree_secret'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('cashfree_secret') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Casefree End  --}}
                                        {{-- Aamarpay --}}
                                        <div class="accordion-item card">
                                            <h2 class="accordion-header" id="headingTwenty-One">
                                                <button class="accordion-button" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwenty-One"
                                                    aria-expanded="true" aria-controls="collapseTwenty-One">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Aamarpay') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_aamarpay_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_aamarpay_enabled"
                                                                value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_aamarpay_enabled" id="is_aamarpay_enabled"
                                                                {{ isset($admin_payment_setting['is_aamarpay_enabled']) && $admin_payment_setting['is_aamarpay_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseTwenty-One" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwenty-One" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('aamarpay_store_id', __('Store Id'), ['class' => 'form-label']) }}
                                                                {{ Form::text('aamarpay_store_id', isset($admin_payment_setting['aamarpay_store_id']) ? $admin_payment_setting['aamarpay_store_id'] : '', ['class' => 'form-control', 'placeholder' => __('Store Id')]) }}<br>
                                                                @if ($errors->has('aamarpay_store_id'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('aamarpay_store_id') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('aamarpay_signature_key', __('Signature Key'), ['class' => 'form-label']) }}
                                                                {{ Form::text('aamarpay_signature_key', isset($admin_payment_setting['aamarpay_signature_key']) ? $admin_payment_setting['aamarpay_signature_key'] : '', ['class' => 'form-control', 'placeholder' => __('Signature Key')]) }}<br>
                                                                @if ($errors->has('aamarpay_signature_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('aamarpay_signature_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('aamarpay_description', __('Description'), ['class' => 'form-label']) }}
                                                                {{ Form::text('aamarpay_description', isset($admin_payment_setting['aamarpay_description']) ? $admin_payment_setting['aamarpay_description'] : '', ['class' => 'form-control', 'placeholder' => __('Description')]) }}<br>
                                                                @if ($errors->has('aamarpay_description'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('aamarpay_description') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Aamarpay End  --}}
                                        {{-- Paytr --}}
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwentytwo">
                                                <button class="accordion-button" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwentytwo"
                                                    aria-expanded="true" aria-controls="collapseTwentytwo">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Pay TR') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_paytr_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_paytr_enabled"
                                                                value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_paytr_enabled" id="is_paytr_enabled"
                                                                {{ isset($admin_payment_setting['is_paytr_enabled']) && $admin_payment_setting['is_paytr_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseTwentytwo" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwentyfour" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {{ Form::label('paytr_merchant_id', __('Merchant Id'), ['class' => 'form-label']) }}
                                                                {{ Form::text('paytr_merchant_id', isset($admin_payment_setting['paytr_merchant_id']) ? $admin_payment_setting['paytr_merchant_id'] : '', ['class' => 'form-control', 'placeholder' => __('Merchant Id')]) }}<br>
                                                                @if ($errors->has('paytr_merchant_id'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('paytr_merchant_id') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {{ Form::label('paytr_merchant_key', __('Merchant Key'), ['class' => 'form-label']) }}
                                                                {{ Form::text('paytr_merchant_key', isset($admin_payment_setting['paytr_merchant_key']) ? $admin_payment_setting['paytr_merchant_key'] : '', ['class' => 'form-control', 'placeholder' => __('Merchant Key')]) }}<br>
                                                                @if ($errors->has('paytr_merchant_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('paytr_merchant_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {{ Form::label('paytr_merchant_salt', __('Merchant Salt'), ['class' => 'form-label']) }}
                                                                {{ Form::text('paytr_merchant_salt', isset($admin_payment_setting['paytr_merchant_salt']) ? $admin_payment_setting['paytr_merchant_salt'] : '', ['class' => 'form-control', 'placeholder' => __('Merchant Salt')]) }}<br>
                                                                @if ($errors->has('paytr_merchant_salt'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('paytr_merchant_salt') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Paytr End--}}

                                        {{-- Midtrans --}}
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwentythree">
                                                <button class="accordion-button" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwentythree"
                                                    aria-expanded="true" aria-controls="collapseTwentythree">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Midtrans') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_midtrans_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_midtrans_enabled"
                                                                value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_midtrans_enabled" id="is_midtrans_enabled"
                                                                {{ isset($admin_payment_setting['is_midtrans_enabled']) && $admin_payment_setting['is_midtrans_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseTwentythree" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwentyfour" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('secret_key', __('Secret Key'), ['class' => 'form-label']) }}
                                                                {{ Form::text('midtrans_secret_key', isset($admin_payment_setting['midtrans_secret_key']) ? $admin_payment_setting['midtrans_secret_key'] : '', ['class' => 'form-control', 'placeholder' => __('Secret Key')]) }}<br>
                                                                @if ($errors->has('midtrans_secret_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('midtrans_secret_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Midtrans End--}}

                                        {{-- Xendit --}}
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwentyfour">
                                                <button class="accordion-button" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwentyfour"
                                                    aria-expanded="true" aria-controls="collapseTwentyfour">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('Xendit') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_xendit_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_xendit_enabled"
                                                                value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_xendit_enabled" id="is_xendit_enabled"
                                                                {{ isset($admin_payment_setting['is_xendit_enabled']) && $admin_payment_setting['is_xendit_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseTwentyfour" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwentyfour" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('Api Key', __('API Key'), ['class' => 'form-label']) }}
                                                                {{ Form::text('xendit_api_key', isset($admin_payment_setting['xendit_api_key']) ? $admin_payment_setting['xendit_api_key'] : '', ['class' => 'form-control', 'placeholder' => __('Secret Key')]) }}<br>
                                                                @if ($errors->has('xendit_api_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('xendit_api_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('xendit_token', __('Xendit Token'), ['class' => 'form-label']) }}
                                                                {{ Form::text('xendit_token', isset($admin_payment_setting['xendit_token']) ? $admin_payment_setting['xendit_token'] : '', ['class' => 'form-control', 'placeholder' => __('Secret Key')]) }}<br>
                                                                @if ($errors->has('xendit_token'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('xendit_token') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Xendit End--}}

                                         {{-- YooKassa --}}
                                         <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwentyfive">
                                                <button class="accordion-button" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwentyfive"
                                                    aria-expanded="true" aria-controls="collapseTwentyfive">
                                                    <span class="d-flex align-items-center">
                                                        {{ __('YooKassa') }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <label class="form-check-label m-1"
                                                            for="is_yookassa_enabled">{{ __('Enable') }}</label>
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <input type="hidden" name="is_yookassa_enabled"
                                                                value="off">
                                                            <input type="checkbox"
                                                                class="form-check-input input-primary"
                                                                name="is_yookassa_enabled" id="is_yookassa_enabled"
                                                                {{ isset($admin_payment_setting['is_yookassa_enabled']) && $admin_payment_setting['is_yookassa_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                        </div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapseTwentyfive" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwentyfive" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row pt-2">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('shop_id', __('YooKassa Shop Id'), ['class' => 'form-label']) }}
                                                                {{ Form::text('yookassa_shop_id', isset($admin_payment_setting['yookassa_shop_id']) ? $admin_payment_setting['yookassa_shop_id'] : '', ['class' => 'form-control', 'placeholder' => __('Secret Key')]) }}<br>
                                                                @if ($errors->has('yookassa_shop_id'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('yookassa_shop_id') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                {{ Form::label('yookassa_secret_key', __('YooKassa Secret Key'), ['class' => 'form-label']) }}
                                                                {{ Form::text('yookassa_secret_key', isset($admin_payment_setting['yookassa_secret_key']) ? $admin_payment_setting['yookassa_secret_key'] : '', ['class' => 'form-control', 'placeholder' => __('YooKassa Secret Key')]) }}<br>
                                                                @if ($errors->has('yookassa_secret_key'))
                                                                    <span class="invalid-feedback d-block">
                                                                        {{ $errors->first('yookassa_secret_key') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- YooKassa End--}}
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <div class="">
                                    <div class="form-group  float-end">
                                        {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-print-invoice  btn-primary ']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <div id="recaptcha-settings" class="card">
                        <form method="POST" action="{{ route('recaptcha.settings.store') }}"
                            accept-charset="UTF-8">
                            @csrf
                            <div class="card-header row d-flex justify-content-between">
                                <div class="col-auto">
                                    <h5>{{ __('ReCaptcha Settings') }}</h5>
                                    <small class="text-muted"><a
                                            href="https://phppot.com/php/how-to-get-google-recaptcha-site-and-secret-key/"
                                            target="_blank" class="text-muted">
                                            ({{ __('How to Get Google reCaptcha Site and Secret key') }})
                                        </a>
                                    </small><br>
                                </div>
                                <div class="col-auto">
                                    <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary"
                                        name="recaptcha_module" id="recaptcha_module" value="yes"
                                        {{ $setting['RECAPTCHA_MODULE'] == 'yes' ? 'checked="checked"' : '' }}>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="google_recaptcha_key"
                                                class="form-label">{{ __('Google Recaptcha Key') }}</label>
                                            <input class="form-control"
                                                placeholder="{{ __('Enter Google Recaptcha Key') }}"
                                                name="google_recaptcha_key" type="text"
                                                value="{{$setting['NOCAPTCHA_SITEKEY'] }}" id="google_recaptcha_key">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="google_recaptcha_secret"
                                                class="form-label">{{ __('Google Recaptcha Secret') }}</label>
                                            <input class="form-control "
                                                placeholder="{{ __('Enter Google Recaptcha Secret') }}"
                                                name="google_recaptcha_secret" type="text"
                                                value="{{ $setting['NOCAPTCHA_SECRET'] }}" id="google_recaptcha_secret">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <div class="">
                                    <div class="form-group  float-end">
                                        {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-print-invoice  btn-primary']) }}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="storage-settings" class="card mb-3">
                        {{ Form::open(['route' => 'storage.setting.store', 'enctype' => 'multipart/form-data']) }}
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-10">
                                    <h5 class="">{{ __('Storage Settings') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="pe-2">
                                    <input type="radio" class="btn-check" name="storage_setting"
                                        id="local-outlined" autocomplete="off"
                                        {{ $setting['storage_setting'] == 'local' ? 'checked' : '' }} value="local"
                                        checked>
                                    <label class="btn btn-outline-primary"
                                        for="local-outlined">{{ __('Local') }}</label>
                                </div>
                                <div class="pe-2">
                                    <input type="radio" class="btn-check" name="storage_setting" id="s3-outlined"
                                        autocomplete="off" {{ $setting['storage_setting'] == 's3' ? 'checked' : '' }}
                                        value="s3">
                                    <label class="btn btn-outline-primary" for="s3-outlined">
                                        {{ __('AWS S3') }}</label>
                                </div>

                                <div class="pe-2">
                                    <input type="radio" class="btn-check" name="storage_setting"
                                        id="wasabi-outlined" autocomplete="off"
                                        {{ $setting['storage_setting'] == 'wasabi' ? 'checked' : '' }} value="wasabi">
                                    <label class="btn btn-outline-primary"
                                        for="wasabi-outlined">{{ __('Wasabi') }}</label>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div
                                    class="local-setting row {{ $setting['storage_setting'] == 'local' ? ' ' : 'd-none' }}">
                                    <div class="col-lg-8 col-md-11 col-sm-12">
                                        {{ Form::label('local_storage_validation', __('Only Upload Files'), ['class' => ' form-label']) }}
                                        <select name="local_storage_validation[]" class="form-control"
                                            name="choices-multiple-remove-button" id="choices-multiple-remove-button"
                                            placeholder="This is a placeholder" multiple>
                                            @foreach ($file_type as $f)
                                                <option @if (in_array($f, $local_storage_validations)) selected @endif>
                                                    {{ $f }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="local_storage_max_upload_size">{{ __('Max upload size ( In KB)') }}</label>
                                            <input type="number" name="local_storage_max_upload_size"
                                                class="form-control"
                                                value="{{ !isset($setting['local_storage_max_upload_size']) || is_null($setting['local_storage_max_upload_size']) ? '' : $setting['local_storage_max_upload_size'] }}"
                                                placeholder="{{ __('Max upload size') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="s3-setting row {{ $setting['storage_setting'] == 's3' ? ' ' : 'd-none' }}">

                                    <div class=" row ">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="s3_key">{{ __('S3 Key') }}</label>
                                                <input type="text" name="s3_key" class="form-control"
                                                    value="{{ !isset($setting['s3_key']) || is_null($setting['s3_key']) ? '' : $setting['s3_key'] }}"
                                                    placeholder="{{ __('S3 Key') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_secret">{{ __('S3 Secret') }}</label>
                                                <input type="text" name="s3_secret" class="form-control"
                                                    value="{{ !isset($setting['s3_secret']) || is_null($setting['s3_secret']) ? '' : $setting['s3_secret'] }}"
                                                    placeholder="{{ __('S3 Secret') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_region">{{ __('S3 Region') }}</label>
                                                <input type="text" name="s3_region" class="form-control"
                                                    value="{{ !isset($setting['s3_region']) || is_null($setting['s3_region']) ? '' : $setting['s3_region'] }}"
                                                    placeholder="{{ __('S3 Region') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_bucket">{{ __('S3 Bucket') }}</label>
                                                <input type="text" name="s3_bucket" class="form-control"
                                                    value="{{ !isset($setting['s3_bucket']) || is_null($setting['s3_bucket']) ? '' : $setting['s3_bucket'] }}"
                                                    placeholder="{{ __('S3 Bucket') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="s3_url">{{ __('S3 URL') }}</label>
                                                <input type="text" name="s3_url" class="form-control"
                                                    value="{{ !isset($setting['s3_url']) || is_null($setting['s3_url']) ? '' : $setting['s3_url'] }}"
                                                    placeholder="{{ __('S3 URL') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_endpoint">{{ __('S3 Endpoint') }}</label>
                                                <input type="text" name="s3_endpoint" class="form-control"
                                                    value="{{ !isset($setting['s3_endpoint']) || is_null($setting['s3_endpoint']) ? '' : $setting['s3_endpoint'] }}"
                                                    placeholder="{{ __('S3 Endpoint') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-8 switch-width">
                                            {{ Form::label('s3_storage_validation', __('Only Upload Files'), ['class' => ' form-label']) }}
                                            <select name="s3_storage_validation[]" class="form-control"
                                                name="choices-multiple-remove-button"
                                                id="choices-multiple-remove-button1" placeholder="This is a placeholder"
                                                multiple>
                                                @foreach ($file_type as $f)
                                                    <option @if (in_array($f, $s3_storage_validations)) selected @endif>
                                                        {{ $f }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_max_upload_size">{{ __('Max upload size ( In KB)') }}</label>
                                                <input type="number" name="s3_max_upload_size" class="form-control"
                                                    value="{{ !isset($setting['s3_max_upload_size']) || is_null($setting['s3_max_upload_size']) ? '' : $setting['s3_max_upload_size'] }}"
                                                    placeholder="{{ __('Max upload size') }}">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div
                                    class="wasabi-setting row {{ $setting['storage_setting'] == 'wasabi' ? ' ' : 'd-none' }}">
                                    <div class=" row ">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_key">{{ __('Wasabi Key') }}</label>
                                                <input type="text" name="wasabi_key" class="form-control"
                                                    value="{{ !isset($setting['wasabi_key']) || is_null($setting['wasabi_key']) ? '' : $setting['wasabi_key'] }}"
                                                    placeholder="{{ __('Wasabi Key') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_secret">{{ __('Wasabi Secret') }}</label>
                                                <input type="text" name="wasabi_secret" class="form-control"
                                                    value="{{ !isset($setting['wasabi_secret']) || is_null($setting['wasabi_secret']) ? '' : $setting['wasabi_secret'] }}"
                                                    placeholder="{{ __('Wasabi Secret') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="s3_region">{{ __('Wasabi Region') }}</label>
                                                <input type="text" name="wasabi_region" class="form-control"
                                                    value="{{ !isset($setting['wasabi_region']) || is_null($setting['wasabi_region']) ? '' : $setting['wasabi_region'] }}"
                                                    placeholder="{{ __('Wasabi Region') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_bucket">{{ __('Wasabi Bucket') }}</label>
                                                <input type="text" name="wasabi_bucket" class="form-control"
                                                    value="{{ !isset($setting['wasabi_bucket']) || is_null($setting['wasabi_bucket']) ? '' : $setting['wasabi_bucket'] }}"
                                                    placeholder="{{ __('Wasabi Bucket') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_url">{{ __('Wasabi URL') }}</label>
                                                <input type="text" name="wasabi_url" class="form-control"
                                                    value="{{ !isset($setting['wasabi_url']) || is_null($setting['wasabi_url']) ? '' : $setting['wasabi_url'] }}"
                                                    placeholder="{{ __('Wasabi URL') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_root">{{ __('Wasabi Root') }}</label>
                                                <input type="text" name="wasabi_root" class="form-control"
                                                    value="{{ !isset($setting['wasabi_root']) || is_null($setting['wasabi_root']) ? '' : $setting['wasabi_root'] }}"
                                                    placeholder="{{ __('Wasabi Root') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-8 switch-width">
                                            {{ Form::label('wasabi_storage_validation', __('Only Upload Files'), ['class' => 'form-label']) }}

                                            <select name="wasabi_storage_validation[]" class="form-control"
                                                name="choices-multiple-remove-button"
                                                id="choices-multiple-remove-button2" placeholder="This is a placeholder"
                                                multiple>
                                                @foreach ($file_type as $f)
                                                    <option @if (in_array($f, $wasabi_storage_validations)) selected @endif>
                                                        {{ $f }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="wasabi_root">{{ __('Max upload size ( In KB)') }}</label>
                                                <input type="number" name="wasabi_max_upload_size"
                                                    class="form-control"
                                                    value="{{ !isset($setting['wasabi_max_upload_size']) || is_null($setting['wasabi_max_upload_size']) ? '' : $setting['wasabi_max_upload_size'] }}"
                                                    placeholder="{{ __('Max upload size') }}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div><br>
                        </div>

                        <div class="card-footer text-end">
                            <input class="btn btn-print-invoice  btn-primary" type="submit"
                                value="{{ __('Save Changes') }}">

                        </div>
                        {{ Form::close() }}
                    </div>
                    <div id="cache-settings" class="card">
                        <form method="POST" action="{{ route('cache.settings.clear') }}" accept-charset="UTF-8">
                            @csrf
                            <div class="card-header row d-flex justify-content-between">
                                <div class="col-auto">
                                    <h5>{{ __('Cache Settings') }}</h5>
                                    <small class="text-muted"><a
                                            href="https://phppot.com/php/how-to-get-google-recaptcha-site-and-secret-key/"
                                            target="_blank" class="text-muted">
                                            {{ __("This is a page meant for more advanced users, simply ignore it if you don't understand what cache is.") }}
                                        </a>
                                    </small><br>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                            <label for="current_cache_size"
                                                class="form-label">{{ __('Current cache size') }}</label>
                                            <div class="input-group search-form">
                                                <input type="text" value="{{ $file_size }}"
                                                    class="form-control" disabled>
                                                <span class="input-group-text bg-transparent">{{ __('MB') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <div class="">
                                    <div class="form-group float-end">
                                        {{ Form::submit(__('Clear Cache'), ['class' => 'btn btn-print-invoice  btn-primary']) }}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- Cookie Code Start --}}
                    <div class="card" id="cookie-settings">
                        {{ Form::model($settings, ['route' => 'cookie.setting', 'method' => 'post']) }}
                        <div
                            class="card-header flex-column flex-lg-row  d-flex align-items-lg-center gap-2 justify-content-between">
                            <h5>{{ __('Cookie Settings') }}</h5>
                            <div class="d-flex align-items-center">
                                {{ Form::label('enable_cookie', __('Enable cookie'), ['class' => 'col-form-label p-0 fw-bold me-3']) }}
                                <div class="custom-control custom-switch" onclick="enablecookie()">
                                    <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary"
                                        name="enable_cookie" class="form-check-input input-primary "
                                        id="enable_cookie" {{ $settings['enable_cookie'] == 'on' ? ' checked ' : '' }}>
                                    <label class="custom-control-label mb-1" for="enable_cookie"></label>
                                </div>
                            </div>
                        </div>
                        <div
                            class="card-body cookieDiv {{ $settings['enable_cookie'] == 'off' ? 'disabledCookie ' : '' }}">
                            @if (isset($chatgpt_setting['chatgpt_key']) && !empty($chatgpt_setting['chatgpt_key']))
                                <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end {{ $settings['enable_cookie'] == 'off' ? 'disabledCookie ' : '' }}"
                                    data-bs-placement="top">
                                    <a href="#" data-size="lg" class="btn btn-sm btn-primary"
                                        data-ajax-popup-over="true" data-url="{{ route('generate', ['cookie']) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ __('Generate') }}"
                                        data-title="{{ __('Generate content with AI') }}">
                                        <i class="fas fa-robot"></i>&nbsp;{{ __('Generate with AI') }}
                                    </a>
                                </div>
                            @endif
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-check form-switch custom-switch-v1" id="cookie_log">
                                        <input type="checkbox" name="cookie_logging"
                                            class="form-check-input input-primary cookie_setting"
                                            id="cookie_logging"{{ $settings['cookie_logging'] == 'on' ? ' checked ' : '' }}>
                                        <label class="form-check-label"
                                            for="cookie_logging">{{ __('Enable logging') }}</label>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('cookie_title', __('Cookie Title'), ['class' => 'col-form-label']) }}
                                        {{ Form::text('cookie_title', null, ['class' => 'form-control cookie_setting']) }}
                                    </div>
                                    <div class="form-group ">
                                        {{ Form::label('cookie_description', __('Cookie Description'), ['class' => ' form-label']) }}
                                        {!! Form::textarea('cookie_description', null, ['class' => 'form-control cookie_setting', 'rows' => '3']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch custom-switch-v1 ">
                                        <input type="checkbox" name="necessary_cookies"
                                            class="form-check-input input-primary" id="necessary_cookies" checked
                                            onclick="return false">
                                        <label class="form-check-label"
                                            for="necessary_cookies">{{ __('Strictly necessary cookies') }}</label>
                                    </div>
                                    <div class="form-group ">
                                        {{ Form::label('strictly_cookie_title', __(' Strictly Cookie Title'), ['class' => 'col-form-label']) }}
                                        {{ Form::text('strictly_cookie_title', null, ['class' => 'form-control cookie_setting']) }}
                                    </div>
                                    <div class="form-group ">
                                        {{ Form::label('strictly_cookie_description', __('Strictly Cookie Description'), ['class' => ' form-label']) }}
                                        {!! Form::textarea('strictly_cookie_description', null, [
                                            'class' => 'form-control cookie_setting ',
                                            'rows' => '3',
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-12">
                                    <h5>{{ __('More Information') }}</h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        {{ Form::label('more_information_description', __('Contact Us Description'), ['class' => 'col-form-label']) }}
                                        {{ Form::text('more_information_description', null, ['class' => 'form-control cookie_setting']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        {{ Form::label('contactus_url', __('Contact Us URL'), ['class' => 'col-form-label']) }}
                                        {{ Form::text('contactus_url', null, ['class' => 'form-control cookie_setting']) }}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div
                            class="card-footer d-flex align-items-center gap-2 flex-sm-column flex-lg-row justify-content-between">
                            <div>
                                @if (isset($settings['cookie_logging']) && $settings['cookie_logging'] == 'on')
                                    <label for="file"
                                        class="form-label">{{ __('Download cookie accepted data') }}</label>
                                    <a href="{{ asset(Storage::url('uploads/sample')) . '/data.csv' }}"
                                        class="btn btn-primary mr-2 ">
                                        <i class="ti ti-download"></i>
                                    </a>
                                @endif
                            </div>
                            <input type="submit" value="{{ __('Save Changes') }}" class="btn btn-primary">
                        </div>
                        {{ Form::close() }}
                    </div>
                    {{-- Cookie Code End --}}
                    {{-- chatGpt --}}
                    <div class="tab-pane" id="chatgpt-settings" role="tabpanel" aria-labelledby="pills-chatgpt-tab">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card">
                                {{ Form::model($settings, ['route' => 'settings.chatgptkey', 'method' => 'post']) }}
                                <div class="card-header">
                                    <h5>{{ __('Chat GPT Key Settings') }}</h5>
                                    <small>{{ __('Edit your key details') }}</small>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group">
                                            {{ Form::text('chatgpt_key', isset($settings['chatgpt_key']) ? $settings['chatgpt_key'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Chatgpt Key Here')]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                    {{-- chatGpt End --}}
                    <!-- [ sample-page ] end -->
                </div>
                <!-- [ Main Content ] end -->
            </div>
        </div>
    </div>
@endsection
