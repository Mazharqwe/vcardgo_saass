@php
    $social_no = 1;
    $appointment_no = 0;
    $service_row_no = 0;
    $product_row_no = 0;
    $testimonials_row_no = 0;
    $gallery_row_no = 0;
    $path = isset($business->banner) && !empty($business->banner) ? asset(Storage::url('card_banner/' . $business->banner)) : asset('custom/img/placeholder-image.jpg');
    $no = 1;
    $stringid = $business->id;
    $is_enable = false;
    $is_contact_enable = false;
    $is_enable_appoinment = false;
    $is_enable_service = false;
    $is_enable_product = false;
    $is_enable_testimonials = false;
    $is_enable_sociallinks = false;
    $is_custom_html_enable = false;
    $is_enable_gallery = false;
    $custom_html = $business->custom_html_text;
    $is_branding_enabled = false;
    $branding = $business->branding_text;
    $is_gdpr_enabled = false;
    $gdpr_text = $business->gdpr_text;
    $card_theme = json_decode($business->card_theme);
    $banner = \App\Models\Utility::get_file('card_banner');
    $logo = \App\Models\Utility::get_file('card_logo');
    $image = \App\Models\Utility::get_file('testimonials_images');
    $s_image = \App\Models\Utility::get_file('service_images');
    $pr_image = \App\Models\Utility::get_file('product_images');
    $company_favicon = Utility::getsettingsbyid($business->created_by);
    $company_favicon = $company_favicon['company_favicon'];
    $logo1 = \App\Models\Utility::get_file('uploads/logo/');
    $meta_image = \App\Models\Utility::get_file('meta_image');
    $gallery_path = \App\Models\Utility::get_file('gallery');
    $qr_path = \App\Models\Utility::get_file('qrcode');
    
    if (!is_null($contactinfo) && !is_null($contactinfo)) {
        $contactinfo['is_enabled'] == '1' ? ($is_contact_enable = true) : ($is_contact_enable = false);
    }
    if (!is_null($business_hours) && !is_null($businesshours)) {
        $businesshours['is_enabled'] == '1' ? ($is_enable = true) : ($is_enable = false);
    }
    
    if (!is_null($appoinment_hours) && !is_null($appoinment)) {
        $appoinment['is_enabled'] == '1' ? ($is_enable_appoinment = true) : ($is_enable_appoinment = false);
    }
    
    if (!is_null($services_content) && !is_null($services)) {
        $services['is_enabled'] == '1' ? ($is_enable_service = true) : ($is_enable_service = false);
    }
    if (!is_null($products_content) && !is_null($products)) {
        $products['is_enabled'] == '1' ? ($is_enable_product = true) : ($is_enable_product = false);
    }
    if (!is_null($testimonials_content) && !is_null($testimonials)) {
        $testimonials['is_enabled'] == '1' ? ($is_enable_testimonials = true) : ($is_enable_testimonials = false);
    }
    
    if (!is_null($social_content) && !is_null($sociallinks)) {
        $sociallinks['is_enabled'] == '1' ? ($is_enable_sociallinks = true) : ($is_enable_sociallinks = false);
    }
    
    if (!is_null($custom_html) && !is_null($customhtml)) {
        $customhtml->is_custom_html_enabled == '1' ? ($is_custom_html_enable = true) : ($is_custom_html_enable = false);
    }
    
    if (!is_null($gallery_contents) && !is_null($gallery)) {
        $gallery['is_enabled'] == '1' ? ($is_enable_gallery = true) : ($is_enable_gallery = false);
    }
    
    if (!is_null($business->is_branding_enabled) && !is_null($business->is_branding_enabled)) {
        !empty($business->is_branding_enabled) && $business->is_branding_enabled == 'on' ? ($is_branding_enabled = true) : ($is_branding_enabled = false);
    } else {
        $is_branding_enabled = false;
    }
    if (!is_null($business->is_gdpr_enabled) && !is_null($business->is_gdpr_enabled)) {
        !empty($business->is_gdpr_enabled) && $business->is_gdpr_enabled == 'on' ? ($is_gdpr_enabled = true) : ($is_gdpr_enabled = false);
    }
    
    $color = substr($business->theme_color, 0, 6);
    $SITE_RTL = Cookie::get('SITE_RTL');
    if ($SITE_RTL == '') {
        $SITE_RTL = 'off';
    }
    $SITE_RTL = Utility::settings()['SITE_RTL'];
    
    $url_link = env('APP_URL') . '/' . $business->slug;
    $meta_tag_image = $meta_image . '/' . $business->meta_image;
    
    // Cookie
    $cookie_data = App\Models\Business::card_cookie($business->slug);
    $a = $cookie_data;
    
@endphp
<!DOCTYPE html>
<html dir="{{ $SITE_RTL == 'on' ? 'rtl' : '' }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="{{ $business->title }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <title>{{ $business->title }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="HandheldFriendly" content="True">

    {{-- Meta tag Preview --}}
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $url_link }}">
    <meta property="og:title" content="{{ $business->title }}">
    <meta property="og:description" content="{{ $business->meta_description }}">
    <meta property="og:image"
        content="{{ !empty($business->meta_image) ? $meta_tag_image : asset('custom/img/placeholder-image.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $url_link }}">
    <meta property="twitter:title" content="{{ $business->title }}">
    <meta property="twitter:description" content="{{ $business->meta_description }}">
    <meta property="twitter:image"
        content="{{ !empty($business->meta_image) ? $meta_tag_image : asset('custom/img/placeholder-image.jpg') }}">

    {{-- End Meta tag Preview --}}


    <link rel="icon"
        href="{{ $logo1 . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png') }}"
        type="image" sizes="16x16">
    <link rel="stylesheet" href="{{ asset('custom/theme13/libs/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/theme13/fonts/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/css/emojionearea.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}" />
    @if (isset($is_slug))
        <link rel="stylesheet" href="{{ asset('custom/theme13/modal/bootstrap.min.css') }}">
    @endif

    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('custom/theme13/css/rtl-main-style.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('custom/theme13/css/main-style.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('custom/theme13/css/responsive.css') }}">


    @if ($business->google_fonts != 'Default' && isset($business->google_fonts))
        <style>
            @import url('{{ \App\Models\Utility::getvalueoffont($business->google_fonts)['link'] }}');

            :root .theme13-v1 {
                --Strawford: '{{ strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') }}', {{ substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1) }};
            }

            :root .theme13-v2 {
                --Strawford: '{{ strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') }}', {{ substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1) }};
            }

            :root .theme13-v3 {
                --Strawford: '{{ strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') }}', {{ substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1) }};
            }

            :root .theme13-v4 {
                --Strawford: '{{ strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') }}', {{ substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1) }};
            }

            :root .theme13-v5 {
                --Strawford: '{{ strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') }}', {{ substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1) }};
            }
        </style>
    @endif

    @if (isset($is_slug))
        <link rel='stylesheet' href='{{ asset('css/cookieconsent.css') }}' media="screen" />
        <style type="text/css">
            {{ $business->customcss }}
        </style>
    @endif


    {{-- pwa customer app --}}
    <meta name="mobile-wep-app-capable" content="yes">
    <meta name="apple-mobile-wep-app-capable" content="yes">
    <meta name="msapplication-starturl" content="/">
    <link rel="apple-touch-icon"
        href="{{ asset(Storage::url('uploads/logo/') . (!empty($setting->value) ? $setting->value : 'favicon.png')) }}" />

    @if ($business->enable_pwa_business == 'on' && $plan->pwa_business == 'on')
        <link rel="manifest"
            href="{{ asset('storage/uploads/theme_app/business_' . $business->id . '/manifest.json') }}" />
    @endif
    @if (!empty($business->pwa_business($business->slug)->theme_color))
        <meta name="theme-color" content="{{ $business->pwa_business($business->slug)->theme_color }}" />
    @endif
    @if (!empty($business->pwa_business($business->slug)->background_color))
        <meta name="apple-mobile-web-app-status-bar"
            content="{{ $business->pwa_business($business->slug)->background_color }}" />
    @endif

    @foreach ($pixelScript as $script)
        <?= $script ?>
    @endforeach
</head>

