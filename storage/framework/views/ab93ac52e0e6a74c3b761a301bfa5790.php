<?php
    $cardLogo = \App\Models\Utility::get_file('card_logo/');
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Business')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Business')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Business')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create business')): ?>
        <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end"
            data-bs-placement="top">
            <a href="#" data-size="xl" data-url="<?php echo e(route('business.create')); ?>" data-ajax-popup="true"
                data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create New Business')); ?>"
                class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th><?php echo e(__('#')); ?></th>
                                <th><?php echo e(__('Business Logo')); ?></th>
                                <th><?php echo e(__('Businesses')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Generate Date')); ?></th>
                                <th class="text-end"><?php echo e(__('Operations')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $business; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="<?php echo e($val->admin_enable == 'off' ? 'row-disabled' : ''); ?>" >
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    <td>
                                        <div class="avatar">
                                            <img style="width: 55px;height: 55px;" class="rounded-circle "
                                                src="<?php echo e(isset($val->logo) && !empty($val->logo) ? $cardLogo . '/' . $val->logo : asset('custom/img/logo-placeholder-image-21.png')); ?>"
                                                alt="">
                                        </div>
                                    </td>

                                    <td class="">
                                        <a class=""
                                            href="<?php echo e(route('business.edit', $val->id)); ?>"><b><?php echo e(ucFirst($val->title)); ?></b></a>
                                    </td>
                                    <td><span
                                            class="badge fix_badge <?php if($val->status == 'locked'): ?> bg-danger <?php else: ?> bg-info <?php endif; ?> p-2 px-3 rounded"><?php echo e(ucFirst($val->status)); ?></span>
                                    </td>
                                    <?php
                                        $now = $val->created_at;
                                        $date = $now->format('Y-m-d');
                                        $time = $now->format('H:i:s');
                                    ?>
                                    <td><?php echo e($val->created_at); ?></td>

                                    <td class="text-end">
                                        <?php if($val->status != 'lock'): ?>
                                            <div class="action-btn bg-success  ms-2">
                                                <a href="#"
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center cp_link"
                                                    data-link="<?php echo e(url('/' . $val->slug)); ?>" data-bs-toggle="tooltip"
                                                    data-bs-original-title="<?php echo e(__('Click to copy card link')); ?>"> <span
                                                        class="text-white"> <i class="ti ti-copy text-white"></i></span></a>
                                            </div>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view analytics business')): ?>
                                                <div class="action-btn bg-info  ms-2">
                                                    <a href="<?php echo e(route('business.analytics', $val->id)); ?>"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="<?php echo e(__('Business Analytics')); ?>"> <span
                                                            class="text-white"> <i
                                                                class="ti ti-brand-google-analytics  text-white"></i></span></a>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('calendar appointment')): ?>
                                                <div class="action-btn bg-warning  ms-2">
                                                    <a href="<?php echo e(route('appointment.calendar', $val->id)); ?>"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="<?php echo e(__('Business Calender')); ?>"> <span
                                                            class="text-white"> <i
                                                                class="ti ti-calendar text-white"></i></span></a>
                                                </div>
                                            <?php endif; ?>
                                            <div class="action-btn bg-info  ms-2">
                                                <a href="<?php echo e(route('business.edit', $val->id)); ?>"
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-original-title="<?php echo e(__('Business Edit')); ?>"> <span
                                                        class="text-white"> <i class="ti ti-edit text-white"></i></span></a>
                                            </div>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage contact')): ?>
                                                <div class="action-btn bg-warning  ms-2">
                                                    <a href="<?php echo e(route('business.contacts.show', $val->id)); ?>"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="<?php echo e(__('Business Contacts')); ?>"> <span
                                                            class="text-white"> <i
                                                                class="ti ti-phone text-white"></i></span></a>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete business')): ?>
                                                <div class="action-btn bg-danger ms-2">
                                                    <a href="#"
                                                        class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        data-confirm="<?php echo e(__('Are You Sure?')); ?>"
                                                        data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>"
                                                        data-confirm-yes="delete-form-<?php echo e($val->id); ?>"
                                                        title="<?php echo e(__('Delete')); ?>" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"><span class="text-white"><i
                                                                class="ti ti-trash"></i></span></a>
                                                </div>
                                                <?php echo Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['business.destroy', $val->id],
                                                    'id' => 'delete-form-' . $val->id,
                                                ]); ?>

                                                <?php echo Form::close(); ?>

                                            <?php else: ?>
                                                <span class="edit-icon align-middle bg-gray"><i
                                                        class="fas fa-lock text-white"></i></span>
                                            <?php endif; ?>
                                            
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('custom-scripts'); ?>
    <script type="text/javascript">
        $('.cp_link').on('click', function() {
            var value = $(this).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            toastrs('<?php echo e(__('Success')); ?>', '<?php echo e(__('Link Copy on Clipboard')); ?>', 'success');
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Projects\vcardgo-saas\resources\views/business/index.blade.php ENDPATH**/ ?>