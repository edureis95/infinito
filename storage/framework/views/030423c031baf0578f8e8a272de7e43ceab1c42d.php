<?php $__env->startSection('content'); ?>

<div class="col-xs-12" style="max-width: 98%;">
	<?php echo $__env->make('layouts.gestao_projetos_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body members" style="padding-left: 0;">

			<div class="col-xs-12">
				<div class="dropdown" style="margin-left: 94%; margin-bottom: 2%;">
					<button class="dropdown-toggle btn btn-primary" data-toggle="dropdown">
						<span>Filtro</span>
					</button>
					<ul class="dropdown-menu dropdown-form pull-right">
	                    <li>
	                    	<div class="col-xs-12">
								<table class="table borderless" style="width: 75%;">
									<tr>
										<td> Ano </td>
										<td>
											<select class="form-control yearFilter">
												<option value="0">Sem Filtro</option>
											</select>
										</td>
									</tr>

									<tr>
										<td>Especialidade</td>
										<td>
											<select class="form-control expertiseFilter">
												<option value="0">Sem filtro</option>
												<?php $__currentLoopData = $expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php if($expert->parent == 0): ?>
													<?php if(isset($filter) and $filter->expertise == $expert->id): ?>
													<option selected value="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></option>
													<?php else: ?>
													<option value="<?php echo e($expert->id); ?>"><?php echo e($expert->name); ?></option>
													<?php endif; ?>
												<?php endif; ?>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Estado</td>
										<td>
											<select class="form-control stateFilter">
												<option value="0">Sem filtro</option>
												<?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<?php if(isset($filter) and $filter->state == $state->id): ?>
													<option selected value="<?php echo e($state->id); ?>"><?php echo e($state->name); ?></option>
													<?php else: ?>
													<option value="<?php echo e($state->id); ?>"><?php echo e($state->name); ?></option>
													<?php endif; ?>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
										</td>
									</tr>
									</tr>
									<td></td>
									</tr>
									<tr>
									<td></td>
									</tr>
								</table>
							</div>
	                    </li>   
	                </ul>
				</div>
			</div>

			
			<div class="col-xs-12">
				<table class="table smallFontTable projectsTable">
				<thead>
					<th class="text-center">Código</th>
					<th class="text-left">Nome</th>
					<th class="text-center">Descrição</th>
					<th class="text-center">Área</th>
					<th class="text-center">Especialidades</th>
					<th class="text-center">Estado</th>
				</thead>
				<tbody class="text-center">
				<?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><a href="project/<?php echo e($project->id); ?>"><?php echo e(str_pad($project->number, 5, '0', STR_PAD_LEFT)); ?></a></td>
						<td class="text-left"><a href="project/gantt/<?php echo e($project->id); ?>"><?php echo e($project->name); ?></a></td>
						<td><a href="project/gantt/<?php echo e($project->id); ?>"><?php echo e($project->title); ?></a></td>
						<td><a href="project/gantt/<?php echo e($project->id); ?>"><?php echo e($project->totalArea); ?></a></td>
						<td><a href="project/gantt/<?php echo e($project->id); ?>"><?php echo e($project->expertise); ?></a></td>
						<td><?php echo e($project->state); ?></td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
				</table>
			</div>
		</div>
	</div>
	
</div>
</div>
<script>

function appendYears() {
	var i,yr,now = new Date();

	for (i=0; i>=0; i++) {
	    yr = 2006 + i; // or whatever
	    console.log(yr);
	    <?php if(isset($filter)): ?>
	    	if(yr == <?php echo e($filter->year); ?>)
	    		$('.yearFilter').append($('<option/>').val(yr).text(yr).prop('selected', true));
	    	else
	    		$('.yearFilter').append($('<option/>').val(yr).text(yr));
	    <?php else: ?>
	    $('.yearFilter').append($('<option/>').val(yr).text(yr));
	    <?php endif; ?>
	    if(yr == now.getFullYear())
	    	break;
	}
}

appendYears();

$('.dropdown-form select').click(function(e) {
	e.stopPropagation();
});

$('.yearFilter').change(function() {
	refreshFilter();
});

$('.expertiseFilter').change(function() {
	refreshFilter();
});

$('.stateFilter').change(function() {
	refreshFilter();
});

function refreshFilter() {
	var year = $('.yearFilter').val();
	var expertise = $('.expertiseFilter').val();
	var state = $('.stateFilter').val();
	$.ajax({
		type: "POST",
		url: '/projects/filterProjects',
		data: {
			'year': year,
			'expertise': expertise,
			'state': state
		},
		success: function(response) {
			$('.projectsTable tbody').empty();
			for(var i = 0; i < response.length; i++) {
				var toAppend = '<tr>'+
						'<td><a href="project/gantt/' + response[i].id + '">'+("0" + response[i].number).slice(-5)+'</a></td>'+
					'<td class="text-left"><a href="project/gantt/'+response[i].id+'">'+response[i].name+'</a></td>'+
					'<td><a href="project/gantt/'+response[i].id+'">'+response[i].title+'</a></td>'+
					'<td><a href="project/gantt/'+response[i].id+'">'+response[i].totalArea+'</a></td>'+
					'<td><a href="project/gantt/'+response[i].id+'">'+response[i].expertise+'</a></td>'+
					'<td>'+ response[i].state + '</td>'+
					'</tr>';
				$('.projectsTable tbody').append(toAppend);
			}
		}
	});
}


/*
$('.projectsTable').on('click', '.removeProject', function() {
	var id = $(this).attr('content');
	$(this).parent().parent().remove();
	$.ajax({
      type: "POST",
      url: '/projects/removeProject',
      data: {
      	'id': id
      },
      success: function(response) {
      }
    });
});*/

$('.projectsTable').on('click', '.editProject', function() {
	var projectId = $(this).data('id');
	$('#myModal #projectId').val(projectId);
	$.ajax({
      type: "GET",
      url: '/projects/getProjectDetails/' + projectId,
      success: function(response) {
      	console.log(response);
      	$('.nameInput').val(response.name);
      	if(response.constructionArea != null)
      		$('.constructionAreaInput').val(response.constructionArea);
      	if(response.local != null)
      		$('.localInput').val(response.local);
      	if(response.title != null)
      		$('.titleInput').val(response.title);
      	if(response.value != null)
      		$('.valueInput').val(response.value);
      	if(response.zip_code != null)
      		$('.zip_codeInput').val(response.zip_code);
      	if(response.address != null)
      		$('.addressInput').val(response.address);
      	if(response.totalArea != null)
      		$('.totalAreaInput').val(response.totalArea);
      	if(response.type != null)
      		$('.typeInput option:eq(' + response.type + ')').prop('selected', true);
      	if(response.numberBuriedFloors != null)
      		$('.numberBuriedFloorsInput').val(response.numberBuriedFloors);
      	if(response.totalNumberFloors != null)
      		$('.totalNumberFloorsInput').val(response.totalNumberFloors);
      	if(response.utilizationType != null)
      		$('.utilizationTypeInput option:eq(' + response.utilizationType + ')').prop('selected', true);
      	if(response.constructionType != null)
      		$('.constructionTypeInput option:eq(' + response.constructionType + ')').prop('selected', true);
      }
    });
});

$('.buttonCursor').click(function() {
	var redirect = $(this).attr('id');
	window.location.replace(redirect);
});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>