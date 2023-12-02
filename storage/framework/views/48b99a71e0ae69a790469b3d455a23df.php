<?php
    // get theme color
    $setting = App\Models\Utility::frontendSettings();
    $layout_setting = App\Models\Utility::getLayoutsSetting();
    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';
    $company_logo = \App\Models\Utility::GetLogo();

    $logo = \App\Models\Utility::get_file('uploads/logo/');

    $company_favicon = Utility::getValByName('company_favicon');
    $set_cookie = App\Models\Utility::cookie_settings();
    $lang = app()->getLocale('lang');
    if ($lang == 'ar' || $lang == 'he') {
        $setting['SITE_RTL'] = 'on';
    }
    $langSetting = App\Models\Utility::langSetting();
?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e($setting['SITE_RTL'] == 'on' ? 'rtl' : ''); ?>">

<head>
    <title>
        <?php echo e(Utility::getValByName('title_text') ? Utility::getValByName('title_text') : config('app.name', 'vCardGo SaaS')); ?>

        - <?php echo $__env->yieldContent('page-title'); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,  initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="Rajodiya Infotech" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Favicon -->

    <link rel="icon" href="<?php echo e($logo . '/2_favicon.png'); ?>" type="image/x-icon" />
    <!-- font css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('custom/css/custom.css')); ?>">

    <?php if($setting['cust_darklayout'] == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>">
    <?php else: ?>
        <?php if($setting['SITE_RTL'] == 'on'): ?>
            <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>" id="main-style-link">
        <?php else: ?>
            <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="main-style-link">
        <?php endif; ?>
    <?php endif; ?>

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('custom/css/custom.css')); ?>">

    
    <?php if($setting['SITE_RTL'] == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom-auth-rtl.css')); ?>" id="main-style-link">
    <?php else: ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom-auth.css')); ?>" id="main-style-link">
        <?php endif; ?>
    
    <?php if($setting['cust_darklayout'] == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom-dark.css')); ?>" id="main-style-link">
    <?php endif; ?>

    <?php echo $__env->yieldPushContent('css-page'); ?>

    <style type="text/css">
        img.navbar-brand-img {
            width: 245px;
            height: 61px;
        }
    </style>
</head>


<body class="<?php echo e($color); ?>">

    <div class="custom-login">
        <div class="login-bg-img">
            <img src="<?php echo e(asset('assets/images/auth/' . $color . '.svg')); ?>" class="login-bg-1">
            <img src="<?php echo e(asset('assets/images/auth/common.svg')); ?>" class="login-bg-2">
        </div>
        <div class="bg-login bg-primary"></div>
        <div class="custom-login-inner">
            <header class="dash-header">
                <nav class="navbar navbar-expand-md default">
                    <div class="container-fluid pe-2">
                        <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                            <?php if($setting['cust_darklayout'] == 'on'): ?>
                                <img class="logo img-fluid"
                                    src="<?php echo e($logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo_1.jpg') . '?' . time()); ?>"
                                    alt="" loading="lazy" />
                            <?php else: ?>
                                <img class="logo"
                                    src="<?php echo e($logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo_2.jpg') . '?' . time()); ?>"
                                    alt="" loading="lazy" />
                            <?php endif; ?>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarlogin">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarlogin">
                            <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#"><?php echo e(__('About Us')); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><?php echo e(__('Terms and Conditions')); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><?php echo e(__('Privacy Policy')); ?></a>
                                </li>
                                <?php echo $__env->yieldContent('language-bar'); ?>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <main class="custom-wrapper">
                <div class="custom-row">              
                    <div class="card">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
            </main>
            <footer>

                <div class="auth-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <span>&copy; <?php echo e(date('Y')); ?>&nbsp;
                                    <?php echo e(isset($langSetting['footer_text']) ? $langSetting['footer_text'] : config('app.name', 'vCardGo-SaaS')); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
    </div>

    <!-- Required Js -->
    <script src="<?php echo e(asset('assets/js/vendor-all.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('custom/libs/jquery/dist/jquery.min.js')); ?>"></script>
    <script>
        <?php if(isset($setting['cust_darklayout']) && $setting['cust_darklayout'] == 'on'): ?>
            document.addEventListener('DOMContentLoaded', (event) => {
                const recaptcha = document.querySelector('.g-recaptcha');
                recaptcha.setAttribute("data-theme", "dark");
            });
        <?php endif; ?>
    </script>
    <script>
        feather.replace();
    </script>
    <?php echo $__env->yieldPushContent('custom-scripts'); ?>

</body>
<?php if($set_cookie['enable_cookie'] == 'on'): ?>
    <?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

</html>
<?php /**PATH D:\Projects\vcardgo-saas\resources\views/layouts/auth.blade.php ENDPATH**/ ?>