<div class="box-footer">

    <?php echo e(csrf_field(), false); ?>


    <div class="col-md-<?php echo e($width['label'], false); ?>">
    </div>

    <div class="col-md-<?php echo e($width['field'], false); ?>">

        <?php if(in_array('submit', $buttons)): ?>
        <div class="btn-group pull-right">
            <button type="submit" class="btn btn-primary"><?php echo e(trans('admin.submit'), false); ?></button>
        </div>

        <?php endif; ?>

        <?php if(in_array('reset', $buttons)): ?>
        <div class="btn-group pull-left">
            <button type="reset" class="btn btn-warning"><?php echo e(trans('admin.reset'), false); ?></button>
        </div>
        <?php endif; ?>
    </div>
</div>
