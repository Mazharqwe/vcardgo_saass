<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Role')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Role')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Role')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create role')): ?>
    <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end"
        data-bs-placement="top">
        <a href="#" data-size="lg" data-url="<?php echo e(route('roles.create')); ?>" data-ajax-popup="true" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create New Role')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Role')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style ">
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <th><?php echo e(__('Role')); ?> </th>
                            <th><?php echo e(__('Permissions')); ?> </th>
                            <th width="200px"><?php echo e(__('Action')); ?> </th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(ucfirst($role->name)); ?></td>
                                <td style="white-space: normal;" width="100%">
                                    <?php $__currentLoopData = $role->permissions()->pluck('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permissionName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge rounded p-2 m-1 px-3 bg-primary"><?php echo e($permissionName); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit role')): ?>
                                        <div class="action-btn bg-info ms-2">
                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center " data-url="<?php echo e(route('roles.edit',$role->id)); ?>" data-size="lg" data-ajax-popup="true"  data-title="<?php echo e(__('Update Role')); ?>" title="<?php echo e(__('Update')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"><span class="text-white"><i class="ti ti-edit text-white"></i></span></a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete role')): ?>
                                        <div class="action-btn bg-danger ms-2">
                                            <a href="#" class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center" data-confirm="<?php echo e(__('Are You Sure?')); ?>" data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="delete-form-<?php echo e($role->id); ?>"
                                            title="<?php echo e(__('Delete')); ?>" data-bs-toggle="tooltip"
                                            data-bs-placement="top"><span class="text-white"><i
                                                    class="ti ti-trash"></i></span></a>
                                        </div>
                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id],'id'=>'delete-form-'.$role->id]); ?>

                                        <?php echo Form::close(); ?>

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

<?php $__env->startPush('script-page'); ?>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Projects\vcardgo-saas\resources\views/role/index.blade.php ENDPATH**/ ?>