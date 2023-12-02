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
    @yield('css')
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
   @yield('content')
        
      </div>
      @include('frontend.includes.scripts')
    </body>
@if ($set_cookie['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif

</html>
