<?php $__env->startSection('content'); ?>
<link href="css/mail_client.css" rel="stylesheet" type="text/css" media="all" />
<link href='//fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>


<div class="col-xs-12 insideContainer">

	<div class="row">
        <iframe src="https://infinito.elementofinito.com/roundcube/" frameBorder="0" style="width: 100%; height: 100%;"></iframe>   
    </div>
</div>

<script>
	
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>