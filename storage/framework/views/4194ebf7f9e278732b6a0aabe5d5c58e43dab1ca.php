

<?php $__env->startSection('content'); ?>

<div class="col-md-11">
	<?php echo $__env->make('layouts.management_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default">
		<div class="panel-body">

			<table class="table borderless" style="width: 200px;">
				<tr>
					<td>Colaborador</td>
					<td>
						<select class="userFilter form-control" class="form-control">
							<option value="0">Sem filtro</option>
							<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?>(<?php echo e($user->email); ?>)</option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Projeto</td>
					<td>
						<select class="form-control projectFilter">
							<option value="0">Sem filtro</option>
							<?php $__currentLoopData = $projectsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
							<option value="<?php echo e($project->id); ?>"><?php echo e(sprintf('%05d', $project->number)); ?> - <?php echo e($project->name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Fase</td>
					<td>
						<select class="form-control phaseFilter">
							<option value="0">Sem filtro</option>
							<?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($phase->id); ?>"><?php echo e($phase->name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Especialidade</td>
					<td>
						<select class="form-control expertiseFilter">
							<option value="0">Sem filtro</option>
							<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Desde</td>
					<td><input class="form-control startDateFilter" type="date"></td>
				</tr>
				<tr>
					<td>Até</td>
					<td>
						<input  class="form-control endDateFilter" type="date">
					</td>
				</tr>
				<tr>
					<td>Ocultar horas aprovadas</td>
					<td>
						<input class="approvedFilter" checked type="checkbox">
					</td>
				</tr>
				<tr>
				<td></td>
				</tr>
				<tr>
					<td><button type="button" class="btn refreshFilter">Atualizar</button></td>
				</tr>
			</table>

			<table class="table approvalTable">
				<thead>
					<th class="text-center" style="min-width: 90px;">Data</th>
					<th class="text-center">Colaborador</th>
					<th class="text-center">Projeto</th>
					<th class="text-center">Fase</th>
					<th class="text-center">Especialidade</th>
					<th class="text-center">Descrição</th>
					<th class="text-center">Tempo</th>
					<th class="text-center">Aprovar</th>	
				</thead>
				<tbody>
				<?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr class="text-center">
						<td><?php echo e($task->date); ?></td>
						<td><?php echo e($task->u_name); ?></td>
						<td><?php echo e(sprintf('%05d', $task->p_number)); ?> - <?php echo e($task->p_name); ?></td>
						<td><?php echo e($task->ph_name); ?></td>
						<td><?php echo e($task->e_name); ?></td>
						<td><?php echo e($task->t_name); ?></td>
						<td><?php echo e(sprintf('%02d', $task->t_hours)); ?>:<?php echo e(sprintf('%02d', $task->t_min)); ?></td>
						<td class="taskNotApproved"><input content="<?php echo e($task->t_id); ?>" class="approvalCheckbox" type="checkbox"></td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>
			</div>
			<button type="button" class="btn btn-success" id="saveApproval">Guardar</button>
			<span class="savedBox hidden" style="color: green;"><i class="glyphicon glyphicon-check"></i> As permissões foram guardadas</span>
		</div>
	</div>
</div>

<script>
$('.approvalTable').on('change', '.approvalCheckbox', function() {
	if($(this).is(":checked")) {
		$(this).parent().addClass('taskApproved');
		$(this).parent().removeClass('taskNotApproved');
	}
	else {
		$(this).parent().addClass('taskNotApproved');
		$(this).parent().removeClass('taskApproved');
	}

});

$('#saveApproval').click(function() {
	var obj = {};
	var ids = [];
	$('.approvalTable input').each(function() {
		obj[$(this).attr('content')] = $(this).is(":checked");
		ids.push($(this).attr('content'));
	});
	obj['ids'] = ids;

	$.ajax({
	  type: "POST",
	  url: '/management/hoursApproval/saveApproval',
	  data: obj,
	  success: function() {
	  	$('.savedBox').removeClass('hidden');
	  }
	});
});

var expertise = $('.expertiseFilter').html();
var phases = $('.phaseFilter').html();

$('.projectFilter').change(function() {
	var id = this.value;
	if(id == 0) {
		$('.phaseFilter').empty();
		$('.phaseFilter').append(phases);
	} else {
		$('.phaseFilter').empty();
		$('.phaseFilter').append('<option value="0">Sem Filtro</option>');
		$('.expertiseFilter').empty();
		$('.expertiseFilter').append('<option value="0">Sem Filtro</option>');
		$.ajax({
          type: "POST",
          url: '/getDetailsFromProject',
          data: {
            'project_id' : id
          },
          success: function(response) {

            for(var i = 0; i < response[0].length; i++) {
                var id = response[0][i].id;
                var name = response[0][i].name;
                $('.phaseFilter').append('<option value="' + id + '">' + name + '</option>' );
            }
            for(var i = 0; i < response[1].length; i++) {
                var id = response[1][i].id;
                var name = response[1][i].name;
                if(response[1][i].parent == 0) {
                    $('.expertiseFilter').append('<option value="' + id + '">' + name + '</option>' );
                }
            }
          }
        });
	}
});

$('.refreshFilter').click(function() {
	var user = $('.userFilter').val();
	var project = $('.projectFilter').val();
	var phase = $('.phaseFilter').val();
	var expertise = $('.expertiseFilter').val();
	var startDateFilter = $('.startDateFilter').val();
	var endDateFilter = $('.endDateFilter').val();
	var approvedFilter = $('.approvedFilter').is(":checked");

	$.ajax({
	      type: "POST",
	      url: '/management/hoursApproval/filter',
	      data: {
	        'user' : user,
	        'project' : project,
	        'phase' : phase,
	        'expertise' : expertise,
	        'startDateFilter' : startDateFilter,
	        'endDateFilter' : endDateFilter,
	        'approvedFilter' : approvedFilter
          },
          success: function(response) {
          	console.log(response);
          	$('.approvalTable tbody').empty();
          	for(var i = 0; i < response.length; i++) {
          		if(response[i].t_ap == 0) {
          			$('.approvalTable tbody').append('<tr class="text-center">' +
													'<td> ' + response[i].date + '</td>' +
													'<td>'+ response[i].u_name + '</td>' +
													'<td>'+ ("0" + response[i].p_number).slice(-5) + ' - ' + response[i].p_name +'</td>' +
													'<td>'+ response[i].ph_name +'</td>' +
													'<td>'+ response[i].e_name +'</td>' +
													'<td>'+ response[i].t_name +'</td>' +
													'<td>'+ ("0" + response[i].t_hours).slice(-2) +':'+ ("0" + response[i].t_min).slice(-2) +'</td>' +
													'<td class="taskNotApproved"><input content="'+ response[i].t_id +'"class="approvalCheckbox" type="checkbox"></td>' +
												'</tr>');
          		} else {
          			$('.approvalTable tbody').append('<tr class="text-center">' +
													'<td> ' + response[i].date + '</td>' +
													'<td>'+ response[i].u_name + '</td>' +
													'<td>'+ response[i].p_number +'</td>' +
													'<td>'+ response[i].ph_name +'</td>' +
													'<td>'+ response[i].e_name +'</td>' +
													'<td>'+ response[i].t_name +'</td>' +
													'<td>'+ ("0" + response[i].t_hours).slice(-2) +':'+ ("0" + response[i].t_min).slice(-2) +'</td>' +
													'<td class="taskApproved"><input content="'+ response[i].t_id +'"class="approvalCheckbox" checked type="checkbox"></td>' +
												'</tr>');
          		}
          		
          	}
          }
      });

});

</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>