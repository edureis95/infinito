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
						<th class="text-left">Empresa</th>
						<th class="text-left">Função</th>
						<th class="text-left">Nome</th>
						<th class="text-left">Email</th>
						<th class="text-left">Telefone</th>
						<th class="text-left">Ação</th>
						<th><button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
					</thead>
					<tbody class="text-center">
						<tr class="hidden hiddenForm">
							<form action="/project/team/addOutsideMember/<?php echo e($project->id); ?>" method="POST">
								<td>
									<select class="form-control input-sm expertiseSelect" name="expertise">
										<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</td>
								<td>
									<select class="form-control input-sm companySelect" name="company">
										<option value="0">Sem empresa</option>
										<?php $__currentLoopData = $companyContacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($contact->id); ?>"><?php echo e($contact->name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</td>
								<td>
									<select class="form-control input-sm" name="function">
										<?php $__currentLoopData = $functions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $function): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($function->id); ?>"><?php echo e($function->name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</td>
								<td>
									<select class="form-control input-sm coordinatorSelect" name="coordinator">
										<option value="0">Sem contacto pessoal</option>
										<?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option class="company<?php echo e($contact->company != null ? $contact->company : 0); ?> coordinator" value="<?php echo e($contact->id); ?>"><?php echo e($contact->firstName); ?> <?php echo e($contact->lastName); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</td>
								<td class="emailSpace"></td>
								<td class="phoneSpace"></td>
								<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
								<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
							</form>
						</tr>
						<?php $__currentLoopData = $team; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr class="text-left">
							<td>
								<?php echo e($member->e_name); ?>

							</td>
							<td>
								<?php echo e($member->c_name); ?>

							</td>
							<td>
								<?php echo e($member->u_function); ?>

							</td>
							<td>
								<?php echo e($member->u_firstName); ?> <?php echo e($member->u_lastName); ?>

							</td>
							<td>
								<?php echo e($member->u_email); ?>

							</td>
							<td>
								<?php echo e($member->u_phone); ?>

							</td>
							<td data-editable='false'><button content='<?php echo e($member->id); ?>' style="padding: 3px 5px;" class="btn btn-danger removeMember" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
							<td></td>
						</tr>	
					</tbody>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
$('.hiddenFormButton').click(function() {
	$('.hiddenForm').removeClass('hidden');
});

$('.removeMember').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().remove();
	$.get('/project/deleteOutsideTeamMember/' + id, function() {
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

$('.expertiseSelect').change(function() {
	showSubExpertise();
});

function updateContacts() {
	$('.coordinatorSelect option[value="0"]').prop('selected', true);
	$('.coordinatorSelect .coordinator').each(function() {
		$(this).addClass('hidden');
	});
	var company = $('.companySelect').val();
	$('.coordinatorSelect .company' + company).each(function() {
		$(this).removeClass('hidden');
	})
}

$('.companySelect').change(function() {
	updateContacts();
});

updateContacts();

function getEmailAndPhone() {
	var user_id = $('.coordinatorSelect').val();
	if(user_id != 0) {
		$.get('/emailAndPhoneFromContact/' + user_id, function(response) {
			console.log(response);
			$('.emailSpace').text(response.email);
			$('.phoneSpace').text(response.phoneNumber);
		})
	}
}

getEmailAndPhone();

$('.coordinatorSelect').change(function() {
	console.log('oi');
	getEmailAndPhone();
})
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>