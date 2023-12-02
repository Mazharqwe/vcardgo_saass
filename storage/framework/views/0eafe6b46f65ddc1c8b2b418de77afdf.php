<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Plan Request')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Plan Request')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Plan Request')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="col-xl-12">
        <div class="card">
            <div class=" card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th><?php echo e(__('User Name')); ?></th>
                                <th><?php echo e(__('Plan Name')); ?></th>
                                <th><?php echo e(__('Business')); ?></th>
                                <th><?php echo e(__('Duration')); ?></th>
                                <th><?php echo e(__('Date')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($plan_requests->count() > 0): ?>
                                <?php $__currentLoopData = $plan_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                  <tr>
                                        <td>
                                            <div class="font-style font-weight-bold"><?php echo e($prequest->user->name); ?></div>
                                        </td>
                                        <td>
                                            <div class="font-style font-weight-bold"><?php echo e($prequest->plan->name); ?></div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold"><?php echo e($prequest->plan->business); ?></div>
                                            <div><?php echo e(__('Business')); ?></div>
                                        </td>
                                        <td>
                                            <div class="font-style font-weight-bold"><?php echo e($prequest->duration); ?></div>
                                        </td>
                                        <td><?php echo e(\App\Models\Utility::getDateFormated($prequest->created_at,true)); ?></td>
                                        <td>
                                            <div>
                                                <a href="<?php echo e(route('response.request',[$prequest->id,1])); ?>" data-bs-placement="top" data-bs-toggle="tooltip"
 data-bs-original-title="<?php echo e(__('Accept')); ?>" class="btn btn-success btn-xs">
                                                    <i class="ti ti-check"></i>
                                                </a>
                                                <a data-bs-placement="top" data-bs-toggle="tooltip"
 data-bs-original-title="<?php echo e(__('Reject')); ?>" href="<?php echo e(route('response.request',[$prequest->id,0])); ?>" class="btn btn-danger btn-xs">
                                                    <i class="ti ti-x"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                   
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <th scope="col" colspan="7"><h6 class="text-center p-4"><?php echo e(__('No Manually Plan Request Found.')); ?></h6></th>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Projects\vcardgo-saas\resources\views/plan_request/index.blade.php ENDPATH**/ ?>