<?php
    $users = \Auth::user();
    $businesses = App\Models\Business::allBusiness();
    $currantBusiness = $users->currentBusiness();
    $bussiness_id = $users->current_business;
?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Contacts')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Contacts')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Contacts')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <style>
        .export-btn {
            float: right;
        }
    </style>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <div class="d-flex align-items-center justify-content-between">
                    
                    <ul class="list-unstyled">
                        <li class="dropdown dash-h-item drp-language">
                            <a class="dash-head-link dropdown-toggle arrow-none me-0 cust-btn"
                                data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                aria-expanded="false" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                data-bs-original-title="<?php echo e(__('Select your bussiness')); ?>">
                                <i class="ti ti-credit-card"></i>
                                <span class="drp-text hide-mob"><?php echo e(__(ucfirst($currantBusiness))); ?></span>
                                <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                            </a>
                            <div class="dropdown-menu dash-h-dropdown dropdown-menu-end page-inner-dropdowm">
                                <?php $__currentLoopData = $businesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('business.change', $key)); ?>" class="dropdown-item">
                                        <i
                                            class="<?php if($bussiness_id == $key): ?> ti ti-checks text-primary <?php elseif($currantBusiness == $business): ?> ti ti-checks text-primary <?php endif; ?> "></i>
                                        <span><?php echo e(ucfirst($business)); ?></span>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </li>
                    </ul>

                    
                    <button class="csv btn btn-sm btn-primary export-btn mb-3"><?php echo e(__('Export')); ?></button>
                </div>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-export">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Business Name')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Email')); ?></th>
                                <th><?php echo e(__('Phone')); ?></th>
                                <th><?php echo e(__('Message')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th id="ignore"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $contacts_deatails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($val->business_name); ?></td>
                                    <td><?php echo e($val->name); ?></td>
                                    <td><?php echo e($val->email); ?></td>
                                    <td><?php echo e($val->phone); ?></td>
                                    <td style="white-space: normal;width: 500px;"><?php echo e($val->message); ?></td>
                                    <?php if($val->status == 'pending'): ?>
                                        <td><span
                                                class="badge bg-warning p-2 px-3 rounded"><?php echo e(ucFirst($val->status)); ?></span>
                                        </td>
                                    <?php else: ?>
                                        <td><span
                                                class="badge bg-success p-2 px-3 rounded"><?php echo e(ucFirst($val->status)); ?></span>
                                        </td>
                                    <?php endif; ?>
                                    <div class="row ">
                                        <td class="d-flex">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete contact')): ?>
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
                                                    'route' => ['contacts.destroy', $val->id],
                                                    'id' => 'delete-form-' . $val->id,
                                                ]); ?>

                                                <?php echo Form::close(); ?>

                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit contact')): ?>
                                                <div class="action-btn bg-success  ms-2">
                                                    <a href="#"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center cp_link"
                                                        data-toggle="modal" data-target="#commonModal" data-ajax-popup="true"
                                                        data-size="lg" data-url="<?php echo e(route('contact.add-note', $val->id)); ?>"
                                                        data-title="<?php echo e(__('Add Note & Change Status')); ?>"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="<?php echo e(__('Add Note & Change Status')); ?>"> <span
                                                            class="text-white"><i class="ti ti-note"></i></span></a>
                                                </div>
                                            <?php endif; ?>
                                        </td>

                                    </div>

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
    <script src="https://rawgit.com/unconditional/jquery-table2excel/master/src/jquery.table2excel.js"></script>
    <script>
        const table = new simpleDatatables.DataTable("#pc-dt-export", {
            searchable: true,
            fixedheight: true,
            dom: 'Bfrtip',
        });
        $('.csv').on('click', function() {
            $('#ignore').remove();
            $("#pc-dt-export").table2excel({
                filename: "contactDetail"
            });
            setTimeout(function() {
                location.reload();
            }, 2000);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Projects\vcardgo-saas\resources\views/contacts/index.blade.php ENDPATH**/ ?>