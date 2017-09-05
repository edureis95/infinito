

<?php $__env->startSection('content'); ?>

<div class="col-md-11">
	<div class="panel panel-default">
		<div class="panel-body">
			<table class="table borderless" style="width: auto;">
				<thead>
					<th>Nome</th>
					<th>Email</th>	
				</thead>
				<?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td><?php echo e($contact->FN); ?></td>
					<td><?php echo e($contact->EMAIL); ?></td>
				</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</table>
		</div>
	</div>
</div>

<script>

</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>