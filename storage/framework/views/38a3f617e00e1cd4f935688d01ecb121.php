<?php
    $users = \Auth::user();
    $businesses = App\Models\Business::allBusiness();
    $currantBusiness = $users->currentBusiness();
    $bussiness_id = $users->current_business;
?>

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Appointments')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Appointments')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Appointments')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
    <style>
        .export-btn {
            float: right;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>


    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="row">
                    <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 d-lg-flex gap-3 align-items-end mb-3 mb-md-0">
                        
                        <ul class="list-unstyled mb-lg-0">
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
                        
                        <?php echo e(Form::open(['route' => ['appointments.index'], 'method' => 'get', 'id' => 'appointment_filter', 'class' => 'appointment_filter_row'])); ?>

                        <div class="d-md-flex mb-3 mb-lg-0">
                            <div class="col-xl-3 col-lg-3 col-md-5 col-sm-12 col-12 mx-2 mb-3 mb-md-0">
                                <div class="btn-box">
                                    <?php echo e(Form::label('start_date', __('Start Date'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::date('start_date', isset($_GET['start_date']) ? $_GET['start_date'] : '', ['class' => 'form-control ', 'placeholder' => 'Select Date'])); ?>

                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-5 col-sm-12 col-12 mx-2">
                                <div class="btn-box">
                                    <?php echo e(Form::label('end_date', __('End Date'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::date('end_date', isset($_GET['end_date']) ? $_GET['end_date'] : '', ['class' => 'form-control ', 'placeholder' => 'Select Date'])); ?>

                                </div>
                            </div>
                            <div class="col-auto float-end ms-2 mt-4">
                                <a class="btn btn-sm btn-primary"
                                    onclick="document.getElementById('appointment_filter').submit(); return false;"
                                    data-bs-toggle="tooltip" title="" data-bs-original-title="apply">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="<?php echo e(route('appointments.index')); ?>" class="btn btn-sm btn-danger"
                                    data-bs-toggle="tooltip" title="" data-bs-original-title="Reset">
                                    <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                </a>
                            </div>
                        </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-12">
                        <button class="csv btn btn-sm btn-primary export-btn"><?php echo e(__('Export')); ?></button>
                    </div>
                    
                </div>

                
                <div class="table-responsive mt-3">
                    <table class="table" id="pc-dt-export">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Date')); ?></th>
                                <th><?php echo e(__('Time')); ?></th>
                                <th><?php echo e(__('Business Name')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Email')); ?></th>
                                <th><?php echo e(__('Phone')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th id="ignore"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $appointment_deatails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($val->date); ?></td>
                                    <td><?php echo e($val->time); ?></td>
                                    <td><?php echo e($val->business_name); ?></td>
                                    <td><?php echo e($val->name); ?></td>
                                    <td><?php echo e($val->email); ?></td>
                                    <td><?php echo e($val->phone); ?></td>
                                    <?php if($val->status == 'pending'): ?>
                                        <td><span
                                                class="badge bg-warning p-2 px-3 rounded"><?php echo e(ucFirst($val->status)); ?></span>
                                        </td>
                                    <?php else: ?>
                                        <td><span
                                                class="badge bg-success p-2 px-3 rounded"><?php echo e(ucFirst($val->status)); ?></span>
                                        </td>
                                    <?php endif; ?>
                                    <div class="row float-end">
                                        <td class="d-flex">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete appointment')): ?>
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
                                                    'route' => ['appointments.destroy', $val->id],
                                                    'id' => 'delete-form-' . $val->id,
                                                ]); ?>

                                                <?php echo Form::close(); ?>

                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit appointment')): ?>
                                                <div class="action-btn bg-success  ms-2">
                                                    <a href="#"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center cp_link"
                                                        data-toggle="modal" data-target="#commonModal" data-ajax-popup="true"
                                                        data-size="lg" data-url="<?php echo e(route('appointment.add-note', $val->id)); ?>"
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card current-date-appointments" >
                <div class="card-body ">
                    <h5 class=""><?php echo e(__('Appointments')); ?></h5>
                    <small><?php echo e(__('This data is only for current month ')); ?></small>
                    <ul class="event-cards list-group list-group-flush mt-3 w-100 ">
                        <?php $__currentLoopData = $arrayJson; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $month = date('m', strtotime($appointment['start']));
                            ?>
                            <?php if($month == date('m')): ?>
                                <li class="list-group-item card mb-3">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-auto mb-3 mb-sm-0">
                                            <div class="d-flex align-items-center">
                                                <div class="theme-avtar bg-primary">
                                                    <i class="ti ti-calendar"></i>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class=""><?php echo e($appointment['title']); ?></h6>
                                                    <small class="text-muted mt-2"><?php echo e($appointment['start']); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">

                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <input type="hidden" class="business_id" name="business_id"
                                value="<?php echo e($appointment['business_id']); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-header appointments-calender">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5><?php echo e(__('Calendar')); ?></h5>
                        </div>
                        <div class="col-lg-6">
                            <?php if(isset($settings['Google_Calendar']) && $settings['Google_Calendar'] == 'on'): ?>
                                <select class="form-control" name="is_live" id="is_live"
                                    style="float: right;width: 170px;" onchange="get_data()">
                                    <option value="1"><?php echo e(__('Google Calender')); ?></option>
                                    <option value="0" selected="true"><?php echo e(__('Local Calender')); ?></option>
                                </select>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id='calendar' class='calendar'></div>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
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
                filename: "appointmentDetail"
            });
            setTimeout(function() {
                location.reload();
            }, 2000);
        });
    </script>
    <script src="<?php echo e(asset('custom/libs/moment/min/moment.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            get_data();
        });

        function get_data() {
            var is_live = $('#is_live :selected').val();
            var id = $(".business_id").val();
            var start_date = $('input[name=start_date]').val();
            var end_date = $('input[name=end_date]').val();

            $.ajax({
                url: $("#path_admin").val() + "/get_appointment_data",
                method: "POST",
                data: {
                    "id": id,
                    "_token": "<?php echo e(csrf_token()); ?>",
                    'is_live': is_live,
                    'start_date': start_date,
                    'end_date': end_date,

                },
                success: function(data) {
                    (function() {
                        var etitle;
                        var etype;
                        var etypeclass;
                        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            buttonText: {
                                timeGridDay: "<?php echo e(__('Day')); ?>",
                                timeGridWeek: "<?php echo e(__('Week')); ?>",
                                dayGridMonth: "<?php echo e(__('Month')); ?>"
                            },
                            slotLabelFormat: {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false,
                            },
                            allDaySlot: false,
                            themeSystem: 'bootstrap',
                            // slotDuration: '00:10:00',
                            navLinks: true,
                            droppable: true,
                            selectable: true,
                            selectMirror: true,
                            editable: true,
                            dayMaxEvents: true,
                            handleWindowResize: false,
                            height: 'auto',
                            events: data,
                            eventClick: function(e) {
                                e.jsEvent.preventDefault();
                                var title = e.title;
                                var url = e.el.href;

                                if (is_live == 0 || is_live == undefined) {
                                    if (typeof url != 'undefined') {
                                        $("#commonModal .modal-title").html(e.event.title);
                                        $("#commonModal .modal-dialog").addClass('modal-md');
                                        $("#commonModal").modal('show');

                                        $.get(url, {}, function(data) {
                                            $('#commonModal .modal-body ').html(data);
                                        });
                                        return false;
                                    }
                                }

                            }
                        });
                        calendar.render();
                    })();
                }
            });

        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Projects\vcardgo-saas\resources\views/appointments/index.blade.php ENDPATH**/ ?>