<body class="tech-card-body">
    <!--wrapper start here-->
    <div id="boxes">
        <div id="view_css"
            class="{{ \App\Models\Utility::themeOne()['theme13'][$business->theme_color]['theme_name'] }}">
            <div class="home-wrapper">
                <section class="home-banner-section">
                    <img src="{{ isset($business->banner) && !empty($business->banner) ? $banner . '/' . $business->banner : asset('custom/img/placeholder-image.jpg') }}"
                        id="banner_preview" class="home-banner" alt="image">
                </section>
                <section class="client-info-section">
                    <div class="container">
                        <div class="client-intro">
                            <div class="client-image">
                                <img src="{{ isset($business->logo) && !empty($business->logo) ? $logo . '/' . $business->logo : asset('custom/img/logo-placeholder-image-2.png') }}"
                                    id="business_logo_preview" alt="image">
                            </div>
                            <div class="client-brief-intro">
                                <h3 id="{{ $stringid . '_title' }}_preview">{{ $business->title }}</h3>
                                <h6 id="{{ $stringid . '_designation' }}_preview">{{ $business->designation }}</h6>
                                <span id="{{ $stringid . '_subtitle' }}_preview">{{ $business->sub_title }}</span>

                            </div>
                        </div>
                    </div>
                </section>
                @php $j = 1; @endphp
                @foreach ($card_theme->order as $order_key => $order_value)
                    @if ($j == $order_value)

                        @if ($order_key == 'description')
                            <div class="container">
                                <div class="client-intro">
                                    <div class="client-brief-intro">
                                        <p id="{{ $stringid . '_desc' }}_preview">
                                            {{ $business->description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($order_key == 'contact_info')
                            <div class="container" id="contact-div">
                                <div class="client-contact" id="inputrow_contact_preview">

                                    @if (!is_null($contactinfo_content) && !is_null($contactinfo))
                                        @foreach ($contactinfo_content as $key => $val)
                                            @foreach ($val as $key1 => $val1)
                                                @if ($key1 == 'Phone')
                                                    @php $href = 'tel:'.$val1; @endphp
                                                @elseif($key1 == 'Email')
                                                    @php $href = 'mailto:'.$val1; @endphp
                                                @elseif($key1 == 'Address')
                                                    @php $href = ''; @endphp
                                                @else
                                                    @php $href = $val1 @endphp
                                                @endif
                                                @if ($key1 != 'id')
                                                    <div class="calllink contactlink "
                                                        id="contact_{{ $loop->parent->index + 1 }}">
                                                        @if ($key1 == 'Address')
                                                            @foreach ($val1 as $key2 => $val2)
                                                                @if ($key2 == 'Address_url')
                                                                    @php $href = $val2; @endphp
                                                                @endif
                                                            @endforeach
                                                            <a href="{{ $href }}" target="_blank">
                                                                <img src="{{ asset('custom/theme13/icon/' . $color . '/contact/' . strtolower($key1) . '.svg') }}"
                                                                    alt="{{ $key1 }}" class="img-fluid">
                                                                @foreach ($val1 as $key2 => $val2)
                                                                    @if ($key2 == 'Address')
                                                                        <span
                                                                            id="{{ $key1 . '_' . $no }}_preview">{{ $val2 }}</span>
                                                                    @endif
                                                                @endforeach

                                                            </a>
                                                        @else
                                                            @if ($key1 == 'Whatsapp')
                                                                <a href="{{ url('https://wa.me/' . $href) }}"
                                                                    target="_blank">
                                                                    <img src="{{ asset('custom/theme13/icon/' . $color . '/contact/' . strtolower($key1) . '.svg') }}"
                                                                        alt="{{ $key1 }}" class="img-fluid">
                                                                @else
                                                                    <a href="{{ $href }}">
                                                                        <img src="{{ asset('custom/theme13/icon/' . $color . '/contact/' . strtolower($key1) . '.svg') }}"
                                                                            alt="{{ $key1 }}"
                                                                            class="img-fluid">
                                                            @endif
                                                            <span
                                                                id="{{ $key1 . '_' . $no }}_preview">{{ $val1 }}</span>
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endif
                                                @php
                                                    $no++;
                                                @endphp
                                            @endforeach
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        @endif

                        @if ($order_key == 'bussiness_hour')
                            <section id="business-hours-div" class="business-hour-section common-border padding-top">
                                <div class="container">
                                    <div class="section-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            viewBox="0 0 30 30" fill="none">
                                            <circle class="theme-svg" cx="15" cy="15" r="15"
                                                fill="url(#paint0_linear)" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M14.804 6.17676C15.6703 6.17676 16.3726 6.84209 16.3726 7.66283V14.4776L19.8347 17.7575C20.4473 18.3379 20.4473 19.2788 19.8347 19.8591C19.2221 20.4395 18.2289 20.4395 17.6164 19.8591L13.6948 16.144C13.4006 15.8653 13.2354 15.4873 13.2354 15.0932V7.66283C13.2354 6.84209 13.9376 6.17676 14.804 6.17676Z"
                                                fill="white" />
                                            <defs>
                                                <linearGradient id="paint0_linear" x1="15" y1="0"
                                                    x2="15" y2="30" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#ADE8F4" />
                                                    <stop offset="1" stop-color="#46B7CE" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                        <h2>{{ __('Business Hours') }}</h2>
                                    </div>
                                    <div class="daily-hours-content">
                                        <div class="daily-hours-inner">
                                            <ul class="pl-1">
                                                @foreach ($days as $k => $day)
                                                    <li>
                                                        <p>{{ __($day) }}:<span
                                                                class="days_{{ $k }}">
                                                                @if (isset($business_hours->$k) && $business_hours->$k->days == 'on')
                                                                    <span
                                                                        class="days_{{ $k }}_start">{{ !empty($business_hours->$k->start_time) && isset($business_hours->$k->start_time) ? date('h:i A', strtotime($business_hours->$k->start_time)) : '00:00' }}</span>
                                                                    - <span
                                                                        class="days_{{ $k }}_end">{{ !empty($business_hours->$k->end_time) && isset($business_hours->$k->end_time) ? date('h:i A', strtotime($business_hours->$k->end_time)) : '00:00' }}</span>
                                                                @else
                                                                    {{ __('Closed') }}
                                                                @endif
                                                            </span></p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </section>
                        @endif
                        @if ($order_key == 'appointment')
                            <section id="appointment-div" class="appointment-section common-border padding-top">
                                <div class="container">
                                    <div class="section-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                            viewBox="0 0 28 28" fill="none">
                                            <path class="theme-svg" fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.6 1.4C5.6 0.626802 6.2268 0 7 0C7.7732 0 8.4 0.626801 8.4 1.4V2.8H19.6V1.4C19.6 0.626802 20.2268 0 21 0C21.7732 0 22.4 0.626801 22.4 1.4V2.8H23.8C26.1196 2.8 28 4.6804 28 7V23.8C28 26.1196 26.1196 28 23.8 28H4.2C1.8804 28 0 26.1196 0 23.8V7C0 4.6804 1.8804 2.8 4.2 2.8H5.6V1.4Z"
                                                fill="url(#paint0_linear)" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M11.3333 14C10.597 14 10 14.597 10 15.3333C10 16.0697 10.597 16.6667 11.3333 16.6667H20.6667C21.403 16.6667 22 16.0697 22 15.3333C22 14.597 21.403 14 20.6667 14H11.3333ZM7.33333 19.3333C6.59695 19.3333 6 19.9303 6 20.6667C6 21.403 6.59695 22 7.33333 22H15.3333C16.0697 22 16.6667 21.403 16.6667 20.6667C16.6667 19.9303 16.0697 19.3333 15.3333 19.3333H7.33333Z"
                                                fill="white" />
                                            <defs>
                                                <linearGradient id="paint0_linear" x1="14" y1="0"
                                                    x2="14" y2="28" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#ADE8F4" />
                                                    <stop offset="1" stop-color="#46B7CE" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                        <h2><b>{{ __('Make an') }}</b> {{ __('appointment') }}</h2>
                                    </div>
                                    <div class="appointment-date">
                                        <div class="date-label">
                                            {{ __('Date') }}
                                        </div>
                                        <input type="text" name="date" class="text-center datepicker_min"
                                            placeholder="{{ __('Pick a Date') }}">
                                    </div>
                                    <div class="text-center pl-3 mt-0 mb-3">
                                        <span class="text-danger text-center span-error-date"
                                            style="margin-left: 78px;"></span>
                                    </div>
                                    <div class="appointment-hour">
                                        <div class="hour-label">
                                            {{ __('Hour') }}
                                        </div>
                                        <div class="text-radio" id="inputrow_appointment_preview">
                                            @php $radiocount = 1; @endphp
                                            @if (!is_null($appoinment_hours))
                                                @foreach ($appoinment_hours as $k => $hour)
                                                    <div class="radio {{ $radiocount % 2 == 0 ? 'radio-left' : '' }}"
                                                        id="{{ 'appointment_' . $appointment_no }}">
                                                        <input id="radio-{{ $radiocount }}" name="time"
                                                            type="radio"
                                                            data-id="@if (!empty($hour->start)) {{ $hour->start }} @else 00:00 @endif-@if (!empty($hour->end)) {{ $hour->end }} @else 00:00 @endif"
                                                            class="app_time">
                                                        <label for="radio-{{ $radiocount }}"
                                                            class="radio-label"><span
                                                                id="appoinment_start_{{ $appointment_no }}_preview">
                                                                @if (!empty($hour->start))
                                                                    {{ $hour->start }}
                                                                @else
                                                                    00:00
                                                                @endif
                                                            </span> - <span
                                                                id="appoinment_end_{{ $appointment_no }}_preview">
                                                                @if (!empty($hour->end))
                                                                    {{ $hour->end }}
                                                                @else
                                                                    00:00
                                                                @endif
                                                            </span></label>
                                                    </div>
                                                    @php
                                                        $radiocount++;
                                                        $appointment_no++;
                                                    @endphp
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="text-center mt-0 mb-3 col-12">
                                            <span class="text-danger text-center span-error-time"></span>
                                        </div>
                                        <div class="appointment-btn">
                                            <a href="javascript:;" data-toggle="modal"
                                                data-target="#appointment-modal" class="btn" tabindex="0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M4 1C4 0.447715 4.44772 0 5 0C5.55228 0 6 0.447715 6 1V2H14V1C14 0.447715 14.4477 0 15 0C15.5523 0 16 0.447715 16 1V2H17C18.6569 2 20 3.34315 20 5V17C20 18.6569 18.6569 20 17 20H3C1.34315 20 0 18.6569 0 17V5C0 3.34315 1.34315 2 3 2H4V1Z"
                                                        fill="#252429" />
                                                    <path class="theme-svg" fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M8 10C7.44772 10 7 10.4477 7 11C7 11.5523 7.44772 12 8 12H15C15.5523 12 16 11.5523 16 11C16 10.4477 15.5523 10 15 10H8ZM5 14C4.44772 14 4 14.4477 4 15C4 15.5523 4.44772 16 5 16H11C11.5523 16 12 15.5523 12 15C12 14.4477 11.5523 14 11 14H5Z"
                                                        fill="#ADE8F4" />
                                                </svg>
                                                {{ __('Make an appointment') }}
                                            </a>
                                        </div>
                                    </div>
                            </section>
                        @endif
                        @if ($order_key == 'service')
                            <section id="services-div" class="service-section common-border padding-top">
                                <div class="container">
                                    <div class="section-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27"
                                            viewBox="0 0 27 27" fill="none">
                                            <path class="theme-svg"
                                                d="M25.7076 23.371L23.1825 25.8961C23.1825 25.8961 16.6212 28.7081 7.24793 19.3348C-2.12534 9.96157 0.686638 3.40028 0.686638 3.40028L3.21178 0.875134C4.3526 -0.265686 6.23935 -0.131596 7.20737 1.15909L9.61764 4.37279C10.4092 5.42827 10.3043 6.90522 9.37136 7.83814L7.24793 9.96157C7.24793 9.96157 7.24793 11.8362 10.9972 15.5855C14.7466 19.3348 16.6212 19.3348 16.6212 19.3348L18.7446 17.2114C19.6776 16.2785 21.1545 16.1735 22.21 16.9651L25.4237 19.3754C26.7144 20.3434 26.8485 22.2302 25.7076 23.371Z"
                                                fill="url(#paint0_linear)" />
                                            <defs>
                                                <linearGradient id="paint0_linear" x1="0.543393" y1="3.54352"
                                                    x2="23.0393" y2="26.0394" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#ADE8F4" />
                                                    <stop offset="1" stop-color="#46B7CE" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                        <h2>{{ __('Services') }}</h2>
                                    </div>
                                    <div class="service-card-wrapper" id="inputrow_service_preview">
                                        @php $image_count = 0; @endphp
                                        @foreach ($services_content as $k1 => $content)
                                            <div class="service-card" id="services_{{ $service_row_no }}">
                                                <div class="service-card-inner">
                                                    <div class="service-icon testimonials_image">
                                                        <img id="{{ 's_image' . $image_count . '_preview' }}"
                                                            src="{{ isset($content->image) && !empty($content->image) ? $s_image . '/' . $content->image : asset('custom/img/logo-placeholder-image-21.png') }}"
                                                            alt="image">
                                                    </div>
                                                    <h5 id="{{ 'title_' . $service_row_no . '_preview' }}">
                                                        {{ $content->title }}</h5>
                                                    <p id="{{ 'description_' . $service_row_no . '_preview' }}">
                                                        {{ $content->description }}
                                                    </p>
                                                    @if (!empty($content->purchase_link))
                                                        <a href="{{ url($content->purchase_link) }}"
                                                            class="read-more-btn"
                                                            id="{{ 'link_title_' . $service_row_no . '_preview' }}">
                                                            {{ $content->link_title }}
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="4"
                                                                height="6" viewBox="0 0 4 6" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M0.65976 0.662719C0.446746 0.879677 0.446746 1.23143 0.65976 1.44839L2.18316 3L0.65976 4.55161C0.446747 4.76856 0.446747 5.12032 0.65976 5.33728C0.872773 5.55424 1.21814 5.55424 1.43115 5.33728L3.34024 3.39284C3.55325 3.17588 3.55325 2.82412 3.34024 2.60716L1.43115 0.662719C1.21814 0.445761 0.872773 0.445761 0.65976 0.662719Z"
                                                                    fill="white"></path>
                                                            </svg>
                                                        </a>
                                                    @endif

                                                </div>
                                            </div>
                                            @php
                                                $image_count++;
                                                $service_row_no++;
                                            @endphp
                                        @endforeach

                                    </div>
                                </div>
                            </section>
                        @endif
                        @if ($order_key == 'product')
                                <section class="product-section common-border padding-top" id="product-div">
                                    <div class="container">
                                    
                                    <div class="section-title text-center">
                                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                            width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000"
                                            preserveAspectRatio="xMidYMid meet">

                                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path class="theme-svg" d="M3251 4833 c-44 -18 -1090 -628 -1111 -649 l-25 -24 0 -655 0 -655
                                            25 -24 c14 -13 268 -164 565 -336 494 -285 543 -311 580 -308 31 2 159 72 575
                                            312 294 169 545 319 558 333 l22 24 0 654 0 654 -22 25 c-25 27 -364 226 -387
                                            226 -7 0 -271 -149 -587 -331 l-574 -332 0 -218 c0 -120 -4 -229 -9 -242 -19
                                            -49 -43 -44 -189 40 l-137 79 0 269 0 269 115 66 c592 341 1026 593 1032 598
                                            7 7 -301 190 -365 217 -39 16 -44 17 -66 8z" fill="white" />
                                            <path class="theme-svg" d="M1715 2247 c-38 -13 -92 -35 -120 -49 -60 -31 -657 -377 -667 -386
                                            -6 -6 434 -797 455 -818 3 -4 22 3 42 15 20 11 50 21 66 21 17 0 306 -74 642
                                            -164 337 -90 636 -169 665 -175 104 -22 205 -9 318 40 80 35 1756 1068 1791
                                            1104 96 100 56 282 -73 331 -82 31 -228 3 -383 -75 -35 -18 -279 -158 -543
                                            -312 -537 -313 -550 -320 -633 -345 -73 -22 -250 -23 -370 -1 -140 25 -699
                                            177 -717 195 -46 47 -12 132 52 132 16 0 116 -25 222 -55 407 -115 495 -127
                                            567 -76 67 48 89 148 50 229 -31 62 -76 87 -209 117 -153 34 -304 79 -550 166
                                            -312 109 -356 121 -450 125 -70 4 -98 0 -155 -19z" fill="white"  />
                                            <path class="theme-svg" d="M510 2000 c-14 -4 -88 -43 -165 -87 -161 -92 -190 -122 -182 -189 6
                                            -58 756 -1385 800 -1416 57 -41 97 -31 263 63 160 90 194 123 194 186 0 19 -9
                                            51 -19 72 -57 112 -746 1319 -764 1339 -11 12 -37 26 -56 32 -40 11 -37 11
                                            -71 0z m55 -285 c50 -49 24 -133 -46 -150 -62 -15 -123 57 -100 118 22 58 103
                                            76 146 32z"  fill="white"/>
                                            </g>
                                            </svg>
                                        <h2>{{ __('Product') }}</h2>
                                    </div>
                                    <div class="service-card-wrapper" id="inputrow_product_preview">
                                        @php $pr_image_count = 0; @endphp
                                        @foreach ($products_content as $k1 => $content)
                                            <div class=" service-card"
                                                id="product_{{ $product_row_no }}">
                                                <div class="service-card-inner">
                                                    <div class="service-icon">
                                                        <img id="{{ 'pr_image' . $pr_image_count . '_preview' }}"
                                                            src="{{ isset($content->image) && !empty($content->image) ? $pr_image . '/' . $content->image : asset('custom/img/logo-placeholder-image-21.png') }}"class="img-fluid"
                                                            alt="image">
                                                    </div>
                                                    <h5 id="{{ 'product_title_' . $product_row_no . '_preview' }}">
                                                        {{ $content->title }}</h5>
                                                    <p id="{{ 'product_description_' . $product_row_no . '_preview' }}">
                                                        {{ $content->description }}
                                                    </p>
                                                    <div class="product-currency" >
                                                        <span id="{{ 'product_currency_select' . $product_row_no . '_preview' }}">{{$content->currency}}</span>
                                                        <span id="{{ 'product_price_' . $product_row_no . '_preview' }}">{{$content->price }}</span>
                                                    </div>
                                                    
                                                    @if (!empty($content->purchase_link))
                                                        <a href="{{ url($content->purchase_link) }}"
                                                            id="{{ 'product_link_title_' . $product_row_no . '_preview' }}"
                                                            class="read-more-btn">{{ $content->link_title }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                            @php
                                                $pr_image_count++;
                                                $product_row_no++;
                                            @endphp
                                        @endforeach
                                    </div>
                                </div>
                                </section>
                        @endif
                        @if ($order_key == 'gallery')
                            <section class="gallery-section common-border padding-top" id="gallery-div">
                                <div class="container">
                                    <div class="section-title">
                                        <div class="title-svg">
                                            <img src="{{ asset('custom/theme13/icon/' . $color . '/gallery.svg') }}"
                                                alt="phone" class="img-fluid">
                                        </div>
                                        <h2>{{ __('Gallery') }}</h2>
                                    </div>
                                    <div class="gallery-card-wrapper" id="inputrow_gallery_preview">
                                        @php $image_count = 0; @endphp
                                        @if (isset($is_pdf))
                                            <div class="row gallery-cards">
                                                @if (!is_null($gallery_contents) && !is_null($gallery))
                                                    @foreach ($gallery_contents as $key => $gallery_content)
                                                        <div class="col-md-6 col-12 p-0 gallery-card-pdf"
                                                            id="gallery_{{ $gallery_row_no }}">
                                                            <div class="gallery-card-inner-pdf">
                                                                <div class="gallery-icon-pdf">
                                                                    @if (isset($gallery_content->type))
                                                                        @if ($gallery_content->type == 'video')
                                                                            <a href="javascript:;" id=""
                                                                                tabindex="0" class="videopop">
                                                                                <video height="" controls>
                                                                                    <source class="videoresource"
                                                                                        src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_path . '/' . $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                        type="video/mp4">
                                                                                </video>
                                                                            </a>
                                                                        @elseif($gallery_content->type == 'image')
                                                                            <a href="javascript:;" id="imagepopup"
                                                                                tabindex="0" class="imagepopup">
                                                                                <img src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_path . '/' . $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                    alt="images"
                                                                                    class="imageresource">
                                                                            </a>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $image_count++;
                                                            $gallery_row_no++;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </div>
                                        @else
                                            <div class="gallery-slider">
                                                @if (!is_null($gallery_contents) && !is_null($gallery))
                                                    @foreach ($gallery_contents as $key => $gallery_content)
                                                        <div class="gallery-card"
                                                            id="gallery_{{ $gallery_row_no }}">
                                                            <div class="gallery-card-inner">
                                                                <div class="gallery-icon">
                                                                    @if (isset($gallery_content->type))
                                                                        @if ($gallery_content->type == 'video')
                                                                            <a href="javascript:;" id=""
                                                                                tabindex="0" class="videopop">
                                                                                <video loop controls="true">
                                                                                    <source class="videoresource"
                                                                                        src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_path . '/' . $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                        type="video/mp4">
                                                                                </video>
                                                                            </a>
                                                                        @elseif($gallery_content->type == 'image')
                                                                            <a href="javascript:;" id="imagepopup"
                                                                                tabindex="0" class="imagepopup">
                                                                                <img src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_path . '/' . $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                    alt="images"
                                                                                    class="imageresource">
                                                                            </a>
                                                                        @elseif($gallery_content->type == 'custom_video_link')
                                                                            @if (str_contains($gallery_content->value, 'youtube') || str_contains($gallery_content->value, 'youtu.be'))
                                                                                @php
                                                                                    if (strpos($gallery_content->value, 'src') !== false) {
                                                                                        preg_match('/src="([^"]+)"/', $gallery_content->value, $match);
                                                                                        $url = $match[1];
                                                                                        $video_url = str_replace('https://www.youtube.com/embed/', '', $url);
                                                                                    } elseif (strpos($gallery_content->value, 'src') == false && strpos($gallery_content->value, 'embed') !== false) {
                                                                                        $video_url = str_replace('https://www.youtube.com/embed/', '', $gallery_content->value);
                                                                                    } else {
                                                                                        $video_url = str_replace('https://youtu.be/', '', str_replace('https://www.youtube.com/watch?v=', '', $gallery_content->value));
                                                                                        preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $gallery_content->value, $matches);
                                                                                        if (count($matches) > 0) {
                                                                                            $videoId = $matches[1];
                                                                                            $video_url = strtok($videoId, '&');
                                                                                        }
                                                                                    }
                                                                                @endphp
                                                                                <a href="javascript:;" id=""
                                                                                    tabindex="0" class="videopop1">
                                                                                    <video loop controls="true" poster="{{ asset('custom/img/video_youtube.jpg') }}">
                                                                                        <source class="videoresource1"
                                                                                            src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? 'https://www.youtube.com/embed/' . $video_url : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                            type="video/mp4">
                                                                                    </video>
                                                                                </a>
                                                                            @else
                                                                                <a href="javascript:;" id=""
                                                                                    tabindex="0" class="videopop1">
                                                                                    <video loop controls="true" poster="{{ asset('custom/img/video_youtube.jpg') }}">
                                                                                        <source class="videoresource1"
                                                                                            src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                            type="video/mp4">
                                                                                    </video>
                                                                                </a>
                                                                            @endif
                                                                        @elseif($gallery_content->type == 'custom_image_link')
                                                                            <a href="javascript:;" id=""
                                                                                target="" tabindex="0"
                                                                                class="imagepopup1">
                                                                                <img class="imageresource1"
                                                                                    src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? $gallery_content->value : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                    alt="images" id="upload_image">
                                                                            </a>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $image_count++;
                                                            $gallery_row_no++;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </section>
                        @endif
                        @if ($order_key == 'more')
                            <section class="more-card-section common-border padding-top">
                                <div class="container">
                                    <div class="section-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="23"
                                            viewBox="0 0 18 23" fill="none">
                                            <path class="theme-svg" fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.81113 0.149214C1.7967 0.278601 0.297397 1.8001 0.177942 3.81514C0.0810958 5.44881 2.0758e-05 7.77846 3.98409e-09 11C-3.23723e-05 16.0256 0.197269 19.4726 0.343988 21.3412C0.403096 22.0939 1.24523 22.4739 1.8621 22.0385L8.42326 17.4071C8.76899 17.163 9.2309 17.163 9.57662 17.4071L16.1378 22.0385C16.7547 22.4739 17.5968 22.0939 17.6559 21.3412C17.8026 19.4726 17.9999 16.0256 17.9999 11C17.9999 7.77836 17.9189 5.44867 17.822 3.81499C17.7025 1.80002 16.2033 0.278611 14.1889 0.149223C12.8866 0.0655718 11.1728 0 8.99994 0C6.8272 0 5.11343 0.0655667 3.81113 0.149214Z"
                                                fill="url(#paint0_linear)" />
                                            <path class="theme-svg" fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.64391 0.149214C1.62948 0.278601 0.130174 1.8001 0.010719 3.81514C0.007123 3.8758 0.003549 3.93741 0 4C1.83277 4 15.8328 4 17.6655 4C17.6619 3.93736 17.6584 3.8757 17.6548 3.81499C17.5353 1.80002 16.036 0.278611 14.0217 0.149223C12.7194 0.0655718 11.0055 0 8.83272 0C6.65998 0 4.94621 0.0655667 3.64391 0.149214Z"
                                                fill="#ADE8F4" />
                                            <defs>
                                                <linearGradient id="paint0_linear" x1="8.99997" y1="0"
                                                    x2="8.99997" y2="22.2224" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#ADE8F4" />
                                                    <stop offset="1" stop-color="#46B7CE" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                        <h2>{{ __('More') }}</h2>
                                    </div>
                                    <div class="more-btn">
                                        <a href="javascript:;" class="btn" tabindex="0"
                                            onclick="location.href = '{{ route('bussiness.save', $business->slug) }}'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.25"
                                                    d="M13 6L12.4104 5.01732C11.8306 4.05094 10.8702 3.36835 9.75227 3.22585C8.83875 3.10939 7.66937 3 6.5 3C5.68392 3 4.86784 3.05328 4.13873 3.12505C2.53169 3.28325 1.31947 4.53621 1.19597 6.14628C1.09136 7.51009 1 9.43529 1 12C1 13.8205 1.06629 15.4422 1.15059 16.7685C1.29156 18.9862 3.01613 20.6935 5.23467 20.8214C6.91963 20.9185 9.17474 21 12 21C14.8253 21 17.0804 20.9185 18.7653 20.8214C20.9839 20.6935 22.7084 18.9862 22.8494 16.7685C22.9337 15.4422 23 13.8205 23 12C23 10.9589 22.9398 9.97795 22.8611 9.14085C22.7101 7.53313 21.4669 6.2899 19.8591 6.13886C19.0221 6.06022 18.0411 6 17 6H13Z"
                                                    fill="#12131A" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M13 6H1.21033C1.39381 4.46081 2.58074 3.27842 4.13877 3.12505C4.86788 3.05328 5.68396 3 6.50004 3C7.66941 3 8.83879 3.10939 9.75231 3.22585C10.8702 3.36835 11.8306 4.05094 12.4104 5.01732L13 6Z"
                                                    fill="#12131A" />
                                            </svg>
                                            {{ __('Save Card') }}
                                        </a>
                                        <a href="javascript:;" class="btn our-card" tabindex="0">
                                            <svg class="rtl-svg" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.25"
                                                    d="M10.8591 2.1389C12.4669 2.2899 13.6733 3.5372 13.7908 5.1477C13.9008 6.6568 14 8.882 14 12C14 15.118 13.9008 17.3432 13.7908 18.8523C13.6733 20.4628 12.4669 21.7101 10.8592 21.8611C10.0221 21.9398 9.0411 22 8 22C6.9589 22 5.9779 21.9398 5.1408 21.8611C3.5331 21.7101 2.3267 20.4628 2.2092 18.8523C2.0992 17.3432 2 15.118 2 12C2 8.882 2.0992 6.6568 2.2092 5.1477C2.3267 3.5372 3.5331 2.2899 5.1409 2.1389C5.9779 2.0602 6.9589 2 8 2C9.0411 2 10.0221 2.0602 10.8591 2.1389Z"
                                                    fill="#12131A" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M16.7929 9.2071C16.4024 8.8166 16.4024 8.1834 16.7929 7.7929C17.1834 7.4024 17.8166 7.4024 18.2071 7.7929L21.7071 11.2929C22.0976 11.6834 22.0976 12.3166 21.7071 12.7071L18.2071 16.2071C17.8166 16.5976 17.1834 16.5976 16.7929 16.2071C16.4024 15.8166 16.4024 15.1834 16.7929 14.7929L18.5858 13L9 13C8.4477 13 8 12.5523 8 12C8 11.4477 8.4477 11 9 11L18.5858 11L16.7929 9.2071Z"
                                                    fill="#12131A" />
                                            </svg>
                                            {{ __('Share Card') }}
                                        </a>
                                        <a href="javascript:;" data-toggle="modal" data-target="#mycontactModal"
                                            class="btn our-contact" tabindex="0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.25"
                                                    d="M22.411 18.3856L20.5061 20.2905C20.5061 20.2905 15.5564 22.4118 8.48528 15.3408C1.41421 8.26968 3.53553 3.31993 3.53553 3.31993L5.44047 1.415C6.30108 0.554384 7.72442 0.65554 8.45468 1.62922L10.273 4.05358C10.8701 4.84982 10.791 5.96401 10.0872 6.6678L8.48528 8.26968C8.48528 8.26968 8.48528 9.6839 11.3137 12.5123C14.1421 15.3408 15.5563 15.3407 15.5563 15.3407L17.1582 13.7389C17.862 13.0351 18.9762 12.9559 19.7725 13.5531L22.1968 15.3714C23.1705 16.1016 23.2716 17.5249 22.411 18.3856Z"
                                                    fill="#12131A" />
                                                <path
                                                    d="M5.44046 1.41493L4.94974 1.90565L9.19238 7.5625L10.0872 6.66772C10.7909 5.96394 10.8701 4.84975 10.2729 4.05351L8.45467 1.62914C7.72441 0.655462 6.30108 0.554309 5.44046 1.41493Z"
                                                    fill="#12131A" />
                                                <path
                                                    d="M22.4112 18.3847L21.9205 18.8755L16.2637 14.6328L17.1585 13.738C17.8622 13.0342 18.9764 12.9551 19.7727 13.5522L22.197 15.3705C23.1707 16.1008 23.2719 17.5241 22.4112 18.3847Z"
                                                    fill="#12131A" />
                                            </svg>
                                            {{ __('Contact') }}
                                        </a>
                                    </div>
                                </div>
                            </section>
                        @endif
                        @if ($order_key == 'testimonials')
                            <section id="testimonials-div" class="testimonials-section common-border padding-top">
                                <div class="container">
                                    <div class="section-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="23"
                                            viewBox="0 0 18 23" fill="none">
                                            <path class="theme-svg" fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.81113 0.149214C1.7967 0.278601 0.297397 1.8001 0.177942 3.81514C0.0810958 5.44881 2.0758e-05 7.77846 3.98409e-09 11C-3.23723e-05 16.0256 0.197269 19.4726 0.343988 21.3412C0.403096 22.0939 1.24523 22.4739 1.8621 22.0385L8.42326 17.4071C8.76899 17.163 9.2309 17.163 9.57662 17.4071L16.1378 22.0385C16.7547 22.4739 17.5968 22.0939 17.6559 21.3412C17.8026 19.4726 17.9999 16.0256 17.9999 11C17.9999 7.77836 17.9189 5.44867 17.822 3.81499C17.7025 1.80002 16.2033 0.278611 14.1889 0.149223C12.8866 0.0655718 11.1728 0 8.99994 0C6.8272 0 5.11343 0.0655667 3.81113 0.149214Z"
                                                fill="url(#paint0_linear)" />
                                            <path class="theme-svg" fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.64391 0.149214C1.62948 0.278601 0.130174 1.8001 0.010719 3.81514C0.007123 3.8758 0.003549 3.93741 0 4C1.83277 4 15.8328 4 17.6655 4C17.6619 3.93736 17.6584 3.8757 17.6548 3.81499C17.5353 1.80002 16.036 0.278611 14.0217 0.149223C12.7194 0.0655718 11.0055 0 8.83272 0C6.65998 0 4.94621 0.0655667 3.64391 0.149214Z"
                                                fill="#ADE8F4" />
                                            <defs>
                                                <linearGradient id="paint0_linear" x1="8.99997" y1="0"
                                                    x2="8.99997" y2="22.2224" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#ADE8F4" />
                                                    <stop offset="1" stop-color="#46B7CE" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                        <h2>{{ __('Testimonials') }}</h2>
                                    </div>
                                    @if (isset($is_pdf))
                                        <div class="row testimonial-pdf-row" id="inputrow_testimonials_preview">
                                            @php
                                                $t_image_count = 0;
                                                $rating = 0;
                                            @endphp
                                            @foreach ($testimonials_content as $k2 => $testi_content)
                                                <div class=" col-md-6 col-12 testimonial-itm-pdf"
                                                    id="testimonials_{{ $testimonials_row_no }}">
                                                    <div class="testimonial-itm-inner-pdf">
                                                        <div class="testi-client-img-pdf">
                                                            <img id="{{ 't_image' . $t_image_count . '_preview' }}"
                                                                src="{{ isset($testi_content->image) && !empty($testi_content->image) ? $image . '/' . $testi_content->image : asset('custom/img/placeholder-image12.jpg') }}"
                                                                alt="image">
                                                        </div>
                                                        <div class="testimonial-pdf-bdy">
                                                            <h5 class="rating-number">{{ $testi_content->rating }}/5
                                                            </h5>

                                                            <div class="rating-star">
                                                                @php
                                                                    if (!empty($testi_content->rating)) {
                                                                        $rating = (int) $testi_content->rating;
                                                                        $overallrating = $rating;
                                                                    } else {
                                                                        $overallrating = 0;
                                                                    }
                                                                @endphp
                                                                <span id="{{ 'stars' . $testimonials_row_no }}_star"
                                                                    class="star-section d-flex align-items-center justify-content-center">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        @if ($overallrating < $i)
                                                                            @if (is_float($overallrating) && round($overallrating) == $i)
                                                                                <i
                                                                                    class="star-color fas fa-star-half-alt"></i>
                                                                            @else
                                                                                <i class="fa fa-star"></i>
                                                                            @endif
                                                                        @else
                                                                            <i class="star-color fas fa-star"></i>
                                                                        @endif
                                                                    @endfor
                                                                </span>
                                                            </div>
                                                            <p
                                                                id="{{ 'testimonial_description_' . $testimonials_row_no . '_preview' }}">
                                                                {{ $testi_content->description }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php
                                                    $t_image_count++;
                                                    $testimonials_row_no++;
                                                @endphp
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="testimonial-slider" id="inputrow_testimonials_preview">
                                            @php
                                                $t_image_count = 0;
                                                $rating = 0;
                                            @endphp
                                            @foreach ($testimonials_content as $k2 => $testi_content)
                                                <div class="testimonial-itm"
                                                    id="testimonials_{{ $testimonials_row_no }}">
                                                    <div class="testimonial-itm-inner">
                                                        <div class="testi-client-img">
                                                            <img id="{{ 't_image' . $t_image_count . '_preview' }}"
                                                                src="{{ isset($testi_content->image) && !empty($testi_content->image) ? $image . '/' . $testi_content->image : asset('custom/img/placeholder-image12.jpg') }}"
                                                                class="img-fluid" alt="image">
                                                        </div>
                                                        <h5 class="rating-number"><span
                                                                class="{{ 'stars' . $testimonials_row_no }}">{{ $testi_content->rating }}</span>/5
                                                        </h5>
                                                        @php
                                                            if (!empty($testi_content->rating)) {
                                                                $rating = (int) $testi_content->rating;
                                                                $overallrating = $rating;
                                                            } else {
                                                                $overallrating = 0;
                                                            }
                                                        @endphp
                                                        <div id="{{ 'stars' . $testimonials_row_no }}_star"
                                                            class="rating-star star-section">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($overallrating < $i)
                                                                    @if (is_float($overallrating) && round($overallrating) == $i)
                                                                        <i class="star-color fas fa-star-half-alt"></i>
                                                                    @else
                                                                        <i class=" fa fa-star"></i>
                                                                    @endif
                                                                @else
                                                                    <i class="star-color fas fa-star"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <p
                                                            id="{{ 'testimonial_description_' . $testimonials_row_no . '_preview' }}">
                                                            {{ $testi_content->description }}
                                                        </p>
                                                    </div>
                                                </div>
                                                @php
                                                    $t_image_count++;
                                                    $testimonials_row_no++;
                                                @endphp
                                            @endforeach



                                        </div>
                                    @endif
                                </div>
                            </section>
                        @endif
                        @if ($order_key == 'social')
                            <section id="social-div" class="social-icons-section common-border padding-top">
                                <div class="container">
                                    <div class="section-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="20"
                                            viewBox="0 0 28 20" fill="none">
                                            <path class="theme-svg"
                                                d="M0 2.5C0 1.11929 1.13964 0 2.54545 0H5.09091C6.49672 0 7.63636 1.11929 7.63636 2.5V5C7.63636 6.38071 6.49672 7.5 5.09091 7.5H2.54545C1.13964 7.5 0 6.38071 0 5V2.5Z"
                                                fill="url(#paint0_linear)" />
                                            <path class="theme-svg"
                                                d="M0 15C0 13.6193 1.13964 12.5 2.54545 12.5H5.09091C6.49672 12.5 7.63636 13.6193 7.63636 15V17.5C7.63636 18.8807 6.49672 20 5.09091 20H2.54545C1.13964 20 0 18.8807 0 17.5V15Z"
                                                fill="url(#paint1_linear)" />
                                            <path class="theme-svg"
                                                d="M22.9091 6.25C21.5033 6.25 20.3636 7.36929 20.3636 8.75V11.25C20.3636 12.6307 21.5033 13.75 22.9091 13.75H25.4545C26.8604 13.75 28 12.6307 28 11.25V8.75C28 7.36929 26.8604 6.25 25.4545 6.25H22.9091Z"
                                                fill="url(#paint2_linear)" />
                                            <path class="theme-svg"
                                                d="M8 4.5H11.6C12.2627 4.5 12.8 5.05964 12.8 5.75V13.25C12.8 13.9404 12.2627 14.5 11.6 14.5H8V17H11.6C13.5882 17 15.2 15.3211 15.2 13.25V10.75H20V8.25H15.2V5.75C15.2 3.67893 13.5882 2 11.6 2H8V4.5Z"
                                                fill="url(#paint3_linear)" />
                                            <defs>
                                                <linearGradient id="paint0_linear" x1="14" y1="0"
                                                    x2="14" y2="20" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#ADE8F4" />
                                                    <stop offset="1" stop-color="#46B7CE" />
                                                </linearGradient>
                                                <linearGradient id="paint1_linear" x1="14" y1="0"
                                                    x2="14" y2="20" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#ADE8F4" />
                                                    <stop offset="1" stop-color="#46B7CE" />
                                                </linearGradient>
                                                <linearGradient id="paint2_linear" x1="14" y1="0"
                                                    x2="14" y2="20" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#ADE8F4" />
                                                    <stop offset="1" stop-color="#46B7CE" />
                                                </linearGradient>
                                                <linearGradient id="paint3_linear" x1="14" y1="2"
                                                    x2="14" y2="17" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#ADE8F4" />
                                                    <stop offset="1" stop-color="#46B7CE" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                        <h2>{{ __('Social') }}</h2>
                                    </div>
                                    <ul class="social-icon-wrapper" id="inputrow_socials_preview">
                                        @if (!is_null($social_content) && !is_null($sociallinks))
                                            @foreach ($social_content as $social_key => $social_val)
                                                @foreach ($social_val as $social_key1 => $social_val1)
                                                    @if ($social_key1 != 'id')
                                                        <li class="socials_{{ $loop->parent->index + 1 }} social-image-icon"
                                                            id="socials_{{ $loop->parent->index + 1 }}">
                                                            @if ($social_key1 == 'Whatsapp')
                                                                @if ((new \Jenssegers\Agent\Agent())->isDesktop())
                                                                    @php
                                                                        $social_links = url('https://web.whatsapp.com/send?phone=' . $social_val1);
                                                                    @endphp
                                                                @else
                                                                    @php
                                                                        $social_links = url('https://wa.me/' . $social_val1);
                                                                    @endphp
                                                                @endif
                                                            @else
                                                                @php
                                                                    $social_links = url($social_val1);
                                                                @endphp
                                                            @endif
                                                            <a href="{{ $social_links }}"
                                                                class="social_link_{{ $loop->parent->index + 1 }}_href_preview"
                                                                id="social_link_{{ $loop->parent->index + 1 }}_href_preview'}}"
                                                                target="_blank">

                                                                <img src="{{ asset('custom/theme13/icon/' . $color . '/social/' . strtolower($social_key1) . '.svg') }}"
                                                                    alt="{{ $social_key1 }}"
                                                                    class="img-fluid hover-hide">
                                                                <img src="{{ asset('custom/theme13/icon/' . $color . '/social_white/' . strtolower($social_key1) . '.svg') }}"
                                                                    alt="{{ $social_key1 }}"
                                                                    class="img-fluid hover-show">
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif



                                    </ul>
                                </div>
                            </section>
                        @endif
                        @if ($order_key == 'custom_html')
                            <div id="{{ $stringid . '_chtml' }}_preview" class="custom_html_text">
                                {!! stripslashes($custom_html) !!}
                            </div>
                        @endif
                        @php
                            
                            $j = $j + 1;
                        @endphp
                    @endif

                @endforeach
                @if ($plan->enable_branding == 'on')
                    @if ($is_branding_enabled)
                        <div id="is_branding_enabled" class="is_branding_enable copyright mt-3 pb-2">
                            <p id="{{ $stringid . '_branding' }}_preview" class="branding_text">
                                {{ $business->branding_text }}</p>
                        </div>
                    @endif
                @endif

            </div>
            <!--appointment popup start here-->
            <div class="appointment-popup">
                <div class="container">
                    <form class="appointment-form-wrapper">
                        <div class="section-title">
                            <h5>{{ __('Make Appointment') }}</h5>
                            <div class="close-search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 18 18" fill="none">
                                    <path
                                        d="M14.6 17.4L0.600001 3.4C-0.2 2.6 -0.2 1.4 0.600001 0.600001C1.4 -0.2 2.6 -0.2 3.4 0.600001L17.4 14.6C18.2 15.4 18.2 16.6 17.4 17.4C16.6 18.2 15.4 18.2 14.6 17.4V17.4Z"
                                        fill="#000" />
                                    <path
                                        d="M0.600001 14.6L14.6 0.600001C15.4 -0.2 16.6 -0.2 17.4 0.600001C18.2 1.4 18.2 2.6 17.4 3.4L3.4 17.4C2.6 18.2 1.4 18.2 0.600001 17.4C-0.2 16.6 -0.2 15.4 0.600001 14.6V14.6Z"
                                        fill="#000" />
                                </svg>
                            </div>
                        </div>
                        <div class="row appo-form-details">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Name:') }} </label>
                                    <input type="text" class="form-control app_name"
                                        placeholder="{{ __('Enter your name') }}">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-name"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Email:') }} </label>
                                    <input type="email" class="form-control app_email"
                                        placeholder="{{ __('Enter your email') }}">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-email"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Phone:') }} </label>
                                    <input type="number" class="form-control app_phone"
                                        placeholder="{{ __('Enter your phone no.') }}">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-phone"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-btn-group">
                            <button type="button" name="CLOSE" class="close-btn btn">
                                {{ __('Close') }}
                            </button>
                            <button type="button" name="SUBMIT" class="btn btn-secondary" id="makeappointment">
                                {{ __('Make Appointment') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!--appointment popup end here-->
            <!--card popup start here-->
            <div class="card-popup">
                <div class="container">
                    <div class="share-card-wrapper">
                        <div class="section-title">
                            <div class="close-search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="7" height="9"
                                    viewBox="0 0 7 9" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.84542 0.409757C6.21819 0.789434 6.21819 1.40501 5.84542 1.78469L3.17948 4.5L5.84542 7.21531C6.21819 7.59499 6.21819 8.21057 5.84542 8.59024C5.47265 8.96992 4.86826 8.96992 4.49549 8.59024L1.15458 5.18746C0.781807 4.80779 0.781807 4.19221 1.15458 3.81254L4.49549 0.409757C4.86826 0.0300809 5.47265 0.0300809 5.84542 0.409757Z"
                                        fill="#12131A" />
                                </svg>
                            </div>
                            <div class="section-title-center">
                                <h5>{{ __('Share This Card') }}</h5>
                            </div>
                            <button type="button" name="LOGOUT" class="logout-btn">

                            </button>
                        </div>
                        <div class="qr-scaner-wrapper">
                            <div class="qr-image shareqrcode">
                            </div>
                            <div class="qr-code-text">
                                <p> {{ __('Point your camera at the QR code, or visit') }} <span
                                        class="qr-link text-center mr-2 text-wrap"></span><br>{{ __('
                                                                                                                                                Or check my social channels') }}
                                </p>
                            </div>
                            <ul class="card-social-icons">
                                <li>
                                    <a href="https://twitter.com/share?url={{urlencode($url_link)}}&text=">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.25"
                                                d="M21.0002 7.5C21.5002 15 16.0002 21 9.00019 21C6.58828 21 4.17638 20.6768 2.28413 19.7706C1.85075 19.5631 2.02015 18.985 2.4996 18.9532C4.82969 18.7987 6.7579 18.2423 8.00019 17C11.0003 14 11.5002 13 12.2648 9.02396C12.0935 8.54804 12.0002 8.03492 12.0002 7.5C12.0002 5.01472 14.0149 3 16.5002 3C18.0184 3 19.361 3.75182 20.176 4.90346L21.8931 4.65815C22.321 4.59703 22.6196 5.07087 22.3799 5.43047L21.0002 7.5Z"
                                                fill="#12131A"></path>
                                            <path
                                                d="M7.99973 17.0004C2.58334 15.1949 1.64904 8.49988 2.62202 5.00757C2.73627 4.5975 3.2694 4.59536 3.48428 4.96283C5.14577 7.80408 8.30494 9.3904 12.2643 9.02434C18.4998 9.02434 16.9998 20.0004 7.99973 17.0004Z"
                                                fill="#12131A"></path>
                                        </svg>
                                    </a>
                                </li>
                                <li>

                                    @php
                                        $whatsapp_link = url('https://wa.me/?text=' . urlencode($url_link));
                                    @endphp
                                    <a href="{{ $whatsapp_link }}">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10 0C4.5 0 0 4.5 0 10C0 11.8 0.500781 13.5 1.30078 15L0 20L5.19922 18.8008C6.69922 19.6008 8.3 20 10 20C15.5 20 20 15.5 20 10C20 7.3 18.9996 4.80039 17.0996 2.90039C15.1996 1.00039 12.7 0 10 0ZM10 2C12.1 2 14.0992 2.80078 15.6992 4.30078C17.1992 5.90078 18 7.9 18 10C18 14.4 14.4 18 10 18C8.7 18 7.29922 17.7 6.19922 17L5.5 16.5996L4.80078 16.8008L2.80078 17.3008L3.30078 15.5L3.5 14.6992L3.09961 14C2.39961 12.8 2 11.4 2 10C2 5.6 5.6 2 10 2ZM6.5 5.40039C6.3 5.40039 6.00078 5.39922 5.80078 5.69922C5.50078 5.99922 4.90039 6.60078 4.90039 7.80078C4.90039 9.00078 5.80039 10.2004 5.90039 10.4004C6.10039 10.6004 7.69922 13.1992 10.1992 14.1992C12.2992 14.9992 12.6992 14.8008 13.1992 14.8008C13.6992 14.7008 14.7004 14.1996 14.9004 13.5996C15.1004 12.9996 15.0992 12.4992 15.1992 12.1992C15.0992 12.0992 14.9992 12.0004 14.6992 11.9004C14.4992 11.8004 13.3 11.1996 13 11.0996C12.7 10.9996 12.6004 10.8992 12.4004 11.1992C12.2004 11.4992 11.6996 11.9992 11.5996 12.1992C11.4996 12.3992 11.3996 12.4008 11.0996 12.3008C10.8996 12.2008 10.0996 11.9996 9.09961 11.0996C8.29961 10.4996 7.79922 9.70039 7.69922 9.40039C7.49922 9.20039 7.70078 9.00039 7.80078 8.90039L8.19922 8.5C8.29922 8.4 8.30039 8.19961 8.40039 8.09961C8.50039 7.99961 8.50039 7.89922 8.40039 7.69922C8.30039 7.49922 7.79961 6.30078 7.59961 5.80078C7.39961 5.40078 7.2 5.40039 7 5.40039H6.5Z"
                                                fill="black" />
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/sharer.php?u={{urlencode($url_link)}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <circle opacity="0.25" cx="12" cy="12" r="10"
                                                fill="#12131A"></circle>
                                            <path
                                                d="M11.5002 21.9877C11.776 22.0013 12 21.7761 12 21.5V14H14C14.5523 14 15 13.5523 15 13C15 12.4477 14.5523 12 14 12H12V10C12 9.44772 12.4477 9 13 9H14C14.5523 9 15 8.55229 15 8C15 7.44772 14.5523 7 14 7H13C11.3431 7 10 8.34315 10 10V12H9C8.44772 12 8 12.4477 8 13C8 13.5523 8.44771 14 9 14H10V21.3913C10 21.6291 10.1673 21.8353 10.4021 21.873C10.7621 21.9308 11.1285 21.9694 11.5002 21.9877Z"
                                                fill="#12131A"></path>
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/shareArticle?url={{urlencode($url_link)}}&title=">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.25" d="M0 3C0 1.34315 1.34315 0 3 0H17C18.6569 0 20 1.34315 20 3V17C20 18.6569 18.6569 20 17 20H3C1.34315 20 0 18.6569 0 17V3Z" fill="#12131A"/>
                                            <path d="M5 6C5.55228 6 6 5.55228 6 5C6 4.44772 5.55228 4 5 4C4.44772 4 4 4.44772 4 5C4 5.55228 4.44772 6 5 6Z" fill="#12131A"/>
                                            <path d="M5 8C4.44772 8 4 8.44772 4 9V15C4 15.5523 4.44772 16 5 16C5.55228 16 6 15.5523 6 15V9C6 8.44772 5.55228 8 5 8Z" fill="#12131A"/>
                                            <path d="M12 10C10.8954 10 10 10.8954 10 12V15C10 15.5523 9.55229 16 9 16C8.44771 16 8 15.5523 8 15V9C8 8.44772 8.44772 8 9 8C9.40537 8 9.7544 8.2412 9.91141 8.58791C10.5193 8.215 11.2346 8 12 8C14.2091 8 16 9.79086 16 12V15C16 15.5523 15.5523 16 15 16C14.4477 16 14 15.5523 14 15V12C14 10.8954 13.1046 10 12 10Z" fill="#12131A"/>
                                            </svg>
                                    </a>
                                </li>
                            </ul>

                        </div>

                    </div>
                </div>
            </div>
            <!--contact popup start here-->
            <div class="contact-popup">
                <div class="container">
                    <form class="appointment-form-wrapper contact-form-wrapper">
                        <div class="section-title">
                            <h5>{{ __('Make Contact') }}</h5>
                            <div class="close-search" data-dismiss="modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 18 18" fill="none">
                                    <path
                                        d="M14.6 17.4L0.600001 3.4C-0.2 2.6 -0.2 1.4 0.600001 0.600001C1.4 -0.2 2.6 -0.2 3.4 0.600001L17.4 14.6C18.2 15.4 18.2 16.6 17.4 17.4C16.6 18.2 15.4 18.2 14.6 17.4V17.4Z"
                                        fill="#000" />
                                    <path
                                        d="M0.600001 14.6L14.6 0.600001C15.4 -0.2 16.6 -0.2 17.4 0.600001C18.2 1.4 18.2 2.6 17.4 3.4L3.4 17.4C2.6 18.2 1.4 18.2 0.600001 17.4C-0.2 16.6 -0.2 15.4 0.600001 14.6V14.6Z"
                                        fill="#000" />
                                </svg>
                            </div>
                        </div>
                        <div class="row appo-form-details">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Name') }}:</label>
                                    <input type="text" name="name" placeholder="{{ __('Enter your name') }}"
                                        class="form-control contact_name">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-contactname"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Email') }}:</label>
                                    <input type="email" name="email" placeholder="{{ __('Enter your email') }}"
                                        class="form-control contact_email">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-contactemail"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Phone') }}:</label>
                                    <input type="text" name="phone"
                                        placeholder="{{ __('Enter your phone no.') }}"
                                        class="form-control contact_phone">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-contactphone"></span>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="business_id" value="{{ $business->id }}">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Message') }}:</label>
                                    <textarea name="message" placeholder="{{ __('Enter your Message.') }}"
                                        class="custom_size contact_message emojiarea" row="3"></textarea>
                                    <div class="">
                                        <span class="text-danger h5 span-error-contactmessage"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-btn-group">
                            <button type="button" class="close-btn btn "
                                data-dismiss="modal">{{ __('Close') }}</button>
                            <button type="button" class="btn btn-secondary"
                                id="makecontact">{{ __('Make Contact') }}</button>


                        </div>
                    </form>
                </div>
            </div>
            <!--contact popup end here-->
            <!--card popup end here-->
            <div class="password-popup" id="passwordmodel" role="dialog" data-backdrop="static"
                data-keyboard="false">
                <div class="container">
                    <form class="appointment-form-wrapper contact-form-wrapper">
                        <div class="section-title">
                            <h5>{{ __('Enter Password') }}</h5>
                        </div>
                        <div class="row appo-form-details">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Password') }}:</label>
                                    <input type="password" name="Password" placeholder="{{ __('Enter password') }}"
                                        class="form-control password_val" placeholder="Password">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-password"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-btn-group">
                            <button type="button"
                                class="btn form-btn--submit password-submit">{{ __('Submit') }}</button>


                        </div>
                    </form>
                </div>
            </div>

            {{-- Gallery Model --}}
            <div class="password-popup" id="gallerymodel" role="dialog" data-backdrop="static"
                data-keyboard="false">
                <div class="container">
                    <form class="appointment-form-wrapper contact-form-wrapper">
                        <div class="section-title">
                            <h5>{{ __('') }}</h5>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Image preview') }}:</label>
                                    <img src="" class="imagepreview" style="width: 500px; height: 300px;">
                                </div>
                            </div>
                        </div>
                        <div class="form-btn-group">
                            <button type="button" class="btn btn-default close-btn close-model"
                                data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="password-popup" id="videomodel" role="dialog" data-backdrop="static"
                data-keyboard="false">
                <div class="container">
                    <form class="appointment-form-wrapper contact-form-wrapper">
                        <div class="section-title">
                            <h5>{{ __('') }}</h5>
                        </div>
                        <div class="row ">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Video preview') }}:</label>

                                    <iframe width="100%" height="360" class="videopreview" src=""
                                        frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                        <div class="form-btn-group">
                            <button type="button" class="btn btn-default close-btn close-model1"
                                data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="overlay"></div>
            <img src="{{ isset($qr_detail->image) ? $qr_path . '/' . $qr_detail->image : '' }}" id="image-buffers"
                style="display: none">
        </div>
    </div>
    <div id="previewImage"> </div>
    <a id="download" href="#" class="font-lg download mr-3 text-white">
        <i class="fas fa-download"></i>
    </a>

    <!---wrapper end here-->
    <!--scripts start here-->
    

    <script src="{{ asset('custom/theme13/js/jquery.min.js') }}"></script>
    <script src="{{ asset('custom/theme13/js/slick.min.js') }}" defer="defer"></script>
    @if ($SITE_RTL == 'on')
        <script src="{{ asset('custom/theme13/js/rtl-custom.js') }}" defer="defer"></script>
    @else
        <script src="{{ asset('custom/theme13/js/custom.js') }}" defer="defer"></script>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.3/picker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.3/picker.date.js"></script>


    <script src="{{ asset('custom/js/emojionearea.min.js') }}"></script>
    <script src="{{ asset('custom/libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('custom/js/socialSharing.js') }}"></script>
    <script src="{{ asset('custom/js/socialSharing.min.js') }}"></script>

    <script src="{{ asset('custom/js/jquery.qrcode.min.js') }}"></script>

    @if ($business->enable_pwa_business == 'on' && $plan->pwa_business == 'on')
        <script type="text/javascript">
            const container = document.querySelector("body")

            const coffees = [];

            if ("serviceWorker" in navigator) {
                window.addEventListener("load", function() {
                    navigator.serviceWorker
                        .register("{{ asset('serviceWorker.js') }}")
                        .then(res => console.log("service worker registered"))
                        .catch(err => console.log("service worker not registered", err))

                })
            }
        </script>
    @endif


    <script type="text/javascript">
        $('#Demo').socialSharingPlugin({
            urlShare: window.location.href,
            description: $('meta[name=description]').attr('content'),
            title: $('title').text()
        })


        $(document).ready(function() {
            $(".emojiarea").emojioneArea();
            $(`.span-error-date`).text("");
            $(`.span-error-time`).text("");
            $(`.span-error-name`).text("");
            $(`.span-error-email`).text("");
            var slug = '{{ $business->slug }}';
            var url_link = `{{ url('/') }}/${slug}`;
            $(`.qr-link`).text(url_link);

            @if (isset($plan->enable_qr_code) && $plan->enable_qr_code == 'on')
                var foreground_color =
                    `{{ isset($qr_detail->foreground_color) ? $qr_detail->foreground_color : '#000000' }}`;
                var background_color =
                    `{{ isset($qr_detail->background_color) ? $qr_detail->background_color : '#ffffff' }}`;
                var radius = `{{ isset($qr_detail->radius) ? $qr_detail->radius : 26 }}`;
                var qr_type = `{{ isset($qr_detail->qr_type) ? $qr_detail->qr_type : 0 }}`;
                var qr_font = `{{ isset($qr_detail->qr_text) ? $qr_detail->qr_text : 'vCard' }}`;
                var qr_font_color =
                    `{{ isset($qr_detail->qr_text_color) ? $qr_detail->qr_text_color : '#f50a0a' }}`;
                var size = `{{ isset($qr_detail->size) ? $qr_detail->size : 9 }}`;

                $('.shareqrcode').empty().qrcode({
                    render: 'image',
                    size: 500,
                    ecLevel: 'H',
                    minVersion: 3,
                    quiet: 1,
                    text: url_link,
                    fill: foreground_color,
                    background: background_color,
                    radius: .01 * parseInt(radius, 10),
                    mode: parseInt(qr_type, 10),
                    label: qr_font,
                    fontcolor: qr_font_color,
                    image: $("#image-buffers")[0],
                    mSize: .01 * parseInt(size, 10)
                });
            @else
                $('.shareqrcode').qrcode({
                    width: 180,
                    height: 180,
                    text: url_link
                });
            @endif
        });
    </script>
    <script>
        $(".imagepopup").on("click", function(e) {
            var imgsrc = $(this).children(".imageresource").attr("src");
            $('.imagepreview').attr('src',
                imgsrc); // here asign the image to the modal when the user click the enlarge link
            $("#gallerymodel").addClass("active");
            $("body").toggleClass("no-scroll");
            $('html').addClass('modal-open');
            $('#gallerymodel').css("background", 'rgb(0 0 0 / 50%)')
        });

        $(".imagepopup1").on("click", function() {
            var imgsrc1 = $(this).children(".imageresource1").attr("src");
            $('.imagepreview').attr('src',
                imgsrc1); // here asign the image to the modal when the user click the enlarge link
            $("#gallerymodel").addClass("active");
            $("body").toggleClass("no-scroll");
            $('html').addClass('modal-open');
            $('#gallerymodel').css("background", 'rgb(0 0 0 / 50%)')
        });

        $(".videopop").on("click", function() {
            var videosrc = $(this).children('video').children(".videoresource").attr("src");
            $('.videopreview').attr('src',
                videosrc); // here asign the image to the modal when the user click the enlarge link
            $("#videomodel").addClass("active");
            $("body").toggleClass("no-scroll");
            $('html').addClass('modal-open');
            $('#videomodel').css("background",
                    'rgb(0 0 0 / 50%)'
                    ) // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        });

        $(".videopop1").on("click", function() {
            var videosrc1 = $(this).children('video').children(".videoresource1").attr("src");
            $('.videopreview').attr('src',
                videosrc1); // here asign the image to the modal when the user click the enlarge link
            $("#videomodel").addClass("active");
            $("body").toggleClass("no-scroll");
            $('html').addClass('modal-open');
            $('#videomodel').css("background",
                    'rgb(0 0 0 / 50%)'
                    ) // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        });

        $(".close-model").on("click", function() {
            $("#gallerymodel").removeClass("active");
            $("body").removeClass("no-scroll");
            $('html').removeClass('modal-open');
            $('#gallerymodel').css("background", '')
        });

        $(".close-model1").on("click", function() {
            $("#videomodel").removeClass("active");
            $("body").removeClass("no-scroll");
            $('html').removeClass('modal-open');
            $('#videomodel').css("background", '')
        });

        $(document).ready(function() {
            var date = new Date();
            $('.datepicker_min').pickadate({
                min: date,
            })
        });

        //Password Check
        @if (!Auth::check())
            let ispassword;
            var ispassenable = '{{ $business->enable_password }}';
            var business_password = '{{ $business->password }}';

            if (ispassenable == 'on') {
                $('.password-submit').click(function() {

                    ispassword = 'true';
                    passwordpopup('true');
                });

                function passwordpopup(type) {
                    if (type == 'false') {

                        $("#passwordmodel").addClass("active");
                        $("body").toggleClass("no-scroll");
                        $('html').addClass('modal-open');
                        $('#passwordmodel').css("background", 'rgb(0 0 0 / 50%)')
                    } else {

                        var password_val = $('.password_val').val();

                        if (password_val == business_password) {
                            $("#passwordmodel").removeClass("active");
                            $("body").removeClass("no-scroll");
                            $('html').removeClass('modal-open');
                            $('#passwordmodel').css("background", '')
                        } else {

                            $(`.span-error-password`).text("{{ __('*Please enter correct password') }}");
                            passwordpopup('false');

                        }
                    }
                }
                if (ispassword == undefined) {

                    passwordpopup('false');
                }
            }
        @endif


        $(`.rating_preview`).attr('id');
        var from_$input = $('#input_from').pickadate(),
            from_picker = from_$input.pickadate('picker')

        var to_$input = $('#input_to').pickadate(),
            to_picker = to_$input.pickadate('picker')

        var is_enabled = "{{ $is_enable }}";
        if (is_enabled) {
            $('#business-hours-div').show();
        } else {
            $('#business-hours-div').hide();
        }

        var is_contact_enable = "{{ $is_contact_enable }}";
        if (is_contact_enable) {
            $('#contact-div').show();
        } else {
            $('#contact-div').hide();
        }
        var is_enable_appoinment = "{{ $is_enable_appoinment }}";
        if (is_enable_appoinment) {
            $('#appointment-div').show();
        } else {
            $('#appointment-div').hide();
        }

        var is_enable_service = "{{ $is_enable_service }}";
        if (is_enable_service) {
            $('#services-div').show();
        } else {
            $('#services-div').hide();
        }
        var is_enable_product = "{{ $is_enable_product }}";
        if (is_enable_product) {
            $('#product-div').show();
        } else {
            $('#product-div').hide();
        }
        var is_enable_testimonials = "{{ $is_enable_testimonials }}";
        if (is_enable_testimonials) {
            $('#testimonials-div').show();
        } else {
            $('#testimonials-div').hide();
        }

        var is_enable_sociallinks = "{{ $is_enable_sociallinks }}";
        if (is_enable_sociallinks) {
            $('#social-div').show();
        } else {
            $('#social-div').hide();
        }

        var is_custom_html_enable = "{{ $is_custom_html_enable }}";
        if (is_custom_html_enable) {
            $('.custom_html_text').show();
        } else {
            $('.custom_html_text').hide();
        }

        var is_branding_enable = "{{ $is_branding_enabled }}";
        if (is_branding_enable) {
            $('.branding_text').show();
        } else {
            $('.branding_text').hide();
        }

        var is_enable_gallery = "{{ $is_enable_gallery }}";
        if (is_enable_gallery) {
            $('#gallery-div').show();
        } else {
            $('#gallery-div').hide();
        }

        $(`#makeappointment`).click(function() {
            $(`.span-error-date`).text("");
            $(`.span-error-time`).text("");
            $(`.span-error-name`).text("");
            $(`.span-error-email`).text("");

            var name = $(`.app_name`).val();
            var email = $(`.app_email`).val();
            var date = $(`.datepicker_min`).val();
            var phone = $(`.app_phone`).val();
            var time = $("input[type='radio']:checked").data('id');
            var business_id = '{{ $business->id }}';

            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [year, month, day].join('-');
            }
            if (date == "") {
                $(`.span-error-date`).text("{{ __('*Please choose date') }}");
                $("[data-dismiss=modal]").trigger({
                    type: "click"
                });
            } else if (document.querySelectorAll('input[type="radio"][name="time"]:checked').length < 1) {
                $(`.span-error-time`).text("{{ __('*Please choose time') }}");
                $("[data-dismiss=modal]").trigger({
                    type: "click"
                });
            } else if (name == "") {
                $(`.span-error-name`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {
                $(`.span-error-email`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {
                //alert("DSfgbn");
                $(`.span-error-phone`).text("{{ __('*Please enter your phone no.') }}");
            } else {
                $(`.span-error-date`).text("");
                $(`.span-error-time`).text("");
                $(`.span-error-name`).text("");
                $(`.span-error-email`).text("");
                date = formatDate(date);
                $.ajax({
                    url: '{{ route('appoinment.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
                        "email": email,
                        "phone": phone,
                        "date": date,
                        "time": time,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                        "name": name,
                        "email": email,
                        "date": date,
                        "time": time,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        if (data.flag == false) {
                            $(".close-search").trigger({
                                type: "click"
                            });
                            show_toastr('Error', data.msg, 'error');

                        } else {
                            $(".close-search").trigger({
                                type: "click"
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                            show_toastr('Success',
                                "{{ __('Thank you for booking an appointment.') }}", 'success');
                        }
                    }
                });
            }
        });

        $(`#makecontact`).click(function() {
            var name = $(`.contact_name`).val();
            var email = $(`.contact_email`).val();
            var phone = $(`.contact_phone`).val();
            var message = $(`.contact_message`).val();
            var business_id = '{{ $business->id }}';

            $(`.span-error-contactname`).text("");
            $(`.span-error-contactemail`).text("");
            $(`.span-error-contactphone`).text("");
            $(`.span-error-contactmessage`).text("");

            if (name == "") {
                $(`.span-error-contactname`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {
                $(`.span-error-contactemail`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {
                $(`.span-error-contactphone`).text("{{ __('*Please enter your phone no.') }}");
            } else if (message == "") {
                $(`.span-error-contactmessage`).text("{{ __('*Please enter your message.') }}");
            } else {

                $(`.span-error-contactname`).text("");
                $(`.span-error-contactemail`).text("");
                $(`.span-error-contactphone`).text("");
                $(`.span-error-contactmessage`).text("");

                $.ajax({
                    url: '{{ route('contacts.store') }}',
                    type: 'POST',
                    data: {
                        "name": name,
                        "email": email,
                        "phone": phone,
                        "message": message,
                        "business_id": business_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {

                        // location.reload();
                        $(".close-search").trigger({
                            type: "click"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                        show_toastr('Success', "{{ __('Your contact details has been noted.') }}",
                            'success');

                    }
                });
            }
        });
    </script>
    <!-- Google Analytic Code -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $business->google_analytic }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '{{ $business->google_analytic }}');
    </script>
    @if (isset($is_slug))
        <script>
            function show_toastr(title, message, type) {
                var o, i;
                var icon = '';
                var cls = '';

                if (type == 'success') {
                    icon = 'ti ti-check-circle';
                    cls = 'success';
                } else {
                    icon = 'ti ti-times-circle';
                    cls = 'danger';
                }

                $.notify({
                    icon: icon,
                    title: " " + title,
                    message: message,
                    url: ""
                }, {
                    element: "body",
                    type: cls,
                    allow_dismiss: !0,
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                    offset: {
                        x: 15,
                        y: 15
                    },
                    spacing: 80,
                    z_index: 1080,
                    delay: 2500,
                    timer: 2000,
                    url_target: "_blank",
                    mouse_over: !1,
                    animate: {
                        enter: o,
                        exit: i
                    },
                    template: '<div class="alert alert-{0} alert-icon alert-group alert-notify" data-notify="container" role="alert"><div class="alert-group-prepend alert-content"><span class="alert-group-icon"><i data-notify="icon"></i></span></div><div class="alert-content"><strong data-notify="title">{1}</strong><div data-notify="message">{2}</div></div><button type="button" class="close" data-notify="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                });
            }
            if ($(".datepicker").length) {
                $('.datepicker').daterangepicker({
                    singleDatePicker: true,
                    format: 'yyyy-mm-dd',
                });
            }
        </script>
    
        @if ($message = Session::get('success'))
            <script>
                show_toastr('Success', '{!! $message !!}', 'success');
            </script>
        @endif
        @if ($message = Session::get('error'))
            <script>
                show_toastr('Error', '{!! $message !!}', 'error');
            </script>
        @endif
    @endif
    <!-- Facebook Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $business->fbpixel_code }}');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=0000&ev=PageView&noscript={{ $business->fbpixel_code }}" /></noscript>

    <!-- Custom Code -->
    <script type="text/javascript">
        {!! $business->customjs !!}
    </script>
    @if (isset($is_pdf))
        @include('business.script');
    @endif
    @if (isset($is_slug))
        @if ($is_gdpr_enabled)
            <script src="{{ asset('js/cookieconsent.js') }}"></script>
            <script>
                let myVar = {!! json_encode($a) !!};
                let data = JSON.parse(myVar);
                let language_code = document.documentElement.getAttribute('lang');
                let languages = {};
                languages[language_code] = {
                    consent_modal: {
                        title: 'hello',
                        description: 'description',
                        primary_btn: {
                            text: 'primary_btn text',
                            role: 'accept_all'
                        },
                        secondary_btn: {
                            text: 'secondary_btn text',
                            role: 'accept_necessary'
                        }
                    },
                    settings_modal: {
                        title: 'settings_modal',
                        save_settings_btn: 'save_settings_btn',
                        accept_all_btn: 'accept_all_btn',
                        reject_all_btn: 'reject_all_btn',
                        close_btn_label: 'close_btn_label',
                        blocks: [{
                                title: 'block title',
                                description: 'block description'
                            },

                            {
                                title: 'title',
                                description: 'description',
                                toggle: {
                                    value: 'necessary',
                                    enabled: true,
                                    readonly: false
                                }
                            },
                        ]
                    }
                };
            </script>
            <script>
                function setCookie(cname, cvalue, exdays) {
                    const d = new Date();
                    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                    let expires = "expires=" + d.toUTCString();
                    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                }

                function getCookie(cname) {
                    let name = cname + "=";
                    let decodedCookie = decodeURIComponent(document.cookie);
                    let ca = decodedCookie.split(';');
                    for (let i = 0; i < ca.length; i++) {
                        let c = ca[i];
                        while (c.charAt(0) == ' ') {
                            c = c.substring(1);
                        }
                        if (c.indexOf(name) == 0) {
                            return c.substring(name.length, c.length);
                        }
                    }
                    return "";
                }


                // obtain plugin
                var cc = initCookieConsent();
                // run plugin with your configuration
                cc.run({
                    current_lang: 'en',
                    autoclear_cookies: true, // default: false
                    page_scripts: true,
                    // ...
                    gui_options: {
                        consent_modal: {
                            layout: 'cloud', // box/cloud/bar
                            position: 'bottom center', // bottom/middle/top + left/right/center
                            transition: 'slide', // zoom/slide
                            swap_buttons: false // enable to invert buttons
                        },
                        settings_modal: {
                            layout: 'box', // box/bar
                            // position: 'left',           // left/right
                            transition: 'slide' // zoom/slide
                        }
                    },

                    onChange: function(cookie, changed_preferences) {},
                    onAccept: function(cookie) {
                        if (!getCookie('cookie_consent_logged')) {
                            var cookie = cookie.level;
                            var slug = '{{ $business->slug }}';
                            $.ajax({
                                url: '{{ route('card-cookie-consent') }}',
                                datType: 'json',
                                data: {
                                    cookie: cookie,
                                    slug: slug,
                                },
                            })
                            setCookie('cookie_consent_logged', '1', 182, '/');
                        }
                    },
                    languages: {
                        'en': {
                            consent_modal: {
                                title: data.cookie_title,
                                description: data.cookie_description + ' ' +
                                    '<button type="button" data-cc="c-settings" class="cc-link">Let me choose</button>',
                                primary_btn: {
                                    text: "{{ __('Accept all') }}",
                                    role: 'accept_all' // 'accept_selected' or 'accept_all'
                                },
                                secondary_btn: {
                                    text: "{{ __('Reject all') }}",
                                    role: 'accept_necessary' // 'settings' or 'accept_necessary'
                                },
                            },
                            settings_modal: {
                                title: "{{ __('Cookie preferences') }}",
                                save_settings_btn: "{{ __('Save settings') }}",
                                accept_all_btn: "{{ __('Accept all') }}",
                                reject_all_btn: "{{ __('Reject all') }}",
                                close_btn_label: "{{ __('Close') }}",
                                cookie_table_headers: [{
                                        col1: 'Name'
                                    },
                                    {
                                        col2: 'Domain'
                                    },
                                    {
                                        col3: 'Expiration'
                                    },
                                    {
                                        col4: 'Description'
                                    }
                                ],
                                blocks: [{
                                    title: data.cookie_title + ' ' + '📢',
                                    description: data.cookie_description,
                                }, {
                                    title: data.strictly_cookie_title,
                                    description: data.strictly_cookie_description,
                                    toggle: {
                                        value: 'necessary',
                                        enabled: true,
                                        readonly: true // cookie categories with readonly=true are all treated as "necessary cookies"
                                    }
                                }, {
                                    title: "{{ __('More information') }}",
                                    description: data.more_information_description + ' ' +
                                        '<a class="cc-link" href="' + data.contactus_url + '">Contact Us</a>.',
                                }]
                            }
                        }
                    }

                });
            </script>
        @endif
    @endif
    <!--scripts end here-->
</body>

</html>
