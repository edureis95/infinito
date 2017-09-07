<?php $__env->startSection('content'); ?>
<link href="css/mail_client.css" rel="stylesheet" type="text/css" media="all">
<link href='//fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>

<style>

</style>

<div class="col-xs-12 insideContainer">
    <div class="panel panel-default borderless">
        <div class="panel-body" style="padding: 0">
            <div class="row">
            <iframe src="https://infinito.elementofinito.com/roundcube/?_task=calendar" frameBorder="0" style="height: calc(100% - 70px); width: 100%"></iframe>   
        </div>
        </div>
    </div>
</div>

<script>


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>