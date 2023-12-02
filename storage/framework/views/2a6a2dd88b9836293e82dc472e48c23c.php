<?php
    $admin_payment_setting = Utility::getAdminPaymentSetting();
?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Order')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Order')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Order')); ?></li>
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
                                <th><?php echo e(__('Order Id')); ?></th>
                                <th><?php echo e(__('Date')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Plan Name')); ?></th>
                                <th><?php echo e(__('Price')); ?></th>
                                <th><?php echo e(__('Payment Type')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Coupon')); ?></th>
                                <th class="text-center"><?php echo e(__('Invoice')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               
                                <tr>
                                  <td><?php echo e($order->order_id); ?></td>
                                    <td><?php echo e($order->created_at->format('d M Y')); ?></td>
                                    <td><?php echo e($order->user_name); ?></td>
                                    <td><?php echo e($order->plan_name); ?></td>
                                    <td><?php echo e(isset($admin_payment_setting['CURRENCY_SYMBOL']) ? $admin_payment_setting['CURRENCY_SYMBOL'] : '$'); ?><?php echo e($order->price); ?></td>
                                    <td><?php echo e($order->payment_type); ?></td>
                                    <td>
                                        <?php if($order->payment_status == 'succeeded'): ?>
                                            <i class="mdi mdi-circle text-success"></i> <?php echo e(ucfirst($order->payment_status)); ?>

                                        <?php else: ?>
                                            <i class="mdi mdi-circle text-danger"></i> <?php echo e(ucfirst($order->payment_status)); ?>

                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <?php if(!empty($order->total_coupon_used) && !empty($order->total_coupon_used->coupon_detail)): ?>
                                            <?php echo e($order->total_coupon_used->coupon_detail->code); ?>

                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <?php if($order->receipt != 'free coupon' && $order->payment_type != 'STRIPE'): ?>
                                            <a href="<?php echo e($order->receipt); ?>" title="Invoice" target="_blank" class="">
                                                <i class="fas fa-file-invoice"></i>
                                            </a>
                                        <?php elseif($order->payment_type == 'Bank Transfer'): ?>
                                            <?php
                                                 $thumbnail = !empty($order->receipt) ? '' . $order->receipt : '';
                                            ?>
                                            
                                            <a href="<?php echo e(\App\Models\Utility::get_file('bank_receipt/'.$thumbnail)); ?>" title="Invoice" target="_blank" class="">
                                                <i class="fas fa-file-invoice"></i>
                                            </a>
                                        <?php elseif($order->receipt == 'free coupon'): ?>
                                            <p><?php echo e(__('Used 100 % discount coupon code.')); ?></p>
                                        <?php elseif($order->payment_type == 'Manually'): ?>
                                            <p><?php echo e(__('Manually plan upgraded by super admin')); ?></p>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($order->payment_status == 'pending' && $order->payment_type == 'Bank Transfer'): ?>
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center " data-url="<?php echo e(route('view.status.bank',$order->id)); ?>" data-size="md" data-ajax-popup="true"  data-title="<?php echo e(__('Change Status')); ?>" title="<?php echo e(__('Status')); ?>" data-bs-toggle="tooltip" data-bs-placement="top">
                                                <span class="text-white"><i class="ti ti-caret-right text-white"></i></span></a>
                                        </div>
                                        <?php endif; ?>
                                        <div class="action-btn bg-danger ms-2">
                                            <a href="#" class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center" data-confirm="<?php echo e(__('Are You Sure?')); ?>" data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="delete-form-<?php echo e($order->id); ?>"
                                            title="<?php echo e(__('Delete')); ?>" data-bs-toggle="tooltip"
                                            data-bs-placement="top"><span class="text-white"><i
                                                    class="ti ti-trash"></i></span></a>
                                        </div>
                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['order.destory', $order->id],'id'=>'delete-form-'.$order->id]); ?>

                                        <?php echo Form::close(); ?>

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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Projects\vcardgo-saas\resources\views/order/index.blade.php ENDPATH**/ ?>