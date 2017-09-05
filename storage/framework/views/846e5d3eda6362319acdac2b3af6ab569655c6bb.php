<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/datepicker-pt.js"></script>

<div class="col-xs-12" style="max-width: 100%;">
	<?php echo $__env->make('layouts.project_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.project_management_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body" style="padding-left: 0;">
			<table class="table">
				<thead>
					<th class="text-center">Data</th>
					<th class="text-center">Colaborador</th>
					<th class="text-center">Tipo</th>
					<th class="text-center">Sub-Tipo</th>
					<th class="text-center">Observações</th>
					<th class="text-center"><button style="padding: 3px 5px;" class="btn btn-primary addType" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
				</thead>
				<tbody class="text-center">
					<tr class="hiddenForm hidden">
						<form action="/project/events/addEvent/<?php echo e($project->id); ?>" method="POST">
							<td>
								<input class="form-control datepicker" required name="date">
							</td>
							<td>
								<select class="form-control" name="user">
								<?php $__currentLoopData = $usersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if($user->id == Auth::user()->id): ?>
									<option selected value="<?php echo e($user->id); ?>"><?php echo e($user->sigla); ?></option>
								<?php else: ?>
									<option value="<?php echo e($user->id); ?>"><?php echo e($user->sigla); ?></option>
								<?php endif; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</td>
							<td>
								<select class="form-control typeSelect" name="type">
								<?php $__currentLoopData = $eventTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</td>
							<td>
								<select class="form-control subTypeSelect" name="subType">
									<option value="0">Sem sub-tipo</option>
									<?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option class="hidden subTypeOption" value="<?php echo e($state->id); ?>"><?php echo e($state->name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</select>
							</td>
							<td>
								<input type="text" class="form-control" name="observations">
							</td>
							<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
							<td><button type="submit" class="btn btn-primary">Inserir</button></td>
						</form>
					</tr>
					<?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><?php echo e($event->date); ?></td>
						<td><?php echo e($event->u_sigla); ?></td>
						<td><?php echo e($event->t_name); ?></td>
						<td><?php echo e($event->s_name); ?></td>
						<td><?php echo e($event->observations); ?></td>
						<td><button content='<?php echo e($event->id); ?>' style="padding: 3px 5px; margin-bottom: 5px;" class="btn btn-danger removeEvent" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
					</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>

$( function() {
	$( ".datepicker" ).datepicker();
    $( ".datepicker" ).datepicker("option", "dateFormat",'yy-mm-dd');
});

function showStates() {
	$('.subTypeSelect .subTypeOption').each(function() {
		$(this).addClass('hidden');
	});
	var id = $('.typeSelect').val();
	var type = $('.typeSelect option[value="' + id + '"]').text();
	if(type.toUpperCase() == 'ESTADO') {
		$('.subTypeSelect .subTypeOption').each(function() {
			$(this).removeClass('hidden');
		});
	}
}

showStates();

$('.typeSelect').change(function() {
	showStates();
});

$('.addType').click(function() {
	$('.hiddenForm').removeClass('hidden');
});

$('.removeEvent').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().find('td').remove();
	$.get('/project/events/removeEvent/' + id, function(response) {
	});
});	
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>