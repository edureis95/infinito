<?php $__env->startSection('content'); ?>


<div class="col-xs-12 insideContainer">
	<?php echo $__env->make('layouts.project_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.project_second_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav" style="padding-left: 0;">
			<div class="col-xs-12">
				<table class="table smallFontTable">
					<thead>
						<th class="text-left">Especialidade</th>
						<th class="text-left">Sub-Especialidade</th>
						<th class="text-center">Função</th>
						<th class="text-center">Colaborador</th>
						<th class="text-center">Departamento</th>
						<th class="text-left">Email</th>
						<th class="text-center">Ação</th>
						<th><button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
					</thead>
					<tbody class="text-left">
						<tr class="hidden hiddenForm">
							<form action="/project/team/addMember/<?php echo e($project->id); ?>" method="POST">
								<td>
									<select class="form-control input-sm expertiseSelect" name="expertise">
										<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</td>
								<td>
									<select class="form-control input-sm subExpertiseSelect" name="subExpertise">
										<option value="0">Sem sub-especialidade</option>
										<?php $__currentLoopData = $subExpertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option class="hidden expert" content="<?php echo e($expert->parent); ?>" value="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</td>
								<td>
									<select class="form-control input-sm functionSelect" name="function">
									<?php $__currentLoopData = $functions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $function): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($function->id); ?>"><?php echo e($function->name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</td>
								<td>
									<select class="form-control input-sm teamUserSelect" name="user">
										<?php $__currentLoopData = $usersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($user->id == Auth::user()->id): ?>
											<option selected value="<?php echo e($user->id); ?>"><?php echo e($user->sigla); ?></option>
										<?php else: ?>
											<option value="<?php echo e($user->id); ?>"><?php echo e($user->sigla); ?></option>
										<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</td>
								<td class="departmentSpace text-center"></td>
								<td class="emailSpace"></td>
								<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
								<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
							</form>
						</tr>
						<?php $__currentLoopData = $team; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr class="text-left memberEdit<?php echo e($member->id); ?> hidden">
							<td>
								<select class="form-control input-sm expertiseSelect" name="expertise">
									<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($expert->id == $member->e_id): ?>
										<option selected value="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></option>
										<?php else: ?>
										<option value="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></option>
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</td>
							<td>
								<select class="form-control input-sm subExpertiseSelect" name="subExpertise">
									<option value="0">Sem sub-especialidade</option>
									<?php $__currentLoopData = $subExpertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($expert->id == $member->subExpertise_id): ?>
										<option selected class="hidden expert" content="<?php echo e($expert->parent); ?>" value="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></option>
										<?php else: ?>
										<option class="hidden expert" content="<?php echo e($expert->parent); ?>" value="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></option>
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</td>
							<td>
								<select class="form-control input-sm functionSelect" name="function">
								<?php $__currentLoopData = $functions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $function): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if($function->id == $member->u_function_id): ?>
									<option selected value="<?php echo e($function->id); ?>"><?php echo e($function->name); ?></option>
									<?php else: ?>
									<option value="<?php echo e($function->id); ?>"><?php echo e($function->name); ?></option>
									<?php endif; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</td>
							<td class="text-center">
								<?php echo e($member->u_sigla); ?>

							</td>
							<td class="text-center">
								<?php echo e($member->u_department); ?>

							</td>
							<td>
								<?php echo e($member->u_email); ?>

							</td>
							<td class="text-center" data-editable='false'>
								<button class="btn btn-xs btn-danger cancelEdit" content="<?php echo e($member->id); ?>"><i class="glyphicon glyphicon-edit"></i></button>
								<button content='<?php echo e($member->id); ?>' class="btn btn-success btn-xs saveMember" type="button"><i class="glyphicon glyphicon-check"></i></button>
							</td>
						</tr>
						<tr class="text-left member<?php echo e($member->id); ?>">
							<td>
								<?php echo e($member->e_name); ?>

							</td>
							<td>
								<?php echo e($member->subExpert_name); ?>

							</td>
							<td class="text-center">
								<?php echo e($member->u_function); ?>

							</td>
							<td class="text-center">
								<?php echo e($member->u_sigla); ?>

							</td>
							<td class="text-center">
								<?php echo e($member->u_department); ?>

							</td>
							<td>
								<?php echo e($member->u_email); ?>

							</td>
							<td data-editable='false' class="text-center">
								<button class="btn btn-xs btn-warning editMember" content="<?php echo e($member->id); ?>"><i class="glyphicon glyphicon-edit"></i></button>
								<button content='<?php echo e($member->id); ?>' class="btn btn-danger btn-xs removeMember" type="button"><i class="glyphicon glyphicon-minus"></i></button>
							</td>
						</tr>	
					</tbody>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
$('.editMember').click(function() {
	var id = $(this).attr('content');
	$('.memberEdit' + id).removeClass('hidden');
	$('.member' + id).addClass('hidden');
})

$('.cancelEdit').click(function() {
	var id = $(this).attr('content');
	$('.memberEdit' + id).addClass('hidden');
	$('.member' + id).removeClass('hidden');
})

$('.saveMember').click(function() {
	var id = $(this).attr('content');
	var function_id = $('.memberEdit' + id + ' .functionSelect').val();
	var expertise_id = $('.memberEdit' + id + ' .expertiseSelect').val();
	var subExpertise_id = $('.memberEdit' + id + ' .subExpertiseSelect').val();
	$.ajax({
		method: 'POST',
		url: '/project/team/editMember',
		data: {
			id: id,
			function_id: function_id,
			expertise_id: expertise_id,
			subExpertise_id: subExpertise_id
		},
		success: function() {
			location.reload();
		}
	})
})

$('.hiddenFormButton').click(function() {
	$('.hiddenForm').removeClass('hidden');
});

$('.removeMember').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().remove();
	$.get('/project/deleteTeamMember/' + id, function() {
	});
});

function showSubExpertise() {
	$('.subExpertiseSelect .expert').each(function() {
		$(this).addClass('hidden');
	});
	var expertise = $('.expertiseSelect').val();
	$('.subExpertiseSelect .expert').each(function() {
		if($(this).attr('content') == expertise)
			$(this).removeClass('hidden');
	});
}

showSubExpertise();

$('.expertiseSelect').change(showSubExpertise());

function getEmailAndDepartment() {
	var user_id = $('.teamUserSelect').val();
	$.get('/emailAndDepartmentFromUser/' + user_id, function(response) {
		$('.emailSpace').text(response.u_email);
		$('.departmentSpace').text(response.d_name);
	})
}

getEmailAndDepartment();

$('.teamUserSelect').change(function() {
	getEmailAndDepartment();
})
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>