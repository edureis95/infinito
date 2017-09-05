<?php $__env->startSection('content'); ?>

<div class="col-md-11">
	<div class="panel panel-default">
		<div class="panel-body">
			<form action="/contacts/createContact" method="POST">
				<table class="table borderless" style="width: auto;">
					<tr>
						<td class="text-right"><span style="color:red;">*</span> Primeiro Nome </td>
						<td><input required class="form-control" name="firstName" type="text"></td>
					</tr>
					<tr>
						<td class="text-right"><span style="color:red;">*</span> Último Nome </td>
						<td><input required class="form-control" name="lastName" type="text"></td>
					</tr>
					<tr>
						<td class="text-right">Nomes do Meio</td>
						<td><input class="form-control" name="middleName" type="text"></td>
					</tr>
					<tr>
						<td class="text-right">Data de Nascimento</td>
						<td><input class="form-control" name="birthDate" type="date"></td>
					</tr>
					<tr>
						<td class="text-right">Email</td>
						<td><input class="form-control" name="email" type="email"></td>
					</tr>
					<tr>
						<td class="text-right">Telemóvel</td>
						<td><input class="form-control" name="phoneNumber" type="text"></td>
					</tr>
					<tr>
						<td class="text-right">Morada</td>
						<td><input class="form-control" name="address" type="text"></td>
					</tr>
					<tr>
						<td class="text-right">Nº de Porta</td>
						<td><input class="form-control" name="doorNumber" type="text"></td>
					</tr>
					<tr>
						<td class="text-right">Cidade</td>
						<td><input class="form-control" name="city" type="text"></td>
					</tr>
					<tr>
						<td class="text-right">Distrito</td>
						<td><input class="form-control" name="region" type="text"></td>
					</tr>
					<tr>
						<td class="text-right">Código Postal</td>
						<td><input class="form-control" name="zip_code" type="text"></td>
					</tr>
					<tr>
						<td class="text-right">País</td>
						<td>
							<select class="form-control bfh-countries" name="country" data-country="PT"></select>
						</td>
					</tr>
					<tr></tr>
					<tr>
						<td><button class="btn btn-success" type="submit">Criar</button></td>
					</tr>
				</table>
				<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
			</form>
		</div>
	</div>
</div>

<script>

</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>