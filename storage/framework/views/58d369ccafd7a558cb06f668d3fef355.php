<?php
    // $logo=asset(Storage::url('uploads/logo'));
    $logo = \App\Models\Utility::get_file('uploads/logo/');
    $setting = App\Models\Utility::settings();
    $set_cookie = App\Models\Utility::cookie_settings();
    $langSetting = App\Models\Utility::langSetting();
?>
<!DOCTYPE html>
<html lang="en" dir="<?php echo e($setting['SITE_RTL'] == 'on' ? 'rtl' : ''); ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo e(Utility::getValByName('title_text') ? Utility::getValByName('title_text') : config('app.name', 'vCardGo SaaS')); ?>

    </title>

    <link rel="icon" href="<?php echo e($logo . '/2_favicon.png'); ?>" type="image/x-icon" />
    <?php echo $__env->make('frontend.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('css'); ?>
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
   <?php echo $__env->yieldContent('content'); ?>
        
      </div>
      <?php echo $__env->make('frontend.includes.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>
<?php if($set_cookie['enable_cookie'] == 'on'): ?>
    <?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

</html>
<?php /**PATH D:\Projects\vcardgo-saas\resources\views/frontend/layouts/front-layout.blade.php ENDPATH**/ ?>