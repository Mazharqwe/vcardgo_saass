<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Settings')); ?>

<?php $__env->stopSection(); ?>
<?php
    $logo = \App\Models\Utility::get_file('uploads/logo/');
    $lang = \App\Models\Utility::getValByName('company_default_language');
    $logo_img = \App\Models\Utility::getValByName('company_logo');

    $logo_light_img = \App\Models\Utility::getValByName('company_logo_light');

    $company_favicon = \App\Models\Utility::getValByName('company_favicon');

    $setting = App\Models\Utility::settings();

?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Settings')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Settings')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>
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
                    $('#main-style-link').attr('href', '<?php echo e(env('APP_URL')); ?>' +
                    '/public/assets/css/style-dark.css');
                    $('.dash-sidebar .main-logo a img').attr('src', '<?php echo e($logo . $logo_light_img); ?>');
                } else {
                    $('#main-style-link').attr('href', '<?php echo e(env('APP_URL')); ?>' + '/public/assets/css/style.css');
                    $('.dash-sidebar .main-logo a img').attr('src', '<?php echo e($logo . $logo_img); ?>');
                }
            });
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
                    _token: '<?php echo e(csrf_token()); ?>',
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
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xl-12 sticky-top">
                        <div class="card ">
                            <div class="list-group list-group-flush" id="useradd-sidenav">
                                <div class="row">
                                    <div class="col">
                                        <a href="#site-settings"
                                            class="list-group-item list-group-item-action active border-0">
                                            <?php echo e(__('Site Settings')); ?>

                                            
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="#Google_Setting" class="list-group-item list-group-item-action border-0">
                                            <?php echo e(__('Google Calendar Settings')); ?>

                                            
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="#Webhook_Setting" class="list-group-item list-group-item-action border-0">
                                            <?php echo e(__('Webhook Settings')); ?>

                                            
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="#email-settings" class="list-group-item list-group-item-action border-0">
                                            <?php echo e(__('Email Settings')); ?>

                                            
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-12">
                        <div id="site-settings" class="card">
                            <?php echo e(Form::model($settings, ['route' => 'company.settings.store', 'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                            <div class="card-header">
                                <h5><?php echo e(__('Site Settings')); ?></h5>
                                <small class="text-muted"><?php echo e(__('Edit your site details')); ?></small>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header dark-logo-header">
                                                <h5><?php echo e(__('Logo Dark')); ?></h5>
                                            </div>
                                            <div class="card-body min-250">
                                                <div class=" setting-card">
                                                    <div class="logo-content mt-4">

                                                        <a href="<?php echo e($logo . (isset($logo_img) && !empty($logo_img) ? $logo_img : 'logo-dark.png')); ?>"
                                                            target="_blank">
                                                            <img id="blah" alt="your image"
                                                                src="<?php echo e($logo . (isset($logo_img) && !empty($logo_img) ? $logo_img : 'logo-dark.png') . '?' . time()); ?>"
                                                                width="150px" class="big-logo">
                                                        </a>

                                                    </div>
                                                    <div class="choose-files mt-5">
                                                        <label for="company_logo">
                                                            <div class="mt-4 bg-primary company_logo_update"> <i
                                                                    class="ti ti-upload px-1"></i><?php echo e(__('Select image')); ?>

                                                            </div>
                                                            <input type="file" class="form-control file"
                                                                name="company_logo" id="company_logo"
                                                                data-filename="edit-logo"
                                                                onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                                        </label>
                                                    </div>
                                                    <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-company_logo text-xs text-danger"
                                                            role="alert"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6">
                                        <div class="card">
                                            <div class="card-header light-logo-header">
                                                <h5><?php echo e(__('Logo Light')); ?></h5>
                                            </div>
                                            <div class="card-body min-250">
                                                <div class=" setting-card">
                                                    <div class="logo-content mt-4">

                                                        <a href="<?php echo e($logo . (isset($logo_light_img) && !empty($logo_light_img) ? $logo_light_img : 'company_logo_light.png')); ?>"
                                                            target="_blank">
                                                            <img id="blah1" alt="your image"
                                                                src="<?php echo e($logo . (isset($logo_light_img) && !empty($logo_light_img) ? $logo_light_img : 'company_logo_light.png') . '?' . time()); ?>"
                                                                width="150px" class="big-logo img_setting">
                                                        </a>
                                                    </div>
                                                    <div class="choose-files mt-5">
                                                        <label for="logo_light">
                                                            <div class="mt-4 bg-primary company_favicon_update"> <i
                                                                    class="ti ti-upload px-1"></i><?php echo e(__('Select image')); ?>

                                                            </div>
                                                            <input type="file" class="form-control file"
                                                                name="company_logo_light" id="logo_light"
                                                                data-filename="logo_light_update"
                                                                onchange="document.getElementById('blah1').src = window.URL.createObjectURL(this.files[0])">
                                                        </label>
                                                    </div>
                                                    <?php $__errorArgs = ['logo-light'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-company_favicon text-xs text-danger"
                                                            role="alert"><?php echo e($message); ?></span>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-md-6 ">
                                        <div class="card">
                                            <div class="card-header favicon-card-header">
                                                <h5><?php echo e(__('Favicon')); ?></h5>
                                            </div>
                                            <div class="card-body min-250">
                                                <div class=" setting-card">
                                                    <div class=" logo-content mt-4">
                                                        <a href="<?php echo e($logo . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png')); ?>"
                                                            target="_blank">
                                                            <img id="blah2" alt="your image"
                                                                src="<?php echo e($logo . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png') . '?' . time()); ?>"
                                                                width="20%" class="img_setting">
                                                        </a>
                                                    </div>
                                                    <div class="choose-files mt-5">
                                                        <label for="company_favicon">
                                                            <div class="mt-3 bg-primary company_favicon_update "> <i
                                                                    class="ti ti-upload px-1"></i><?php echo e(__('Select image')); ?>

                                                            </div>
                                                            <input type="file" name="company_favicon"
                                                                id="company_favicon" class="form-control file"
                                                                data-filename="company_favicon_update"
                                                                onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])">


                                                            <!-- <input type="file" class="form-control file"  id="company_favicon" name="company_favicon"
                                                                    data-filename="company_favicon_update"> -->
                                                        </label>
                                                    </div>
                                                    <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="row">
                                                            <span class="invalid-logo" role="alert">
                                                                <strong class="text-danger"><?php echo e($message); ?></strong>
                                                            </span>
                                                        </div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-6 col-lg-4 col-sm-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('title_text', __('Title Text'), ['class' => 'form-label'])); ?>

                                                <?php echo e(Form::text('title_text', null, ['class' => 'form-control', 'placeholder' => __('Title Text')])); ?>

                                                <?php $__errorArgs = ['title_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-title_text" role="alert">
                                                        <strong class="text-danger"><?php echo e($message); ?></strong>
                                                    </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-4 col-sm-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('timezone', __('Timezone'), ['class' => 'form-label'])); ?>

                                                <select type="text" name="timezone" class="form-control"
                                                    id="timezone">
                                                    <option value=""><?php echo e(__('Select Timezone')); ?></option>
                                                    <?php $__currentLoopData = $timezones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($k); ?>"
                                                            <?php echo e($setting['timezone'] == $k ? 'selected' : ''); ?>>
                                                            <?php echo e($timezone); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-sm-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('default_language', __('Default Language'), ['class' => 'form-label'])); ?>

                                                <div class="changeLanguage">
                                                    <select name="company_default_language" id="company_default_language"
                                                        class="form-control select2">
                                                        <?php $__currentLoopData = App\Models\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option <?php if($lang == $code): ?> selected <?php endif; ?>
                                                                value="<?php echo e($code); ?>">
                                                                <?php echo e(ucFirst($language)); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-sm-6">
                                            <div class="form-group">
                                                <?php echo e(Form::label('SITE_RTL', __('Enable RTL'), ['class' => 'form-label'])); ?>


                                                <div
                                                    class="d-flex align-items-center  justify-content-between border-0 borderleft">
                                                    <input type="checkbox" data-toggle="switchbutton"
                                                        data-onstyle="primary" name="SITE_RTL" id="SITE_RTL"
                                                        <?php echo e($setting['SITE_RTL'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                    <label class="form-label" for="SITE_RTL"></label>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="setting-card setting-logo-box p-3">
                                        <div class="row">
                                            <h4 class="small-title"><?php echo e(__('Theme Customizer')); ?></h4>
                                            <div class="col-lg-4 col-xl-4 col-md-4 my-auto">
                                                <h6 class="mt-2">
                                                    <i data-feather="credit-card"
                                                        class="me-2"></i><?php echo e(__('Primary Color Settings')); ?>

                                                </h6>
                                                <hr class="my-2" />
                                                <div class="theme-color themes-color">
                                                    <a href="#!"
                                                        class="<?php echo e($settings['color'] == 'theme-1' ? 'active_color' : ''); ?>"
                                                        data-value="theme-1" onclick="check_theme('theme-1')"></a>
                                                    <input type="radio" class="theme_color" name="color"
                                                        value="theme-1" style="display: none;">
                                                    <a href="#!"
                                                        class="<?php echo e($settings['color'] == 'theme-2' ? 'active_color' : ''); ?> "
                                                        data-value="theme-2" onclick="check_theme('theme-2')"></a>
                                                    <input type="radio" class="theme_color" name="color"
                                                        value="theme-2" style="display: none;">
                                                    <a href="#!"
                                                        class="<?php echo e($settings['color'] == 'theme-3' ? 'active_color' : ''); ?>"
                                                        data-value="theme-3" onclick="check_theme('theme-3')"></a>
                                                    <input type="radio" class="theme_color" name="color"
                                                        value="theme-3" style="display: none;">
                                                    <a href="#!"
                                                        class="<?php echo e($settings['color'] == 'theme-4' ? 'active_color' : ''); ?>"
                                                        data-value="theme-4" onclick="check_theme('theme-4')"></a>
                                                    <input type="radio" class="theme_color" name="color"
                                                        value="theme-4" style="display: none;">
                                                    <a href="#!"
                                                        class="<?php echo e($settings['color'] == 'theme-5' ? 'active_color' : ''); ?>"
                                                        data-value="theme-5" onclick="check_theme('theme-5')"></a>
                                                    <input type="radio" class="theme_color" name="color"
                                                        value="theme-5" style="display: none;">
                                                    <br>
                                                    <a href="#!"
                                                        class="<?php echo e($settings['color'] == 'theme-6' ? 'active_color' : ''); ?>"
                                                        data-value="theme-6" onclick="check_theme('theme-6')"></a>
                                                    <input type="radio" class="theme_color" name="color"
                                                        value="theme-6" style="display: none;">
                                                    <a href="#!"
                                                        class="<?php echo e($settings['color'] == 'theme-7' ? 'active_color' : ''); ?>"
                                                        data-value="theme-7" onclick="check_theme('theme-7')"></a>
                                                    <input type="radio" class="theme_color" name="color"
                                                        value="theme-7" style="display: none;">
                                                    <a href="#!"
                                                        class="<?php echo e($settings['color'] == 'theme-8' ? 'active_color' : ''); ?>"
                                                        data-value="theme-8" onclick="check_theme('theme-8')"></a>
                                                    <input type="radio" class="theme_color" name="color"
                                                        value="theme-8" style="display: none;">
                                                    <a href="#!"
                                                        class="<?php echo e($settings['color'] == 'theme-9' ? 'active_color' : ''); ?>"
                                                        data-value="theme-9" onclick="check_theme('theme-9')"></a>
                                                    <input type="radio" class="theme_color" name="color"
                                                        value="theme-9" style="display: none;">
                                                    <a href="#!"
                                                        class="<?php echo e($settings['color'] == 'theme-10' ? 'active_color' : ''); ?>"
                                                        data-value="theme-10" onclick="check_theme('theme-10')"></a>
                                                    <input type="radio" class="theme_color" name="color"
                                                        value="theme-10" style="display: none;">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-xl-4 col-md-4 my-auto mt-2">
                                                <h6>
                                                    <i data-feather="layout"
                                                        class="me-2"></i><?php echo e(__('Sidebar Settings')); ?>

                                                </h6>
                                                <hr class="my-2" />
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" class="form-check-input" id="cust-theme-bg"
                                                        name="cust_theme_bg"
                                                        <?php echo e(Utility::getValByName('cust_theme_bg') == 'on' ? 'checked' : ''); ?> />
                                                    <label class="form-check-label f-w-600 pl-1"
                                                        for="cust-theme-bg"><?php echo e(__('Transparent layout')); ?></label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-xl-4 col-md-4 my-auto mt-2">
                                                <h6>
                                                    <i data-feather="sun" class="me-2"></i><?php echo e(__('Layout Settings')); ?>

                                                </h6>
                                                <hr class="my-2" />
                                                <div class="form-check form-switch mt-2">
                                                    <input type="checkbox" class="form-check-input" id="cust-darklayout"
                                                        value="on"
                                                        name="cust_darklayout"<?php echo e(Utility::getValByName('cust_darklayout') == 'on' ? 'checked' : ''); ?> />
                                                    <label class="form-check-label f-w-600 pl-1"
                                                        for="cust-darklayout"><?php echo e(__('Dark Layout')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="col-sm-12">
                                            <div class="text-end">
                                                <input type="submit" value="<?php echo e(__('Save Changes')); ?>"
                                                    class="btn btn-lg btn-primary">
                                            </div><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                        <div id="Google_Setting" class="card text-white">
                            <?php echo e(Form::open(['url' => route('setting.GoogleCalendaSetting'), 'enctype' => 'multipart/form-data'])); ?>

                            <div class="card-header calender-card-header" style="min-height:70px">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="d-flex gap-2 mt-2">
                                            <div>
                                                <h5 class=""><?php echo e(__('Google Calendar Settings')); ?></h5>
                                            </div>
                                            <div>
                                                <small class="text-light font-weight-bold"><?php echo e(__('Edit your Google Calendar')); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 text-end">
                                        <input type="hidden" name="is_mercado_enabled" value="off">
                                        <input type="checkbox" name="Google_Calendar" id="Google_Calendar"
                                            data-toggle="switchbutton" data-onstyle="primary"
                                            <?php echo e(isset($settings['Google_Calendar']) && $settings['Google_Calendar'] == 'on' ? 'checked="checked"' : ''); ?>>
                                        <label class="custom-label form-label" for="Google_Calendar"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label h6"><?php echo e(__('Google calendar id')); ?></label>
                                            <input type="text" name="google_calender_id" class="form-control"
                                                placeholder="Enter Google calendar id"
                                                value="<?php echo e(!empty($settings['google_calender_id']) ? $settings['google_calender_id'] : ''); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label h6"><?php echo e(__('Google calendar json file')); ?></label>
                                        <input type="file" name="google_calender_json_file" id="json_file"
                                            class="form-control custom-input-file"
                                            placeholder="Enter Google calendar json file"
                                            value="<?php echo e(!empty($settings['google_calender_json_file']) ? $settings['google_calender_json_file'] : ''); ?>">
                                    </div>
                                </div>
                                <div class="card-footer border-0 p-1 text-end">
                                    <?php echo e(Form::submit(__('Save Changes'), ['class' => 'btn btn-lg btn-primary'])); ?>

                                </div>
                            </div>

                            <?php echo e(Form::close()); ?>

                        </div>
                        
                        <div id="Webhook_Setting" class="card text-white">
                            <div class="card-header webhook-card-header" style="min-height:70px">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class=""><?php echo e(__('Webhook Settings')); ?></h5>
                                            <div class="d-flex align-items-center">
                                                <a href="#" class="btn btn-sm btn-primary btn-icon m-1"
                                                    data-bs-target="#exampleModal"
                                                    data-url="<?php echo e(route('webhook.create')); ?>"
                                                    data-bs-whatever="<?php echo e(__('Create Webhook')); ?>" data-bs-toggle="modal">
                                                    <span class="text-white">
                                                        <i class="ti ti-plus text-white" data-bs-toggle="tooltip"
                                                            data-bs-original-title="<?php echo e(__('Create Webhook')); ?>"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th> <?php echo e(__('Module')); ?></th>
                                                <th> <?php echo e(__('Method')); ?></th>
                                                <th> <?php echo e(__('URL')); ?></th>
                                                <th class="text-right"> <?php echo e(__('Action')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $webhook; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $webhook_detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($webhook_detail->module); ?></td>
                                                    <td><?php echo e($webhook_detail->method); ?></td>
                                                    <td><?php echo e($webhook_detail->url); ?></td>
                                                    <td class="action">
                                                        <div class="action-btn bg-info  ms-2">
                                                            <a href="#"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-toggle="modal" data-target="#commonModal"
                                                                data-ajax-popup="true" data-size="md"
                                                                data-url="<?php echo e(route('webhook.edit', $webhook_detail->id)); ?>"
                                                                data-title="<?php echo e(__('Webhook Edit')); ?>"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-original-title="<?php echo e(__('Webhook Edit')); ?>"> <span
                                                                    class="text-white"><i
                                                                        class="ti ti-edit text-white    "></i></span></a>
                                                        </div>
                                                        <div class="action-btn bg-danger ms-2">
                                                            <a href="#"
                                                                class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                                data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                                data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                                data-confirm-yes="delete-form-<?php echo e($webhook_detail->id); ?>"
                                                                title="<?php echo e(__('Delete')); ?>" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"><span class="text-white"><i
                                                                        class="ti ti-trash"></i></span></a>
                                                        </div>
                                                        <?php echo Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['webhook.destroy', $webhook_detail->id],
                                                            'id' => 'delete-form-' . $webhook_detail->id,
                                                        ]); ?>

                                                        <?php echo Form::close(); ?>


                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>

                        </div>

                        
                        
                        <div id="email-settings" class="card">
                            <div class="card-header email-card-header" style="min-height:70px">
                                <div class="d-flex gap-2 mt-2">
                                    <div>
                                        <h5><?php echo e(__('Email Settings')); ?></h5>
                                    </div>
                                    <div>
                                        <small class="text-light"><?php echo e(__('Edit your email details')); ?></small>

                                    </div>
                                </div>

                            </div>
                            <?php echo e(Form::open(['route' => 'company.email.settings', 'method' => 'post'])); ?>

                            <div class="card-body">
                                <div class="row">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            <?php echo e(Form::label('mail_driver', __('Mail Driver'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::text('mail_driver', $settings['mail_driver'], ['class' => 'form-control', 'placeholder' => __('Enter Mail Driver')])); ?>

                                            <?php $__errorArgs = ['mail_driver'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_driver" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            <?php echo e(Form::label('mail_host', __('Mail Host'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::text('mail_host', $settings['mail_host'], ['class' => 'form-control ', 'placeholder' => __('Enter Mail Host')])); ?>

                                            <?php $__errorArgs = ['mail_host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_driver" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            <?php echo e(Form::label('mail_port', __('Mail Port'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::text('mail_port', $settings['mail_port'], ['class' => 'form-control', 'placeholder' => __('Enter Mail Port')])); ?>

                                            <?php $__errorArgs = ['mail_port'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_port" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            <?php echo e(Form::label('mail_username', __('Mail Username'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::text('mail_username', $settings['mail_username'], ['class' => 'form-control', 'placeholder' => __('Enter Mail Username')])); ?>

                                            <?php $__errorArgs = ['mail_username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_username" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            <?php echo e(Form::label('mail_password', __('Mail Password'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::text('mail_password', $settings['mail_password'], ['class' => 'form-control', 'placeholder' => __('Enter Mail Password')])); ?>

                                            <?php $__errorArgs = ['mail_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_password" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            <?php echo e(Form::label('mail_encryption', __('Mail Encryption'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::text('mail_encryption', $settings['mail_encryption'], ['class' => 'form-control', 'placeholder' => __('Enter Mail Encryption')])); ?>

                                            <?php $__errorArgs = ['mail_encryption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_encryption" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            <?php echo e(Form::label('mail_from_address', __('Mail From Address'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::text('mail_from_address', $settings['mail_from_address'], ['class' => 'form-control', 'placeholder' => __('Enter Mail From Address')])); ?>

                                            <?php $__errorArgs = ['mail_from_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_from_address" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                            <?php echo e(Form::label('mail_from_name', __('Mail From Name'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::text('mail_from_name', $settings['mail_from_name'], ['class' => 'form-control', 'placeholder' => __('Enter Mail From Name')])); ?>

                                            <?php $__errorArgs = ['mail_from_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_from_name" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-auto form-group">
                                        <a href="#" data-url="<?php echo e(route('test.mail')); ?>" data-ajax-popup="true"
                                            data-title="<?php echo e(__('Send Test Mail')); ?>"
                                            class="send_email btn m-r-10 mt-1 btn-primary">
                                            <?php echo e(__('Send Test Mail')); ?>

                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        <?php echo e(Form::submit(__('Save Changes'), ['class' => 'btn btn-print-invoice  btn-primary'])); ?>

                                    </div>
                                </div>

                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                        
                    </div>

                </div>

                <!-- [ sample-page ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('custom-scripts'); ?>
    <script>
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

        function check_theme(color_val) {

            $('.theme-color').prop('checked', false);
            $('input[value="' + color_val + '"]').prop('checked', true);
            $('#color_value').val(color_val);
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Projects\vcardgo-saas\resources\views/settings/index.blade.php ENDPATH**/ ?>