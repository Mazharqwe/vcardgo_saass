<?php
    $dir = asset(Storage::url('uploads/plan'));
    $admin_payment_setting = Utility::getAdminPaymentSetting();
?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Plans')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <?php echo e(__('Manage Plan')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create plan')): ?>
        <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end"
            data-bs-placement="top">
            <?php if(App\Models\Utility::getPaymentIsOn() && \Auth::user()->type == 'super admin'): ?>
                <a href="#" data-size="lg" data-url="<?php echo e(route('plans.create')); ?>" data-ajax-popup="true"
                    data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create New Plan')); ?>"
                    class="btn btn-sm btn-primary">
                    <i class="ti ti-plus"></i>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Plans')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="plan_card">
                    <div class="card price-card price-1 wow animate__fadeInUp" data-wow-delay="0.2s"
                        style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                        <div class="card-body">
                            <span class="price-badge bg-primary"><?php echo e($plan->name); ?></span>
                            <?php if(\Auth::user()->type == 'company' && \Auth::user()->plan == $plan->id): ?>
                                <div class="d-flex flex-row-reverse m-0 p-0 ">
                                    <span class="d-flex align-items-center ">
                                        <i class="f-10 lh-1 fas fa-circle text-success"></i>
                                        <span class="ms-2"><?php echo e(__('Active')); ?></span>
                                    </span>
                                </div>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type == 'super admin'): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit plan')): ?>
                                    <div class="col-12 text-end">
                                        <div class="action-btn bg-primary ms-2">
                                            <a data-url="<?php echo e(route('plans.edit', $plan->id)); ?>" data-size="lg"
                                                data-ajax-popup="true" data-bs-placement="top" data-bs-toggle="tooltip"
                                                data-bs-original-title="<?php echo e(__('Edit')); ?>" data-title="<?php echo e(__('Edit Plan')); ?>"
                                                data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"
                                                class="mx-3 btn btn-sm d-inline-flex align-items-center">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <span class="mb-4 p-price m"><span
                                    style="font-weight: 600"><?php echo e(!empty($admin_payment_setting['CURRENCY_SYMBOL']) ? $admin_payment_setting['CURRENCY_SYMBOL'] : '$'); ?><?php echo e($plan->price); ?></span><small
                                    class="text-sm"><?php echo e(__('/ Duration : ') . __(ucfirst($plan->duration))); ?></small></span>
                            <p class="mb-0">
                                <?php echo e($plan->description); ?>

                            </p>

                            
                            <ul class="list-unstyled my-4">
                                <li>
                                    <span class="theme-avtar">
                                        <i class="text-primary ti ti-circle-plus"></i></span>
                                    <?php echo e(count($plan->getThemes())); ?> <?php echo e(__('Themes')); ?>

                                </li>
                                <li>
                                    <span class="theme-avtar">
                                        <i class="text-primary ti ti-circle-plus"></i></span>
                                    <?php echo e($plan->business == '-1' ? 'Unlimited' : $plan->business); ?> <?php echo e(__('Business')); ?>

                                </li>
                                <li>
                                    <span class="theme-avtar">
                                        <i class="text-primary ti ti-circle-plus"></i></span>
                                    <?php echo e($plan->max_users == '-1' ? 'Unlimited' : $plan->max_users); ?> <?php echo e(__('Users')); ?>

                                </li>
                                <?php if($plan->enable_custdomain == 'on'): ?>
                                    <li>
                                        <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>
                                        <?php echo e(__('Custom Domain')); ?>

                                    </li>
                                <?php else: ?>
                                    <li>

                                        <span class="theme-avtar">
                                            <i data-feather="x" class="text-danger"></i></span>
                                        <span class="text-danger"> <?php echo e(__('Custom Domain')); ?></span>

                                    </li>
                                <?php endif; ?>
                                <?php if($plan->enable_custsubdomain == 'on'): ?>
                                    <li>
                                        <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>
                                        <?php echo e(__('Sub Domain')); ?>

                                    </li>
                                <?php else: ?>
                                    <li>
                                        <span class="theme-avtar">
                                            <i data-feather="x" class="text-danger"></i></span>
                                        <span class="text-danger"> <?php echo e(__('Sub Domain')); ?></span>

                                    </li>
                                <?php endif; ?>
                                <?php if($plan->enable_branding == 'on'): ?>
                                    <li>
                                        <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>
                                        <?php echo e(__('Branding')); ?>

                                    </li>
                                <?php else: ?>
                                    <li>
                                        <span class="theme-avtar">
                                            <i data-feather="x" class="text-danger"></i></span>
                                        <span class="text-danger"><?php echo e(__('Branding')); ?></span>
                                    </li>
                                <?php endif; ?>
                                <?php if($plan->enable_qr_code == 'on'): ?>
                                    <li>
                                        <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>
                                        <?php echo e(__('QR Code')); ?>

                                    </li>
                                <?php else: ?>
                                    <li>
                                        <span class="theme-avtar">
                                            <i data-feather="x" class="text-danger"></i></span>
                                        <span class="text-danger"><?php echo e(__('QR Code')); ?></span>
                                    </li>
                                <?php endif; ?>

                                <?php if($plan->pwa_business == 'on'): ?>
                                    <li>
                                        <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>
                                        <?php echo e(__('Progressive Web App (PWA)')); ?>

                                    </li>
                                <?php else: ?>
                                    <li>
                                        <span class="theme-avtar">
                                            <i data-feather="x" class="text-danger"></i></span>
                                        <span class="text-danger"><?php echo e(__('Progressive Web App (PWA)')); ?></span>
                                    </li>
                                <?php endif; ?>
                                <?php if($plan->enable_chatgpt == 'on'): ?>
                                    <li>
                                        <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>
                                        <?php echo e(__('Chatgpt')); ?>

                                    </li>
                                <?php else: ?>
                                    <li>
                                        <span class="theme-avtar">
                                            <i data-feather="x" class="text-danger"></i></span>
                                        <span class="text-danger"><?php echo e(__('Chatgpt')); ?></span>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <span class="theme-avtar">
                                        <i class="text-primary ti ti-circle-plus"></i>
                                    </span>
                                    <?php echo e($plan->storage_limit); ?> <?php echo e(__('MB Storage Limit')); ?>

                                </li>
                            </ul>

                            <?php if(\Auth::user()->type == 'company' && \Auth::user()->plan == $plan->id): ?>
                                <?php if($plan->duration !== 'Lifetime'): ?>
                                    <?php if(
                                        \Auth::user()->type == 'company' &&
                                            (empty(\Auth::user()->plan_expire_date) || \Auth::user()->plan_expire_date < date('Y-m-d'))): ?>
                                        <p class="plan-expired text-dark mb-0">
                                            <?php echo e(__('Plan Expired')); ?>

                                        </p>
                                    <?php else: ?>
                                        <p class="plan-expired text-dark mb-0">
                                            <?php echo e(__('Plan Expired : ')); ?>

                                            <?php echo e(!empty(\Auth::user()->plan_expire_date) ? date('d-m-Y', strtotime(\Auth::user()->plan_expire_date)) : 'Lifetime'); ?>

                                        </p>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p class="plan-expired text-dark mb-0">
                                        <?php echo e(__('Plan Expired : Lifetime')); ?>

                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="row d-flex justify-content-between">
                                <div class="col-8">
                                    <?php if(
                                        \Auth::user()->type == 'company' &&
                                            (empty(\Auth::user()->plan_expire_date) || \Auth::user()->plan_expire_date < date('Y-m-d'))): ?>
                                        <?php if(App\Models\Utility::getPaymentIsOn()): ?>
                                            <?php if($plan->id != \Auth::user()->plan && \Auth::user()->type == 'company'): ?>
                                                <?php if($plan->price > 0): ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('buy plan')): ?>
                                                        <div class="d-grid text-center">
                                                            <a href="<?php echo e(route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id))); ?>"
                                                                class="btn  btn-primary d-flex justify-content-center align-items-center "><?php echo e(__('Subscribe')); ?>

                                                                <i class="fas fa-arrow-right m-1"></i></a>
                                                            <p></p>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if(App\Models\Utility::getPaymentIsOn()): ?>
                                            <?php if($plan->id != \Auth::user()->plan && \Auth::user()->type == 'company'): ?>
                                                <?php if($plan->price > 0): ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('buy plan')): ?>
                                                        <div class="d-grid text-center">
                                                            <a href="<?php echo e(route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id))); ?>"
                                                                class="btn btn-primary btn-md d-flex justify-content-center align-items-center"><?php echo e(__('Subscribe')); ?>

                                                                <i class="ti ti-arrow-right ms-1"></i></a>
                                                            <p></p>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <?php if(\Auth::user()->type != 'super admin' && \Auth::user()->plan != $plan->id): ?>
                                    <?php if($plan->id != 1): ?>
                                        <?php if(\Auth::user()->requested_plan != $plan->id): ?>
                                            <div class="col-4">
                                                <a href="<?php echo e(route('send.request', [\Illuminate\Support\Facades\Crypt::encrypt($plan->id)])); ?>"
                                                    class="btn btn-primary btn-icon btn-md"
                                                    data-title="<?php echo e(__('Send Request')); ?>" data-bs-placement="top"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-original-title="<?php echo e(__('Send Request')); ?>"
                                                    data-toggle="tooltip">
                                                    <span class="btn-inner--icon"><i
                                                            class="ti ti-arrow-forward-up"></i></span>
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <div class="col-4">
                                                <a href="<?php echo e(route('request.cancel', \Auth::user()->id)); ?>"
                                                    class="btn btn-icon  btn-danger btn-md" data-bs-placement="top"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-original-title="<?php echo e(__('Cancel Request')); ?>">
                                                    <span class="btn-inner--icon"><i class="ti ti-x"></i></span>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Projects\vcardgo-saas\resources\views/plan/index.blade.php ENDPATH**/ ?>