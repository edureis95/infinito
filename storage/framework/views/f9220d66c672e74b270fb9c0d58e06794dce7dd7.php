

<?php $__env->startSection('content'); ?>

<div class="col-xs-7" style="padding: 0%;">
	<?php echo $__env->make('layouts.gestao_projetos_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default">
		<div class="panel-body members">
			<table class="table borderless" style="width:auto;">
			<th>Código</th>
			<th>Nome</th>
			<th>Ações</th>
			<?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
			<?php if($project->number < 10000): ?>
				<td><a href="project/<?php echo e($project->id); ?>">0<?php echo e($project->number); ?></a></td>
			<?php else: ?>
				<td><a href="project/<?php echo e($project->id); ?>"><?php echo e($project->number); ?></a></td>
			<?php endif; ?>
			<td><a href="project/<?php echo e($project->id); ?>"><?php echo e($project->name); ?></a></td>
			<td>
			<button content='<?php echo e($project->id); ?>' style="padding: 3px 5px;" class="btn btn-danger removeProject" type="button"><i class="glyphicon glyphicon-minus"></i></button>
			<button style="padding: 3px 5px;" class="btn btn-primary editProject" data-toggle="modal" data-id="<?php echo e($project->id); ?>" data-target="#myModal" type="button"><i class="glyphicon glyphicon-edit"></i></button>
			</td>
			</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</table>
		</div>
	</div>

	<div class="panel panel-info newProjectForm hidden">
		<div class="panel-heading">
			<h4>Novo Projeto</h4>
		</div>
		<div class="panel-body">
			
		</div>
	</div>
	
</div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edita projeto</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" action="projects/edit" method="POST">
				<div class="panel-group">
					<div class="panel panel-info">
						<div class="panel-heading" style="height: 40px;">
							<p>Dados do projeto</p>
						</div>
						<div class="panel-body">
							  <div class="form-group">
							    <label for="input1" class="col-lg-2 control-label">Código</label>
							    <div class="col-md-5">
							      <input style="width: 50px;display:inline;" type="text" class="form-control number input-medium bfh-phone" data-format="dd" name="code">
							      <input type="text" style="display:inline; width: 60px;" class="form-control number input-medium bfh-phone" data-format="ddd" name="secondCode">
							    </div>
							  </div>
							  <div class="form-group">
							    <label for="input2" class="col-lg-2 control-label">Nome</label>
							    <div class="col-lg-4">
							      <input type="text" class="form-control" name="name">
							    </div>
							  </div>
							  <div class="form-group">
							    <label for="input2" class="col-lg-2 control-label">Título</label>
							    <div class="col-lg-4">
							      <input type="text" class="form-control" name="title">
							    </div>
							  </div>
							  <div class="form-group">
							    <label for="input2" class="col-lg-2 control-label">Local</label>
							    <div class="col-lg-4">
							      <textarea class="form-control" id="input2" name="address"></textarea>
							    </div>
							  </div>
							  <div class="form-group">
							  	<label for="input2" class="col-lg-2 control-label" style="padding-top: 0;">Tipo</label>
							    <div class="col-lg-4">
							      <select class="form-control" name="type">
							      	<?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							      	<option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
							      	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							      </select>
							    </div>
							  </div>
							  <div class="form-group">
							    <label for="input2" class="col-lg-2 control-label" style="padding-top: 0;">Área de construção</label>
							    <div class="col-lg-4">
							      <input type="number" class="form-control" name="constructionArea"></input>
							    </div>
							  </div>
							  <div class="form-group">
							    <label for="input2" class="col-lg-2 control-label" style="padding-top: 0;">Área total de projeto</label>
							    <div class="col-lg-4">
							      <input type="number" class="form-control" name="totalArea"></input>
							    </div>
							  </div>
							  <div class="form-group">
							    <label for="input2" class="col-lg-2 control-label" style="padding-top: 0;">Valor do Projeto</label>
							    <div class="col-lg-4">
							      <input type="number" class="form-control" name="value"></input>
							    </div>
							  </div>
							</div>

						</div>
					</div>
					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
					<input type="hidden" name="projectId" id="projectId">
						<div class="form-group row">
							<div class="col-md-offset-3 col-md-3">
								<input type="submit" class="btn btn-primary">
							</div>
							<div class="col-md-offset-3 col-md-3">
								<button type="button" class="btn btn-default cancelNewProject">Cancelar</button>
							</div>
						</div>
					</div>
				</div>
		</form>
      </div>
    </div>

  </div>
</div>

<script>

$('.removeProject').click(function() {
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
});

$('.editProject').click(function() {
	var projectId = $(this).data('id');
	$('#myModal #projectId').val(projectId);
});

$('.buttonCursor').click(function() {
	var redirect = $(this).attr('id');
	window.location.replace(redirect);
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>