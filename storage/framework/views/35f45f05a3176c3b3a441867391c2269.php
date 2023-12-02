<?php
    $chatgpt_setting = App\Models\Utility::chatgpt_setting(\Auth::user()->creatorId());
?>

<?php echo e(Form::open(['url' => route('business.store')])); ?>

<?php if($chatgpt_setting['enable_chatgpt'] == 'on'): ?>
    <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end"
        data-bs-placement="top">
        <a href="#" data-size="lg" class="btn btn-sm btn-primary" data-ajax-popup-over="true"
            data-url="<?php echo e(route('generate', ['create business'])); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
            title="<?php echo e(__('Generate')); ?>" data-title="<?php echo e(__('Generate content with AI')); ?>">
            <i class="fas fa-robot"></i>&nbsp;<?php echo e(__('Generate with AI')); ?>

        </a>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <?php echo e(Form::label('Business', __('Business'), ['class' => 'form-control-label'])); ?>

        <?php echo e(Form::text('business_title', null, ['class' => 'form-control mt-2'])); ?>

        <?php $__errorArgs = ['business_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="invalid-favicon text-xs text-danger" role="alert"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="horizontal mt-3">
        <div class="verticals twelve">
            <div class="form-group col-md-6">
                <?php echo e(Form::label('Select Themes', __('Select Themes'), ['class' => 'form-control-label'])); ?>

            </div>
            <div class="uploaded-pics gy-3 row">
                <?php echo e(Form::hidden('theme', null, ['id' => 'themefile1'])); ?>

                <?php $__currentLoopData = \App\Models\Utility::themeOne(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(in_array($key, Auth::user()->getPlanThemes())): ?>
                        <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-5 theme-view-card">
                            <div class="theme-view-inner">
                                <div class="theme-view-img ">
                                    <img class="color_theme1 <?php echo e($key); ?>_img" data-id="<?php echo e($key); ?>"
                                        src="<?php echo e(asset(Storage::url('uploads/card_theme/' . $key . '/color1.png'))); ?>"
                                        alt="">
                                </div>
                                <div class=" mt-3">
                                    <h6><?php echo e(__('Modern Theme')); ?></h6>
                                    <span class="mb-1"><?php echo e(__('Select Sub-Color:')); ?></span>
                                    <div class="d-flex align-items-center" id="<?php echo e($key); ?>">
                                        <?php $__currentLoopData = $v; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $css => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <label class="colorinput">
                                                <input name="theme_color" id="<?php echo e($css); ?>" type="radio"
                                                    value="<?php echo e($css); ?>" data-theme="<?php echo e($key); ?>"
                                                    data-imgpath="<?php echo e($val['img_path']); ?>" class="colorinput-input"
                                                    <?php echo e(isset($business->theme_color) && $business->theme_color == $css ? 'checked' : ''); ?>>
                                                <span class="border-box">
                                                    <span class="colorinput-color"
                                                        style="background:<?php echo e($val['color']); ?>"></span>
                                                </span>
                                            </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <input class="btn btn-primary" type="submit" value="<?php echo e(__('Create')); ?>">
</div>

<script>
    $(document).on('click', 'input[name="theme_color"]', function() {
        var eleParent = $(this).attr('data-theme');
        $('#themefile1').val(eleParent);
        var imgpath = $(this).attr('data-imgpath');
        $('.' + eleParent + '_img').attr('src', imgpath);

        $('.theme_preview_img').attr('src', imgpath);
        $(this).closest('.theme-view-card').addClass('selected-theme');
    });

    $(document).on("click", ".color_theme1", function() {
        var id = $(this).attr('data-id');
        $(".theme-view-card").removeClass('selected-theme')
        $(this).closest('.theme-view-card').addClass('selected-theme');

        var dataId = $(this).attr("data-id");
        $('#color1-' + dataId).trigger('click');
        // $(".theme-view-card").addClass('')
    });

    $(document).ready(function() {
        var checked = $("input[type=radio][name='theme_color']:checked");
        $('#themefile1').val(checked.attr('data-theme'));
        $(checked).closest('.theme-view-card').addClass('selected-theme');
    });
</script>
<?php /**PATH D:\Projects\vcardgo-saas\resources\views/business/create.blade.php ENDPATH**/ ?>