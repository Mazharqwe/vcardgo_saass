<?php
 $languages = App\Models\Utility::languages();
    $logo = asset(Storage::url('uploads/logo/'));
    $company_logo = Utility::getValByName('company_logo');
    $settings = App\Models\Utility::settings(); 
    $recaptcha = \App\Models\Utility::setCaptchaConfig();
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Register')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('language-bar'); ?>
    <div class="lang-dropdown-only-desk">
        <li class="dropdown dash-h-item drp-language">
            <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="drp-text"> <?php echo e($languages[$lang]); ?>

                </span>
            </a>
            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('register',$code)); ?>"tabindex="0"
                class="dropdown-item <?php echo e($code == $lang ? 'active' : ''); ?> ">
                <span><?php echo e(Str::ucFirst($language)); ?></span>
            </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </li>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('custom-scripts'); ?>
<?php if($settings['RECAPTCHA_MODULE'] == 'yes'): ?>
        <?php echo NoCaptcha::renderJs(); ?>

    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card-body">
        <div>
            <h2 class="mb-3 f-w-600"><?php echo e(__('Register')); ?></h2>
        </div>
        <?php echo e(Form::open(['route' => 'register', 'method' => 'post', 'id' => 'loginForm'])); ?>

        <div class="custom-login-form">
            <?php if(session('status')): ?>
                <div class="mb-4 font-medium text-lg text-green-600 text-danger">
                    <?php echo e(__('Email SMTP settings does not configured so please contact to your site admin.')); ?>

                </div>
            <?php endif; ?>
            <div class="form-group mb-3">
                <label class="form-label"><?php echo e(__('Full Name')); ?></label>
                <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Your Name')])); ?>

                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error invalid-name text-danger" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group mb-3">
                <label class="form-label"><?php echo e(__('Email')); ?></label>
                <?php echo e(Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Enter Your Email')])); ?>

                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error invalid-email text-danger" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group mb-3">
                <label class="form-label"><?php echo e(__('Password')); ?></label>
                <?php echo e(Form::password('password', ['class' => 'form-control', 'id' => 'input-password', 'placeholder' => __('Enter Your Password')])); ?>


                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error invalid-password text-danger" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="form-group">
                <label class="form-label"><?php echo e(__('Confirm Password')); ?></label>
                <?php echo e(Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'confirm-input-password', 'placeholder' => __('Confirm Your Password')])); ?>


                <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error invalid-password_confirmation text-danger" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <?php if($settings['RECAPTCHA_MODULE'] == 'yes'): ?>
                <div class="form-group col-lg-12 col-md-12 mt-3">
                    <?php echo NoCaptcha::display($settings['cust_darklayout']=='on' ? ['data-theme' => 'dark'] : []); ?>

                    <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="small text-danger" role="alert">
                            <strong><?php echo e($message); ?></strong>
                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            <?php endif; ?>
            <div class="d-grid">
                <button class="btn btn-primary btn-block mt-2"><?php echo e(__('Register')); ?></button>
            </div>
            <?php if(Utility::getValByName('signup_button') == 'on'): ?>
                <p class="my-4 text-center"><?php echo e(__('Already have an account?')); ?>

                    <a href="<?php echo e(route('login')); ?>" tabindex="0"><?php echo e(__('Login')); ?></a>
                </p>
            <?php endif; ?>
        </div>
        <?php echo e(Form::close()); ?>


    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Projects\vcardgo-saas\resources\views/auth/register.blade.php ENDPATH**/ ?>