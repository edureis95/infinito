<?php $__env->startSection('content'); ?>
<div class="col-md-8 col-md-offset-1 col-xs-8 col-xs-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>

        <div class="panel-body">
            You are logged in!
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>