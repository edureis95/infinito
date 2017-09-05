

<?php $__env->startSection('content'); ?>

<div class="col-md-11">
	<?php echo $__env->make('layouts.settings_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.user_settings_2nd_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default">
		<div class="panel-body">
			<table class="table borderless permissionTable text-center">
				<thead>
					<th class="text-center"> Permissões </th>
					<?php $__currentLoopData = $permissionProfiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<th class="text-center"> <?php echo e($profile->name); ?> </th>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</thead>
				<tr>
					<td> Calendário </td>
					<?php $__currentLoopData = $permissionProfiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if($profile->calendar == 1): ?>
						<td><input id="calendar<?php echo e($profile->id); ?>" checked type="checkbox"></td>
					<?php else: ?>
						<td><input id="calendar<?php echo e($profile->id); ?>" type="checkbox"></td>
					<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					
				</tr>
				<tr>
					<td> Contactos </td>
					<?php $__currentLoopData = $permissionProfiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if($profile->contacts == 1): ?>
						<td><input id="contacts<?php echo e($profile->id); ?>" checked type="checkbox"></td>
					<?php else: ?>
						<td><input id="contacts<?php echo e($profile->id); ?>" type="checkbox"></td>
					<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tr>
				<tr>
					<td> Email </td>
					<?php $__currentLoopData = $permissionProfiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if($profile->email == 1): ?>
						<td><input id="email<?php echo e($profile->id); ?>" checked type="checkbox"></td>
					<?php else: ?>
						<td><input id="email<?php echo e($profile->id); ?>" type="checkbox"></td>
					<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tr>
				<tr>
					<td> Empresa </td>
					<?php $__currentLoopData = $permissionProfiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if($profile->company == 1): ?>
						<td><input id="company<?php echo e($profile->id); ?>" checked type="checkbox"></td>
					<?php else: ?>
						<td><input id="company<?php echo e($profile->id); ?>" type="checkbox"></td>
					<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tr>
				<tr>
					<td> Projetos </td>
					<?php $__currentLoopData = $permissionProfiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if($profile->projects == 1): ?>
						<td><input id="projects<?php echo e($profile->id); ?>" checked type="checkbox"></td>
					<?php else: ?>
						<td><input id="projects<?php echo e($profile->id); ?>" type="checkbox"></td>
					<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tr>
				<tr>
					<td> Definições </td>
					<?php $__currentLoopData = $permissionProfiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if($profile->settings == 1): ?>
						<td><input id="settings<?php echo e($profile->id); ?>" checked type="checkbox"></td>
					<?php else: ?>
						<td><input id="settings<?php echo e($profile->id); ?>" type="checkbox"></td>
					<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tr>
			</table>
			<button type="button" class="btn btn-success" id="savePermissions">Guardar</button>
			<span class="savedBox hidden" style="color: green;"><i class="glyphicon glyphicon-check"></i> As permissões foram guardadas</span>
		</div>
	</div>
</div>

<script>

$('.permissionTable input').change(function() {
	$('.savedBox').addClass('hidden');
});

$('#savePermissions').click(function() {
	var obj = {};
	$('.permissionTable input').each(function() {
		obj[$(this).attr('id')] = $(this).is(":checked");
	});

	$.ajax({
	  type: "POST",
	  url: '/settings/users/permissions/savePermissions',
	  data: obj,
	  success: function() {
	  	$('.savedBox').removeClass('hidden');
	  }
	});
});
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>