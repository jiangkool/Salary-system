<div class="form-group ">
    <label class="col-sm-2 control-label"><?php echo e($label, false); ?></label>
    <div class="col-sm-8">
        <?php if($wrapped): ?>
        <div class="box box-solid box-default no-margin box-show">
            <!-- /.box-header -->
            <div class="box-body">
                <?php echo $content; ?>&nbsp;
            </div><!-- /.box-body -->
        </div>
        <?php else: ?>
            <?php echo $content; ?>

        <?php endif; ?>
    </div>
</div>