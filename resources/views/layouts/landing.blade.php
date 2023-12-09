@php
    // $logo=asset(Storage::url('uploads/logo'));
    $logo = \App\Models\Utility::get_file('uploads/logo/');
    $setting = App\Models\Utility::settings();
    $set_cookie = App\Models\Utility::cookie_settings();
    $langSetting = App\Models\Utility::langSetting();
@endphp
<!DOCTYPE html>
<html lang="en" dir="{{ $setting['SITE_RTL'] == 'on' ? 'rtl' : '' }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ Utility::getValByName('title_text') ? Utility::getValByName('title_text') : config('app.name', 'vCardGo SaaS') }}
    </title>

    <link rel="icon" href="{{ $logo . '/2_favicon.png' }}" type="image/x-icon" />
    @include('frontend.includes.head')

</head>
<body class="home page-template-default page page-id-17 theme-sasnio woocommerce-js pxl-redux-page body-default-font heading-default-font bd-px-header--transparent site-color-gradient woocommerce-layout-grid elementor-default elementor-kit-7 elementor-page elementor-page-17 e--ua-blink e--ua-chrome e--ua-webkit pxl-header-sticky"
data-elementor-device-mode="laptop" style="overflow: auto;">
<div id="pxl-wapper" class="pxl-wapper">
   <div id="pxl-loadding" class="pxl-loader pxl-loader-gradient style-app is-loaded">
       <div class="pxl-loader-effect">
           <div class="pxl-circle-1"></div>
           <div class="pxl-circle-2"></div>
       </div>
   </div>
         @include('frontend.includes.navbar')
         @include('frontend.components.hero')
         @include('frontend.components.services')
         @include('frontend.components.footer')
      </div>
    <script>
        window.RS_MODULES = window.RS_MODULES || {};
        window.RS_MODULES.modules = window.RS_MODULES.modules || {};
        window.RS_MODULES.waiting = window.RS_MODULES.waiting || [];
        window.RS_MODULES.defered = true;
        window.RS_MODULES.moduleWaiting = window.RS_MODULES.moduleWaiting || {};
        window.RS_MODULES.type = 'compiled';
    </script>
    <script>
        (function() {
            function maybePrefixUrlField() {
                const value = this.value.trim()
                if (value !== '' && value.indexOf('http') !== 0) {
                    this.value = 'http://' + value
                }
            }
            const urlFields = document.querySelectorAll('.mc4wp-form input[type="url"]')
            for (let j = 0; j < urlFields.length; j++) {
                urlFields[j].addEventListener('blur', maybePrefixUrlField)
            }
        })();
    </script>
    <script type="text/javascript">
        (function() {
            var c = document.body.className;
            c = c.replace(/woocommerce-no-js/, 'woocommerce-js');
            document.body.className = c;
        })();
    </script>
    <link rel="stylesheet" id="elementor-post-3168-css"
        href="{{asset('frontend/assets/css/post-3168.css')}}" type="text/css"
        media="all">
    <link rel="stylesheet" id="elementor-post-3530-css"
        href="{{asset('frontend/assets/css/post-3530.css')}}" type="text/css"
        media="all">
    <link rel="stylesheet" id="rs-plugin-settings-css"
        href="{{asset('frontend/assets/css/rs6.css')}}" type="text/css" media="all">
    <style id="rs-plugin-settings-inline-css" type="text/css">
        #rs-demo-id {}
    </style>
    <script type="text/javascript" src="{{asset('frontend/assets/js/swv.min.js')}}"
        id="swv-js"></script>
    <script type="text/javascript" id="contact-form-7-js-extra">
        /* <![CDATA[ */
        var wpcf7 = {
            "api": {
                "root": "https:\/\/demo.bravisthemes.com\/sasnio\/wp-json\/",
                "namespace": "contact-form-7\/v1"
            }
        };
        /* ]]> */
    </script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/contact-form-7.min.js')}}"
        id="contact-form-7-js"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/rbtools.min.js')}}" defer="" async=""
        id="tp-tools-js"></script>
    <script type="text/javascript" src="{{asset('frontend/assets/js/rs6.min.js')}}"
        defer="" async="" id="revmin-js"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/sasnio-elementor-edit.min.js')}}"
        id="sasnio-elementor-edit-js"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/sasnio-parallax-scroll.min.js')}}"
        id="sasnio-parallax-scroll-js"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/sasnio-elementor.min.js')}}"
        id="sasnio-elementor-js"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/split-text.min.js')}}"
        id="split-text-lib-js"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/scroll-trigger.min.js')}}"
        id="scroll-trigger-lib-js"></script>
    <script type="text/javascript" src="{{asset('frontend/assets/js/gsap.min.js')}}"
        id="gsap-lib-js"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/scroll-smoother.min.js')}}"
        id="scroll-smoother-lib-js"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/curtains.min.js')}}" id="curtains-list-js">
    </script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/magnific-popup.min.js')}}"
        id="magnific-popup-js"></script>
    <script type="text/javascript" src="{{asset('frontend/assets/js/wow.min.js')}}"
        id="wow-animate-js"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/nice-select.min.js')}}" id="nice-select-js">
    </script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/pxl-woocommerce.min.js')}}"
        id="pxl-woocommerce-js"></script>
    <script type="text/javascript" id="pxl-main-js-extra">
        /* <![CDATA[ */
        var main_data = {
            "ajax_url": "https:\/\/demo.bravisthemes.com\/sasnio\/wp-admin\/admin-ajax.php"
        };
        /* ]]> */
    </script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/pxl-main.min.js')}}" id="pxl-main-js">
    </script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/imagesloaded.min.js')}}"
        id="imagesloaded-js"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/isotope.pkgd.min.js')}}" id="isotope-js">
    </script>
    <script type="text/javascript" id="pxl-post-grid-js-extra">
        /* <![CDATA[ */
        var main_data = {
            "ajax_url": "https:\/\/demo.bravisthemes.com\/sasnio\/wp-admin\/admin-ajax.php"
        };
        /* ]]> */
    </script>
    <script type="text/javascript" src="{{asset('frontend/assets/js/grid.js')}}"
        id="pxl-post-grid-js"></script>
    <script type="text/javascript" src="{{asset('frontend/assets/js/tilt.min.js')}}"
        id="tilt-js"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/tweenmax.min.js')}}" id="pxl-tweenmax-js">
    </script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/pxl-effects.js')}}" id="sasnio-effects-js">
    </script>
    <script type="text/javascript" src="{{asset('frontend/assets/js/swiper.min.js')}}"
        id="swiper-js"></script>
    <script type="text/javascript" src="{{asset('frontend/assets/js/carousel.js')}}"
        id="pxl-swiper-js')}}"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/waypoints.min.js')}}"
        id="elementor-waypoints-js"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/jquery-numerator.min.js')}}"
        id="jquery-numerator-js"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/counter.min.js')}}" id="pxl-counter-js">
    </script>
    <script type="text/javascript" src="{{asset('frontend/assets/js/counter.js')}}"
        id="sasnio-counter-js"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/parallax-move-mouse.js')}}"
        id="pxl-parallax-move-mouse-js"></script>
    <script type="text/javascript" src="{{asset('frontend/assets/js/accordion.js')}}"
        id="sasnio-accordion-js"></script>
    <script type="text/javascript" src="{{asset('frontend/assets/js/cookie.js')}}"
        id="pxl-cookie-js"></script>
    <script type="text/javascript" defer=""
        src="{{asset('frontend/assets/js/forms.js')}}" id="mc4wp-forms-api-js">
    </script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/webpack.runtime.min.js')}}"
        id="elementor-webpack-runtime-js"></script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/frontend-modules.min.js')}}"
        id="elementor-frontend-modules-js"></script>
    <script type="text/javascript" src="{{asset('frontend/assets/js/core.min.js')}}"
        id="jquery-ui-core-js"></script>
    <script type="text/javascript" id="elementor-frontend-js-before">
        /* <![CDATA[ */
        var elementorFrontendConfig = {
            "environmentMode": {
                "edit": false,
                "wpPreview": false,
                "isScriptDebug": false
            },
            "i18n": {
                "shareOnFacebook": "Share on Facebook",
                "shareOnTwitter": "Share on Twitter",
                "pinIt": "Pin it",
                "download": "Download",
                "downloadImage": "Download image",
                "fullscreen": "Fullscreen",
                "zoom": "Zoom",
                "share": "Share",
                "playVideo": "Play Video",
                "previous": "Previous",
                "next": "Next",
                "close": "Close",
                "a11yCarouselWrapperAriaLabel": "Carousel | Horizontal scrolling: Arrow Left & Right",
                "a11yCarouselPrevSlideMessage": "Previous slide",
                "a11yCarouselNextSlideMessage": "Next slide",
                "a11yCarouselFirstSlideMessage": "This is the first slide",
                "a11yCarouselLastSlideMessage": "This is the last slide",
                "a11yCarouselPaginationBulletMessage": "Go to slide"
            },
            "is_rtl": false,
            "breakpoints": {
                "xs": 0,
                "sm": 480,
                "md": 768,
                "lg": 1025,
                "xl": 1440,
                "xxl": 1600
            },
            "responsive": {
                "breakpoints": {
                    "mobile": {
                        "label": "Mobile Portrait",
                        "value": 767,
                        "default_value": 767,
                        "direction": "max",
                        "is_enabled": true
                    },
                    "mobile_extra": {
                        "label": "Mobile Landscape",
                        "value": 880,
                        "default_value": 880,
                        "direction": "max",
                        "is_enabled": true
                    },
                    "tablet": {
                        "label": "Tablet Portrait",
                        "value": 1024,
                        "default_value": 1024,
                        "direction": "max",
                        "is_enabled": true
                    },
                    "tablet_extra": {
                        "label": "Tablet Landscape",
                        "value": 1200,
                        "default_value": 1200,
                        "direction": "max",
                        "is_enabled": true
                    },
                    "laptop": {
                        "label": "Laptop",
                        "value": 1366,
                        "default_value": 1366,
                        "direction": "max",
                        "is_enabled": true
                    },
                    "widescreen": {
                        "label": "Widescreen",
                        "value": 2400,
                        "default_value": 2400,
                        "direction": "min",
                        "is_enabled": false
                    }
                }
            },
            "version": "3.15.3",
            "is_static": false,
            "experimentalFeatures": {
                "e_dom_optimization": true,
                "e_optimized_assets_loading": true,
                "e_optimized_css_loading": true,
                "additional_custom_breakpoints": true,
                "e_swiper_latest": true,
                "landing-pages": true,
                "e_global_styleguide": true
            },
            "urls": {
                "assets": "https:\/\/demo.bravisthemes.com\/sasnio\/wp-content\/plugins\/elementor\/assets\/"
            },
            "swiperClass": "swiper",
            "settings": {
                "page": [],
                "editorPreferences": []
            },
            "kit": {
                "active_breakpoints": ["viewport_mobile", "viewport_mobile_extra", "viewport_tablet",
                    "viewport_tablet_extra", "viewport_laptop"
                ],
                "global_image_lightbox": "yes",
                "lightbox_enable_counter": "yes",
                "lightbox_enable_fullscreen": "yes",
                "lightbox_enable_zoom": "yes",
                "lightbox_enable_share": "yes",
                "lightbox_title_src": "title",
                "lightbox_description_src": "description"
            },
            "post": {
                "id": 3484,
                "title": "Sasnio%20%E2%80%93%20Saas%20Software%20%26%20Startup%20WordPress%20Theme",
                "excerpt": "",
                "featuredImage": false
            }
        };
        /* ]]> */
    </script>
    <script type="text/javascript"
        src="{{asset('frontend/assets/js/frontend.min.js')}}"
        id="elementor-frontend-js"></script>
</body>
@if ($set_cookie['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif

</html>
