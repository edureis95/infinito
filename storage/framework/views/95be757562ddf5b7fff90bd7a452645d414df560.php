<?php $__env->startSection('content'); ?>

<div class="col-xs-12 insideContainer">
	<?php echo $__env->make('layouts.settings_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->make('layouts.project_settings_2nd_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body" style="">
			<button class="dropdown-toggle addFunction btn btn-primary" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-left: 93%;">
					<span style="font-size: 12px;">Adicionar</span>
			</button>
			<div class="formButtons hidden">
				<button class="dropdown-toggle cancelFunction btn btn-danger" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-left: 80%;">
					<span style="font-size: 12px;">Cancelar</span>
				</button>
				<button class="dropdown-toggle saveFunction btn btn-primary" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-left: 93%;">
						<span style="font-size: 12px;">Guardar</span>
				</button>
			</div>
			<table class="smallFontTable table">
				<thead>
					<th class="text-center">Código</th>
					<th class="text-center">Sigla</th>
					<th class="text-left">Nome</th>
					<th></th>
				</thead>
				<tbody class="text-center">
					<tr class="hidden hiddenForm">
						<form action="/settings/projects/userFunction/addFunction" method="POST">
							<td><input class="input-sm form-control" required name="code" type="text"></td>
							<td><input class="input-sm form-control" required name="sigla" type="text"></td>
							<td><input class="input-sm form-control" required name="name" type="text"></td>
							<td class="hidden"><input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"></td>
							<td class="hidden"><button type="submit" class="submitButton">Guardar</button></td>
						</form>
					</tr>
					<?php $__currentLoopData = $functions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $function): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr class="functionEdit<?php echo e($function->id); ?> hidden">
						<td><input class="input-sm form-control codeInput" required name="code" value="<?php echo e($function->code); ?>" type="text"></td>
						<td><input class="input-sm form-control siglaInput" required name="sigla" type="text" value="<?php echo e($function->sigla); ?>"></td>
						<td><input class="input-sm form-control nameInput" required name="name" type="text" value="<?php echo e($function->name); ?>"></td>
						<td class="text-center">
							<button class="btn btn-xs btn-danger cancelEdit" content="<?php echo e($function->id); ?>"><i class="glyphicon glyphicon-edit"></i></button>
							<button class="btn btn-xs btn-success saveEdit" content="<?php echo e($function->id); ?>"><i class="glyphicon glyphicon-check"></i></button>
						</td>
					</tr>
					<tr class="function<?php echo e($function->id); ?>">
						<td><?php echo e(str_pad($function->code, 3, '0', STR_PAD_LEFT)); ?></td>
						<td><?php echo e($function->sigla); ?></td>
						<td class="text-left"><?php echo e($function->name); ?></td>
						<td class="text-center">
							<button class="btn btn-warning btn-xs editFunction" content="<?php echo e($function->id); ?>"><i class="glyphicon glyphicon-edit"></i></button>
							<button content='<?php echo e($function->id); ?>' class="btn btn-danger btn-xs removeFunction" type="button"><i class="glyphicon glyphicon-minus"></i></button>
						</td>
					</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('.addFunction').click(function() {
		$(this).addClass('hidden');
		$('.formButtons').removeClass('hidden');
		$('.hiddenForm').removeClass('hidden');
	})

	$('.cancelFunction').click(function() {
		$('.formButtons').addClass('hidden');
		$('.hiddenForm').addClass('hidden');
		$('.addFunction').removeClass('hidden');
	})

	$('.saveFunction').click(function() {
		$('.submitButton').click();
	})

	$('.editFunction').click(function() {
		var id = $(this).attr('content');
		$('.function' + id).addClass('hidden');
		$('.functionEdit' + id).removeClass('hidden');
	})

	$('.cancelEdit').click(function() {
		var id = $(this).attr('content');
		$('.function' + id).removeClass('hidden');
		$('.functionEdit' + id).addClass('hidden');
	})

	$('.saveEdit').click(function() {
		var id = $(this).attr('content');
		var code = $('.functionEdit' + id + ' .codeInput').val();
		var sigla = $('.functionEdit' + id + ' .siglaInput').val();
		var name = $('.functionEdit' + id + ' .nameInput').val();
		$.ajax({
			method: 'POST',
			url: '/settings/projects/userFunction/editFunction',
			data: {
				id: id,
				code: code,
				sigla: sigla,
				name: name
			},
			success: function() {
				location.reload();
			}
		})
	})

	$('.removeFunction').click(function() {
		var id = $(this).attr('content');
		var txt;
		var r = confirm("Tem a certeza que quer eliminar esta função?");
		if (r == true) {
			$.ajax({
				method: 'POST',
				url: '/settings/projects/userFunction/removeFunction',
				data: {
					id: id
				},
				success: function() {
					location.reload();
				}
			})
		}
	})
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>