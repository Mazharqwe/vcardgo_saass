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
    $is_empty_description = false;
    $is_custom_html_enable = false;
    $is_enable_gallery = false;
    $custom_html = $business->custom_html_text;
    $is_gdpr_enabled = false;
    $gdpr_text = $business->gdpr_text;
    $is_branding_enabled = false;
    $branding = $business->branding_text;
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
    
    if (!is_null($business->is_gdpr_enabled) && !is_null($business->is_gdpr_enabled)) {
        !empty($business->is_gdpr_enabled) && $business->is_gdpr_enabled == 'on' ? ($is_gdpr_enabled = true) : ($is_gdpr_enabled = false);
    }
    if (!is_null($business->is_branding_enabled) && !is_null($business->is_branding_enabled)) {
        !empty($business->is_branding_enabled) && $business->is_branding_enabled == 'on' ? ($is_branding_enabled = true) : ($is_branding_enabled = false);
    } else {
        $is_branding_enabled = false;
    }
    if (isset($color)) {
        $business->theme_color = $color;
    }
    $color = substr($business->theme_color, 0, 6);
    if (!empty($business->description)) {
        $is_empty_description = true;
    }
    
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $business->title }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="HandheldFriendly" content="True">

    <meta name="author" content="{{ $business->title }}">
    <meta name="keywords" content="{{ $business->meta_keyword }}">
    <meta name="description" content="{{ $business->meta_description }}">

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
    <link rel="stylesheet" href="{{ asset('custom/theme21/libs/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/theme21/fonts/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/css/emojionearea.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/animate.min.css') }}" />

    @if (isset($is_slug))
        <link rel="stylesheet" href="{{ asset('custom/theme21/modal/bootstrap.min.css') }}">
    @endif

    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('custom/theme21/css/rtl-main-style.css') }}">
        <link rel="stylesheet" href="{{ asset('custom/theme21/css/rtl-responsive.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('custom/theme21/css/main-style.css') }}">
        <link rel="stylesheet" href="{{ asset('custom/theme21/css/responsive.css') }}">
    @endif
    @if ($business->google_fonts != 'Default' && isset($business->google_fonts))
        <style>
            @import url('{{ \App\Models\Utility::getvalueoffont($business->google_fonts)['link'] }}');

            :root .theme21-v1 {
                --Strawford: '{{ strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') }}', {{ substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1) }};
            }

            :root .theme21-v2 {
                --Strawford: '{{ strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') }}', {{ substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1) }};
            }

            :root .theme21-v3 {
                --Strawford: '{{ strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') }}', {{ substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1) }};
            }

            :root .theme21-v4 {
                --Strawford: '{{ strtok(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') }}', {{ substr(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], strpos(\App\Models\Utility::getvalueoffont($business->google_fonts)['fontfamily'], ',') + 1) }};
            }

            :root .theme21-v5 {
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
    <div id="boxes">
        <div class="{{ \App\Models\Utility::themeOne()['theme21'][$business->theme_color]['theme_name'] }}"
            id="view_theme10">
            <div class="home-wrapper">
                <section class="client-info-section padding-top padding-bottom">
                    <div class="container">
                        <div class="client-info-wrapper bg-white">
                            <div class="client-intro text-center">
                                <div class="client-image">

                                    <img src="{{ isset($business->logo) && !empty($business->logo) ? $logo . '/' . $business->logo : asset('custom/img/logo-placeholder-image-2.png') }}"
                                        id="business_logo_preview" alt="image">
                                </div>
                                <h3 id="{{ $stringid . '_title' }}_preview" class="text-black">{{ $business->title }}
                                </h3>
                                <h6 id="{{ $stringid . '_designation' }}_preview" class="text-black">
                                    {{ $business->designation }}</h6>
                                <span id="{{ $stringid . '_subtitle' }}_preview">{{ $business->sub_title }}</span>
                            </div>
                        </div>
                    </div>
                </section>
                @php $j = 1; @endphp
                @foreach ($card_theme->order as $order_key => $order_value)
                    @if ($j == $order_value)
                        @if ($order_key == 'contact_info')
                            <section class="top-social-section" id="contact-div">
                                <div class="container">
                                    <ul class="banner-social-icons bg-white" id="inputrow_contact_preview">
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
                                                        @php $href = $val1; @endphp
                                                    @endif

                                                    @if ($key1 != 'id')
                                                        @php
                                                            $svg_file = file_get_contents(asset('custom/theme21/icon/' . $color . '/contact/' . strtolower($key1) . '.svg'));
                                                            
                                                            $find_string = '<svg';
                                                            $position = strpos($svg_file, $find_string);
                                                            
                                                            $svg_file_new = substr($svg_file, $position);
                                                            
                                                        @endphp
                                                        <li id="contact_{{ $loop->parent->index + 1 }}">
                                                            @if ($key1 == 'Address')
                                                                @foreach ($val1 as $key2 => $val2)
                                                                    @if ($key2 == 'Address_url')
                                                                        @php $href = $val2; @endphp
                                                                    @endif
                                                                @endforeach

                                                                <a href="{{ $href }}" target="_blank">
                                                                    <div class="contact-svg">
                                                                        {!! $svg_file_new !!}
                                                                    </div>
                                                                    @foreach ($val1 as $key2 => $val2)
                                                                        @if ($key2 == 'Address')
                                                                            <span
                                                                                id="{{ $key1 . '_' . $no }}_preview">{{ $key1 }}</span>
                                                                        @endif
                                                                    @endforeach

                                                                </a>
                                                            @else
                                                                @if ($key1 == 'Whatsapp')
                                                                    <a href="{{ url('https://wa.me/' . $href) }}"
                                                                        target="_blank">
                                                                        <div class="contact-svg">
                                                                            {!! $svg_file_new !!}
                                                                        </div>
                                                                    @else
                                                                        <a href="{{ $href }}">
                                                                            <div class="contact-svg">
                                                                                {!! $svg_file_new !!}
                                                                            </div>
                                                                @endif
                                                                <span>@if($key1 == 'Web_url'){{ __('Web Url') }} @else{{ __($key1) }}@endif</span>
                                                                </a>
                                                            @endif
                                                        </li>
                                                    @endif
                                                    @php
                                                        $no++;
                                                    @endphp
                                                @endforeach
                                            @endforeach
                                        @endif

                                    </ul>
                                </div>
                            </section>
                            {{-- @endif --}}
                        @endif
                        @if ($order_key == 'description')
                            <section class="client-text-section description-div" id="description-div">
                                <div class="container">
                                    <div class="client-text bg-white">
                                        <p id="{{ $stringid . '_desc' }}_preview">{{ $business->description }}</p>
                                    </div>
                                </div>
                            </section>
                        @endif
                        @if ($order_key == 'appointment')
                            <section class="appointment-section padding-top" id="appointment-div">
                                <div class="container">
                                    <div class="appointment-wraper bg-white">
                                        <div class="section-title text-center">
                                            <h2>{{ __('Make an') }}{{ __(' appointment') }}</h2>
                                        </div>
                                        <div class="appointment-date">
                                            <div class="date-label">
                                                {{ __('Date') }}
                                            </div>
                                            <input type="text" placeholder="{{ __('Pick a Date') }}"
                                                class="text-center datepicker_min">
                                        </div>
                                        <div class="pl-1 mt-0">
                                            <span class="text-danger text-center h5 span-error-date"
                                                style="{{ $SITE_RTL == 'on' ? 'margin-right: 80px;' : 'margin-left: 80px;' }}"></span>
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
                                                                type="radio" value=".blue"
                                                                data-id="@if (!empty($hour->start)) {{ $hour->start }} @else 00:00 @endif-@if (!empty($hour->end)) {{ $hour->end }} @else 00:00 @endif"
                                                                class="app_time">
                                                            <label for="radio-{{ $radiocount }}"
                                                                class="radio-label">
                                                                @if (!empty($hour->start))
                                                                    {{ $hour->start }}
                                                                @else
                                                                    00:00
                                                                    @endif - @if (!empty($hour->end))
                                                                        {{ $hour->end }}
                                                                    @else
                                                                        00:00
                                                                    @endif
                                                            </label>
                                                        </div>
                                                        @php
                                                            $radiocount++;
                                                            $appointment_no++;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="mt-0 mb-3 col-12">
                                                <span class="text-danger text-center span-error-time"
                                                    style="{{ $SITE_RTL == 'on' ? 'margin-right: 80px;' : 'margin-left: 80px;' }}"></span>
                                            </div>
                                        </div>
                                        <div class="appointment-btn">
                                            <a href="javascript:;" class="btn" tabindex="0">
                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M6 3C6 2.44772 6.44772 2 7 2C7.55228 2 8 2.44772 8 3V4H16V3C16 2.44772 16.4477 2 17 2C17.5523 2 18 2.44772 18 3V4H19C20.6569 4 22 5.34315 22 7V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V7C2 5.34315 3.34315 4 5 4H6V3Z"
                                                        fill="white"></path>
                                                    <path class="theme-svg" fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M10 12C9.44772 12 9 12.4477 9 13C9 13.5523 9.44772 14 10 14H17C17.5523 14 18 13.5523 18 13C18 12.4477 17.5523 12 17 12H10ZM7 16C6.44772 16 6 16.4477 6 17C6 17.5523 6.44772 18 7 18H13C13.5523 18 14 17.5523 14 17C14 16.4477 13.5523 16 13 16H7Z"
                                                        fill="#FDD395"></path>
                                                </svg>
                                                {{ __('Make an appointment') }}
                                            </a>
                                        </div>
                                    </div>
                            </section>
                        @endif
                        @if ($order_key == 'service')
                            <section class="service-section padding-top padding-bottom" id="services-div">
                                <div class="container">
                                    <div class="service-section-wraper bg-white">
                                        <div class="section-title text-center">
                                            <h2>{{ __('Services') }}</h2>
                                        </div>
                                        <div class="service-card-wrapper" id="inputrow_service_preview">
                                            @php $image_count = 0; @endphp
                                            @foreach ($services_content as $k1 => $content)
                                                <div class="service-card" id="services_{{ $service_row_no }}">
                                                    <div class="service-card-inner">
                                                        <div class="service-icon">
                                                            <img id="{{ 's_image' . $image_count . '_preview' }}"
                                                                src="{{ isset($content->image) && !empty($content->image) ? $s_image . '/' . $content->image : asset('custom/img/logo-placeholder-image-21.png') }}"class="img-fluid"
                                                                alt="image">
                                                        </div>
                                                        <h5 id="{{ 'title_' . $service_row_no . '_preview' }}">
                                                            {{ $content->title }}</h5>
                                                        <p style="color: white;"
                                                            id="{{ 'description_' . $service_row_no . '_preview' }}">
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
                                </div>
                            </section>
                        @endif
                        @if ($order_key == 'product')
                                <section class="product-section padding-bottom" id="product-div">
                                    <div class="container">
                                        <div class="service-section-wraper bg-white">
                                            <div class="section-title text-center">
                                                <h2>{{ __('Product') }}</h2>
                                            </div>
                                            <div class="service-card-wrapper" id="inputrow_product_preview">
                                                @php $pr_image_count = 0; @endphp
                                                @foreach ($products_content as $k1 => $content)
                                                    <div class="service-card"
                                                        id="product_{{ $product_row_no }}">
                                                        <div class="service-card-inner">
                                                            <div class="service-icon">
                                                                <img id="{{ 'pr_image' . $pr_image_count . '_preview' }}"
                                                                    src="{{ isset($content->image) && !empty($content->image) ? $pr_image . '/' . $content->image : asset('custom/img/logo-placeholder-image-21.png') }}"class="img-fluid"
                                                                    alt="image">
                                                            </div>
                                                            <h5 id="{{ 'product_title_' . $product_row_no . '_preview' }}">
                                                                {{ $content->title }}</h5>
                                                            <p style="color: white;" id="{{ 'product_description_' . $product_row_no . '_preview' }}">
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
                                    </div>
                                </section>
                            @endif
                        @if ($order_key == 'gallery')
                            <section class="gallery-section  padding-bottom" id="gallery-div">
                                <div class="container">
                                    <div class="service-section-wraper bg-white">
                                        <div class="section-title text-center">
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
                                                                                    <a href="javascript:;"
                                                                                        id="" tabindex="0"
                                                                                        class="videopop1">
                                                                                        <video loop controls="true" poster="{{ asset('custom/img/video_youtube.jpg') }}">
                                                                                            <source
                                                                                                class="videoresource1"
                                                                                                src="{{ isset($gallery_content->value) && !empty($gallery_content->value) ? 'https://www.youtube.com/embed/' . $video_url : asset('custom/img/logo-placeholder-image-2.png') }}"
                                                                                                type="video/mp4">
                                                                                        </video>
                                                                                    </a>
                                                                                @else
                                                                                    <a href="javascript:;"
                                                                                        id="" tabindex="0"
                                                                                        class="videopop1">
                                                                                        <video loop controls="true" poster="{{ asset('custom/img/video_youtube.jpg') }}">
                                                                                            <source
                                                                                                class="videoresource1"
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
                                                                                        alt="images"
                                                                                        id="upload_image">
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
                                </div>
                            </section>
                        @endif
                        @if ($order_key == 'testimonials')
                            <section class="testimonials-section padding-bottom" id="testimonials-div">
                                <div class="container">
                                    <div class="testimonials-wraper bg-white">
                                        <div class="section-title text-center">
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
                                                                <h5 class="rating-number">
                                                                    {{ $testi_content->rating }}/5</h5>

                                                                <div class="rating-star">
                                                                    @php
                                                                        if (!empty($testi_content->rating)) {
                                                                            $rating = (int) $testi_content->rating;
                                                                            $overallrating = $rating;
                                                                        } else {
                                                                            $overallrating = 0;
                                                                        }
                                                                    @endphp
                                                                    <span
                                                                        id="{{ 'stars' . $testimonials_row_no }}_star"
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
                                            <div class="testimonial-slider flex-slider"
                                                id="inputrow_testimonials_preview">
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
                                                                    alt="image">
                                                            </div>
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
                                                    @php
                                                        $t_image_count++;
                                                        $testimonials_row_no++;
                                                    @endphp
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </section>
                        @endif
                        @if ($order_key == 'social')
                            <section class="social-icons-second-section" id="social-div">
                                <div class="container">
                                    <div class="social-icon-wrapper bg-white">
                                        <div class="section-title text-center">
                                            <h2>{{ __('Social') }}</h2>
                                        </div>
                                        <ul class="social-icon" id="inputrow_socials_preview">
                                            @if (!is_null($social_content) && !is_null($sociallinks))
                                                @foreach ($social_content as $social_key => $social_val)
                                                    @foreach ($social_val as $social_key1 => $social_val1)
                                                        @if ($social_key1 != 'id')
                                                            <li class="socials_{{ $loop->parent->index + 1 }}"
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
                                                                <div>
                                                                    <a href="{{ $social_links }}"
                                                                        id="social_link_{{ $loop->parent->index + 1 }}_href_preview"
                                                                        class="social_link_{{ $loop->parent->index + 1 }}_href_preview"
                                                                        target="_blank">
                                                                        <img src="{{ asset('custom/theme21/icon/' . $color . '/social/' . strtolower($social_key1) . '.svg') }}"
                                                                            alt="{{ $social_key1 }}"
                                                                            class="img-fluid">
                                                                    </a>
                                                                </div>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </section>
                        @endif
                        @if ($order_key == 'more')
                            <section class="more-card-section padding-top">
                                <div class="container">
                                    <div class="more-btn">
                                        <a href="{{ route('bussiness.save', $business->slug) }}" class="btn"
                                            tabindex="0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="19"
                                                viewBox="0 0 22 19" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M10.8676 5.41797L9.6954 3.46428C9.39795 2.96852 8.94858 2.68502 8.49937 2.62776C7.63403 2.51745 6.55518 2.41797 5.5 2.41797C4.76672 2.41797 4.0186 2.46607 3.33466 2.5334C2.70504 2.59538 2.24029 3.06309 2.19011 3.71721C2.08968 5.02657 2 6.90062 2 9.41797C2 11.1906 2.06456 12.7695 2.14656 14.0596C2.22311 15.2638 3.13628 16.1727 4.34979 16.2427C5.99648 16.3376 8.2132 16.418 11 16.418C13.7868 16.418 16.0035 16.3376 17.6502 16.2427C18.8637 16.1727 19.7769 15.2638 19.8534 14.0596C19.9354 12.7695 20 11.1906 20 9.41797C20 8.45184 19.944 7.53469 19.8699 6.74589C19.8087 6.09488 19.3231 5.60922 18.6721 5.54806C17.8833 5.47396 16.9661 5.41797 16 5.41797H10.8676ZM12 3.41797L11.4104 2.43529C10.8306 1.46891 9.87021 0.786322 8.75227 0.643814C7.83875 0.527364 6.66937 0.417969 5.5 0.417969C4.68392 0.417969 3.86784 0.471247 3.13873 0.543021C1.53169 0.701216 0.319474 1.95417 0.19597 3.56425C0.0913573 4.92805 0 6.85326 0 9.41797C0 11.2385 0.0662874 12.8602 0.150591 14.1865C0.291559 16.4042 2.01613 18.1114 4.23467 18.2394C5.91963 18.3365 8.17474 18.418 11 18.418C13.8253 18.418 16.0804 18.3365 17.7653 18.2394C19.9839 18.1114 21.7084 16.4042 21.8494 14.1865C21.9337 12.8602 22 11.2385 22 9.41797C22 8.37683 21.9398 7.39592 21.8611 6.55882C21.7101 4.95109 20.4669 3.70787 18.8591 3.55683C18.0221 3.47819 17.0411 3.41797 16 3.41797H12Z"
                                                    fill="white"></path>
                                            </svg>
                                            {{ __('Save Card') }}
                                        </a>
                                        <a href="javascript:;" class="btn our-card" tabindex="0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="22"
                                                viewBox="0 0 18 22" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.99858 9.03956C6.02798 9.59107 5.60474 10.062 5.05324 10.0914C4.30055 10.1315 3.7044 10.1806 3.23854 10.2297C2.61292 10.2957 2.23278 10.68 2.16959 11.2328C2.07886 12.0264 2 13.2275 2 14.9997C2 16.772 2.07886 17.973 2.16959 18.7666C2.23289 19.3204 2.61207 19.7036 3.23675 19.7695C4.33078 19.885 6.13925 19.9997 9 19.9997C11.8608 19.9997 13.6692 19.885 14.7632 19.7695C15.3879 19.7036 15.7671 19.3204 15.8304 18.7666C15.9211 17.973 16 16.7719 16 14.9997C16 13.2275 15.9211 12.0264 15.8304 11.2328C15.7672 10.68 15.3871 10.2957 14.7615 10.2297C14.2956 10.1806 13.6995 10.1315 12.9468 10.0914C12.3953 10.062 11.972 9.59107 12.0014 9.03956C12.0308 8.48806 12.5017 8.06482 13.0532 8.09422C13.8361 8.13595 14.4669 8.18757 14.9712 8.24075C16.4556 8.3973 17.6397 9.4504 17.8175 11.0056C17.9188 11.892 18 13.1712 18 14.9997C18 16.8282 17.9188 18.1074 17.8175 18.9938C17.6398 20.5481 16.4585 21.6017 14.9732 21.7585C13.7919 21.8831 11.9108 21.9997 9 21.9997C6.08922 21.9997 4.20806 21.8831 3.02684 21.7585C1.54151 21.6017 0.360208 20.5481 0.182529 18.9938C0.081204 18.1074 0 16.8282 0 14.9997C0 13.1712 0.0812039 11.892 0.182529 11.0056C0.360314 9.4504 1.54436 8.3973 3.02877 8.24075C3.53306 8.18757 4.16393 8.13595 4.94676 8.09422C5.49827 8.06482 5.96918 8.48806 5.99858 9.03956Z"
                                                    fill="white"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M6.20711 5.20711C5.81658 5.59763 5.18342 5.59763 4.79289 5.20711C4.40237 4.81658 4.40237 4.18342 4.79289 3.79289L8.29289 0.292893C8.68342 -0.0976311 9.31658 -0.0976311 9.70711 0.292893L13.2071 3.79289C13.5976 4.18342 13.5976 4.81658 13.2071 5.20711C12.8166 5.59763 12.1834 5.59763 11.7929 5.20711L10 3.41421V13C10 13.5523 9.55228 14 9 14C8.44772 14 8 13.5523 8 13L8 3.41421L6.20711 5.20711Z"
                                                    fill="white"></path>
                                            </svg>
                                            {{ __('Share Card') }}
                                        </a>
                                        <a href="javascript:;" class="btn our-contact" tabindex="0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M4.82379 1.66449C5.83674 0.651544 7.512 0.770603 8.37152 1.91662L9.79825 3.81894C10.5011 4.75611 10.4079 6.06751 9.57958 6.89586L8.52769 7.94775C8.62963 8.2131 8.96522 8.79539 9.98717 9.81734C11.0091 10.8393 11.5914 11.1749 11.8567 11.2768L12.9086 10.2249C13.737 9.39657 15.0484 9.30336 15.9856 10.0062L17.8879 11.433C19.0339 12.2925 19.153 13.9678 18.14 14.9807C17.8107 15.31 17.755 15.3658 17.2054 15.9153C16.6453 16.4754 15.456 16.999 14.2519 17.0513C12.3677 17.1332 9.80829 16.2966 6.65811 13.1464C3.50793 9.99621 2.67127 7.43681 2.7532 5.55258C2.79877 4.50442 3.13201 3.35321 3.89355 2.6035C4.43874 2.04954 4.50964 1.97864 4.82379 1.66449ZM4.32105 5.62075C4.26426 6.92686 4.81471 9.08362 7.7678 12.0367C10.7209 14.9898 12.8776 15.5402 14.1838 15.4835C15.403 15.4304 16.0571 14.8413 16.0957 14.8056L17.0303 13.871C17.368 13.5334 17.3283 12.975 16.9463 12.6885L15.044 11.2617C14.7316 11.0274 14.2944 11.0585 14.0183 11.3346C13.6023 11.7506 13.3183 12.0388 12.7624 12.5926C11.6077 13.743 9.63106 11.6806 8.87748 10.927C8.18495 10.2345 6.07446 8.1951 7.21078 7.04531C7.21302 7.04305 7.51909 6.73699 8.4699 5.78618C8.74601 5.51006 8.77708 5.07293 8.54279 4.76054L7.11605 2.85822C6.82955 2.47621 6.27112 2.43653 5.93348 2.77418C5.62271 3.08494 5.271 3.43665 4.99979 3.70973C4.44161 4.27178 4.35092 4.93369 4.32105 5.62075Z"
                                                    fill="white"></path>
                                            </svg>
                                            {{ __('Contact') }}
                                        </a>
                                    </div>
                                </div>
                            </section>
                        @endif
                        @if ($order_key == 'custom_html')
                            <div id="{{ $stringid . '_chtml' }}_preview" class="custom_html_text">
                                {!! stripslashes($custom_html) !!}
                            </div>
                        @endif

                        @php $j = $j + 1; @endphp
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
                                <p>{{ __('Point your camera at the QR code, or visit ') }}<span
                                        class="qr-link text-center mr-2 text-wrap"></span><br>{{ __('Or check my social channels') }}
                                </p>
                            </div>
                            <ul class="card-social-icons">
                                <li>
                                    <a href="https://twitter.com/share?url={{urlencode($url_link)}}&text=">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M14.4827 8.25C14.7327 12 11.9827 15 8.48276 15C7.27681 15 6.07085 14.8384 5.12473 14.3853C4.90804 14.2815 4.99274 13.9925 5.23247 13.9766C6.39751 13.8993 7.36161 13.6212 7.98276 13C9.48285 11.5 9.7328 11 10.1151 9.01198C10.0294 8.77402 9.98275 8.51746 9.98275 8.25C9.98275 7.00736 10.9901 6 12.2327 6C12.9918 6 13.6631 6.37591 14.0706 6.95173L14.9292 6.82908C15.1431 6.79852 15.2925 7.03543 15.1726 7.21523L14.4827 8.25Z"
                                                fill="white"></path>
                                            <path
                                                d="M7.98278 13C5.27458 12.0972 4.80743 8.7497 5.29392 7.00354C5.35104 6.7985 5.61761 6.79744 5.72505 6.98117C6.55579 8.4018 8.13538 9.19496 10.1151 9.01193C13.2328 9.01193 12.4828 14.5 7.98278 13Z"
                                                fill="white"></path>
                                            <rect x="0.75" y="0.75" width="18.5" height="18.5"
                                                rx="3.25" stroke="white" stroke-width="1.5"></rect>
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
                                                fill="white" />
                                        </svg>

                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/sharer.php?u={{urlencode($url_link)}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M13.3333 19.25H11H3C2.61666 19.25 2.04526 18.9887 1.53351 18.4845C1.02334 17.9819 0.75 17.4126 0.75 17V3C0.75 2.58739 1.02334 2.01811 1.53351 1.51546C2.04526 1.01127 2.61666 0.75 3 0.75H17C17.3833 0.75 17.9547 1.01127 18.4665 1.51546C18.9767 2.01811 19.25 2.58739 19.25 3V17C19.25 17.4126 18.9767 17.9819 18.4665 18.4845C17.9547 18.9887 17.3833 19.25 17 19.25H13.3333Z"
                                                stroke="white" stroke-width="1.5"></path>
                                            <path
                                                d="M12 8.21429C12 7.62255 12.4477 7.14286 13 7.14286H14C14.5523 7.14286 15 6.66317 15 6.07143C15 5.47969 14.5523 5 14 5H13C11.3431 5 10 6.43908 10 8.21429V10.3571H9C8.44771 10.3571 8 10.8368 8 11.4286C8 12.0203 8.44771 12.5 9 12.5H10V18.9286C10 19.5203 10.4477 20 11 20C11.5523 20 12 19.5203 12 18.9286V12.5H14C14.5523 12.5 15 12.0203 15 11.4286C15 10.8368 14.5523 10.3571 14 10.3571H12V8.21429Z"
                                                fill="white"></path>
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/shareArticle?url={{urlencode($url_link)}}&title=">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path  d="M0 3C0 1.34315 1.34315 0 3 0H17C18.6569 0 20 1.34315 20 3V17C20 18.6569 18.6569 20 17 20H3C1.34315 20 0 18.6569 0 17V3Z" stroke="white" stroke-width="1.5"/>
                                            <path d="M5 6C5.55228 6 6 5.55228 6 5C6 4.44772 5.55228 4 5 4C4.44772 4 4 4.44772 4 5C4 5.55228 4.44772 6 5 6Z" fill="white"/>
                                            <path d="M5 8C4.44772 8 4 8.44772 4 9V15C4 15.5523 4.44772 16 5 16C5.55228 16 6 15.5523 6 15V9C6 8.44772 5.55228 8 5 8Z" fill="white"/>
                                            <path d="M12 10C10.8954 10 10 10.8954 10 12V15C10 15.5523 9.55229 16 9 16C8.44771 16 8 15.5523 8 15V9C8 8.44772 8.44772 8 9 8C9.40537 8 9.7544 8.2412 9.91141 8.58791C10.5193 8.215 11.2346 8 12 8C14.2091 8 16 9.79086 16 12V15C16 15.5523 15.5523 16 15 16C14.4477 16 14 15.5523 14 15V12C14 10.8954 13.1046 10 12 10Z" fill="white"/>
                                            </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--card popup end here-->
            <!--contact popup start here-->
            <div class="contact-popup">
                <div class="container">
                    <form class="appointment-form-wrapper contact-form-wrapper">
                        <div class="section-title">
                            <h5>{{ __('Make Contact') }}</h5>
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
                                    <label>{{ __('Name:') }}</label>
                                    <input type="text" name="name" placeholder="{{ __('Enter your name') }}"
                                        class="form-control contact_name">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-contactname"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Email:') }}</label>
                                    <input type="email" name="email" placeholder="{{ __('Enter your email') }}"
                                        class="form-control contact_email" id="recipient-email">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-contactemail"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Phone:') }}</label>
                                    <input type="text" name="phone"
                                        placeholder="{{ __('Enter your phone no') }}"
                                        class="form-control contact_phone" id="recipient-phone">
                                    <div class="">
                                        <span class="text-danger  h5 span-error-contactphone"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Message:') }}</label>
                                    <textarea name="message" placeholder="" row="3" class=" custom_size contact_message emojiarea"
                                        id="recipient-message"></textarea>
                                    <div class="">
                                        <span class="text-danger h5 span-error-contactmessage"></span>
                                    </div>
                                </div>
                                <input type="hidden" name="business_id" value="{{ $business->id }}">
                            </div>
                        </div>
                        <div class="form-btn-group">
                            <button type="button" name="CLOSE" class="close-btn btn">
                                {{ __('Close') }}
                            </button>
                            <button type="button" name="SUBMIT" class="btn btn-secondary" id="makecontact">
                                {{ __('Make Contact') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!--contact popup end here-->
            <!-- Modal -->
            <div class="contact-popup2" id="passwordmodel" role="dialog" data-backdrop="static"
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

            {{-- Gallery Models --}}
            <div class="contact-popup2" id="gallerymodel" role="dialog" data-backdrop="static"
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
            <div class="contact-popup2" id="videomodel" role="dialog" data-backdrop="static"
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
            \<img src="{{ isset($qr_detail->image) ? $qr_path . '/' . $qr_detail->image : '' }}" id="image-buffers"
                style="display: none">
        </div>
    </div>
    <div id="previewImage"> </div>
    <a id="download" href="#" class="font-lg download mr-3 text-white">
        <i class="fas fa-download"></i>
    </a>

    

    <script src="{{ asset('custom/theme21/js/jquery.min.js') }}"></script>
    <script src="{{ asset('custom/theme21/js/slick.min.js') }}" defer="defer"></script>

    @if ($SITE_RTL == 'on')
        <script src="{{ asset('custom/theme21/js/rtl-custom.js') }}" defer="defer"></script>
    @else
        <script src="{{ asset('custom/theme21/js/custom.js') }}" defer="defer"></script>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.3/picker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.3/picker.date.js"></script>
    @if (isset($plan->enable_qr_code) && $plan->enable_qr_code == 'on')
        <script src="{{ asset('custom/js/jquery.qrcode.min.js') }}"></script>
    @else
        <script src="{{ asset('custom/js/jquery.qrcode.js') }}"></script>
        <script type="text/javascript" src="https://jeromeetienne.github.io/jquery-qrcode/src/qrcode.js"></script>
    @endif
    <script src="{{ asset('custom/js/emojionearea.min.js') }}"></script>
    <script src="{{ asset('custom/libs/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('custom/js/socialSharing.js') }}"></script>
    <script src="{{ asset('custom/js/socialSharing.min.js') }}"></script>

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
                'rgb(0 0 0 / 50%)') // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        });

        $(".videopop1").on("click", function() {
            var videosrc1 = $(this).children('video').children(".videoresource1").attr("src");
            $('.videopreview').attr('src',
            videosrc1); // here asign the image to the modal when the user click the enlarge link
            $("#videomodel").addClass("active");
            $("body").toggleClass("no-scroll");
            $('html').addClass('modal-open');
            $('#videomodel').css("background",
                'rgb(0 0 0 / 50%)') // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
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
                var qr_font_color = `{{ isset($qr_detail->qr_text_color) ? $qr_detail->qr_text_color : '#f50a0a' }}`;
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

        var is_empty_description = "{{ $is_empty_description }}";
        if (is_empty_description) {
            $('.description-div').show();
        } else {
            $('.description-div').hide();
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
            var name = $(`.app_name`).val();
            var email = $(`.app_email`).val();
            var date = $(`.datepicker_min`).val();
            var phone = $(`.app_phone`).val();
            var time = $("input[type='radio']:checked").data('id');
            var business_id = '{{ $business->id }}';
            $(`.span-error-date`).text("");
            $(`.span-error-time`).text("");
            $(`.span-error-name`).text("");
            $(`.span-error-email`).text("");

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
                $(".close-search").trigger({
                    type: "click"
                });
            } else if (document.querySelectorAll('input[type="radio"][name="time"]:checked').length < 1) {
                $(`.span-error-time`).text("{{ __('*Please choose time') }}");
                $(".close-search").trigger({
                    type: "click"
                });
            } else if (name == "") {
                $(`.span-error-name`).text("{{ __('*Please enter your name') }}");
            } else if (email == "") {
                $(`.span-error-email`).text("{{ __('*Please enter your email') }}");
            } else if (phone == "") {
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
</body>

</html>
