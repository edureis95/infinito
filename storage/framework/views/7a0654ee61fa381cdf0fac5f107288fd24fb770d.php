

<?php $__env->startSection('content'); ?>

<div class="col-md-11">
	<?php echo $__env->make('layouts.settings_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.user_settings_2nd_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default">
		<div class="panel-body">
			<table class="table borderless">
				<thead>
					<th> Perfis </th>
				</thead>
				<?php $__currentLoopData = $permissionProfiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td> 
						<?php echo e($profile->name); ?>

						<button content='<?php echo e($profile->id); ?>' style="padding: 3px 5px; margin-bottom: 5px;" class="btn btn-danger removeProfile" type="button"><i class="glyphicon glyphicon-minus"></i></button>
					</td>
				</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</table>
			<form action="/settings/users/profiles/addProfile" method="POST">
				<div class="col-xs-6">
					<input type="text" required  class="form-control" name="profile" placeholder="Introduz o nome do perfil que queres adicionar">
				</div>
				<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
				<button type="submit" class="btn btn-primary">Adicionar Perfil</button>
			</form>
		</div>
	</div>
</div>

<script>
$('.removeProfile').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().find('td').remove();
	$.get('/settings/users/profiles/removeProfile/' + id, function() {
	});
});	
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>