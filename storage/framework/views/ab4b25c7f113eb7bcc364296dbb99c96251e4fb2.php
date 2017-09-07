<?php $__env->startSection('content'); ?>

<div id="myNav" class="overlay">
  <!-- Button to close the overlay navigation -->
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="panel panel-default" style="margin-top: 8%;">
  	<div class="panel-info">
  		<div class="panel-heading smallPanelHeading">
  			<h5>
  				<span>Informações do Contacto</span>
  				<button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-success editDescriptionButton pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button><button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-danger cancelEditDescription hidden pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button>
  			</h5>
  		</div>
  		<div class="panel-body">
  			<div class="descriptionTable">
	  			<div class="col-xs-9">
		  			<table class="table borderless descriptionTable" style="">
		  				<tr>
		  					<td><b>Nome da Empresa: </b><span class="overlayName">Eduardo</span></td>
		  				</tr>
		  				<tr>
		  					<td><b>URL: </b><span class="overlayURL">Eduardo</span></td>
		  				</tr>
		  				<tr>
		  					<td><b>Pessoa Responsável: </b><span class="overlayResponsible">Eduardo</span></td>
		  				</tr>
		  				<tr>
		  					<td><b>Telefone: </b><span class="overlayPhoneNumber">Eduardo</span></td>
		  					<td><b>Email: </b><span class="overlayEmail">Eduardo</span></td>
		  				</tr>
		  			</table>
	  			</div>
	  			<div class="col-xs-3">
	  				<img class="img img-thumbnail overlayPhoto" style="max-width: 300px; max-height: 100px;" src="/uploads/avatars/default.jpg">
	  			</div>
  			</div>
  			<div class="editTable hidden">
  				<div class="row">
  					<form id="editContactForm" enctype="multipart/form-data">
			  			<div class="col-xs-9">
				  			<table class="table borderless" style="">
				  				<tr>
				  					<td><b>Nome da Empresa: </b><input class="overlayInputName form-control" type="text" name="name"></td>
				  				</tr>
				  				<tr>
				  					<td><b>URL: </b><input class="overlayInputURL form-control" type="text" name="url"></td>
				  				</tr>
				  				<tr>
				  					<td>
					  					<b>Pessoa Responsável: </b>
					  					<select class="overlayInputResponsible form-control" name="responsiblePerson">
					  						<option value="0">Sem Responsável</option>
					  						<?php $__currentLoopData = $usersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					  						<option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
					  						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					  					</select>
					  				</td>
				  				</tr>
				  			</table>
			  			</div>
			  			<div class="col-xs-3">
			  				<img class="img img-thumbnail overlayInputPhoto" src="/uploads/avatars/default.jpg">
			  				<input id="input" style="width: 100% !important;" name="photo" type="file" class="file" data-show-upload="false" data-show-caption="true">
								<script>
									$("#input").fileinput({
										language: "pt",
										allowedFileExtensions: ["jpg", "png", "gif"]
									});
								</script>
			  			</div>
		  			</form>
	  			</div>
	  			<div class="row">
	  				<div class="col-xs-2">
						<button type="button" class="saveContact btn btn-success">Guardar</button>
					</div>
				</div>
			</div>
  		</div>
  	</div>
  </div>
  <div class="panel panel-default">
  	<div class="panel-info">
  		<div class="panel-heading smallPanelHeading">
  			<h5>
  				<span>Outras Informações</span>
  				<button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-success editDescriptionButton pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button><button style="padding: 3px 5px; vertical-align: middle;" class="btn btn-danger cancelEditDescription hidden pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button>
  			</h5>
  		</div>
  		<div class="panel-body">
  			<div class="descriptionTable">
	  			<div class="col-xs-9">
		  			<table class="table borderless descriptionTable" style="">
		  				<tr>
		  					<td><b>Tipo de Empresa: </b><span class="overlayCompanyType">Eduardo</span></td><!--dropdown-->
		  					<td><b>Área: </b><span class="overlaCompanyArea">Eduardo</span></td><!--dropdown-->
		  					<td><b>Dimensão: </b><span class="overlayCompanySize">Eduardo</span></td><!--dropdown-->
		  				</tr>
		  				<tr>
		  					<td><b>NIF: </b><span class="overlayNIF">Eduardo</span></td>
		  				</tr>
		  				<tr>
		  					<td> <b>Morada: </b><span class="overlayAddress">Urb. Cidade do Sol Nº 22</span></td>
		  					<td> <b>Nº de Porta: </b><span class="overlayDoorNumber">22</span></td>
		  					<td> <b>Cidade: </b><span class="overlayCity">Lamego</span></td>
		  				</tr>
		  				<tr>
		  					<td> <b>Distrito: </b><span class="overlayRegion">Viseu</span></td>
		  					<td> <b>Cód. Postal: </b><span class="overlayZipCode">5100-215</span></td>
		  					<td> <b>País: </b><span class="overlayCountry">Portugal</span></td>
		  				</tr>
		  			</table>
	  			</div>
  			</div>
  			<div class="editTable hidden">
  				<div class="row">
  					<form id="editContactForm" enctype="multipart/form-data">
			  			<div class="col-xs-9">
				  			<table class="table borderless" style="">
				  				<tr>
				  					<td><span class="inputLabel">Tipo de Empresa:</span></td>
				  					<td>
				  						<select class="form-control">
				  						<?php $__currentLoopData = $contactTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				  						<option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
				  						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				  						</select>	
				  					</td>
				  					<td><b>Área: </b><span class="overlaCompanyArea">Eduardo</span></td><!--dropdown-->
				  					<td><b>Dimensão: </b><span class="overlayCompanySize">Eduardo</span></td><!--dropdown-->
				  				</tr>
				  				<tr>
				  					<td><b>NIF: </b><span class="overlayNIF">Eduardo</span></td>
				  				</tr>
				  				<tr>
				  					<td> <b>Morada: </b><span class="overlayAddress">Urb. Cidade do Sol Nº 22</span></td>
				  					<td> <b>Nº de Porta: </b><span class="overlayDoorNumber">22</span></td>
				  					<td> <b>Cidade: </b><span class="overlayCity">Lamego</span></td>
				  				</tr>
				  				<tr>
				  					<td> <b>Distrito: </b><span class="overlayRegion">Viseu</span></td>
				  					<td> <b>Cód. Postal: </b><span class="overlayZipCode">5100-215</span></td>
				  					<td> <b>País: </b><span class="overlayCountry">Portugal</span></td>
				  				</tr>
				  			</table>
			  			</div>
		  			</form>
	  			</div>
	  			<div class="row">
	  				<div class="col-xs-2">
						<button type="button" class="saveContact btn btn-success">Guardar</button>
					</div>
				</div>
			</div>
  		</div>
  	</div>
  </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Adicionar Novo Contacto</h4>
      </div>
      <div class="modal-body">
        <form action="/contacts/createCompanyContact" enctype="multipart/form-data" method="POST">
			<table class="table borderless" style="width: auto;">
				<tr>
					<td class="text-right"><span style="color:red;">*</span> Nome de Empresa </td>
					<td><input required class="form-control" name="name" type="text"></td>
				</tr>
				<tr>
					<td class="text-right">Pessoa Responsável</td>
					<td>
						<select class="form-control" name="responsible_user">
								<option value="0">Sem pessoa responsável</option>
							<?php $__currentLoopData = $usersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="text-right">Foto</td>
					<td><input id="input" name="photo" type="file" class="file" data-show-upload="false" data-show-caption="true"></td>
					<script>
						$("#input").fileinput({
							language: "pt",
							allowedFileExtensions: ["jpg", "png", "gif"]
						});
					</script>
				</tr>
				<tr>
					<td class="text-right"></span> URL </td>
					<td><input class="form-control" name="url" type="text"></td>
				</tr>
				<tr class="emailFiller">
					<td class="text-right">Email</td>
					<td>
						<input type="email" name="email[]" class="form-control">
			        </td>
			        <td style="padding-left: 0; padding-top: 2.5%;">
			        	<span class="input-group-btn">
	                        <button class="btn btn-success btn-add-email" type="button">
	                            <span class="glyphicon glyphicon-plus"></span>
	                        </button>
			            </span>
			        </td>
				</tr>
				<tr class="phoneFiller">
					<td class="text-right">Telemóvel</td>
					<td>
						<input type="text" name="phone[]" class="form-control">
			        </td>
			        <td style="padding-left: 0; padding-top: 2.5%;">
			        	<span class="input-group-btn">
	                        <button class="btn btn-success btn-add-phone" type="button">
	                            <span class="glyphicon glyphicon-plus"></span>
	                        </button>
			            </span>
			        </td>
				</tr>

				
			</table>
			<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			<button class="btn btn-success pull-right" type="submit">Adicionar</button>
			<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
		</form>
      </div>
    </div>

  </div>
</div>


<div class="col-xs-12 insideContainer">
	<?php echo $__env->make('layouts.contacts_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<table class="table smallFontTable">
				<thead>
					<th class="text-center">Logo</th>
					<th class="text-left">Nome</th>
					<th class="text-left">Telefone</th>
					<th class="text-left">Email</th>
					<th class="text-left">URL</th>
					<th class="text-left">Pessoa Responsável</th>
					<th class="text-center">
						<button style="padding: 3px 5px;" class="btn btn-primary addType" data-toggle="modal" data-target="#myModal" type="button"><i class="glyphicon glyphicon-plus"></i></button>
					</th>
				</thead>
				<tbody>
				<?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr class="text-left">
						<td class="text-center">
							<div >
								<img src="/uploads/company_contacts/<?php echo e($contact->photo); ?>" style="max-width: 100px; max-height: 33px;">
							</div>
						</td>
						<td class="openContactLayer buttonCursor" content="<?php echo e($contact->id); ?>"><?php echo e($contact->name); ?></td>
						<td>
						<?php if(count($contact->phones)): ?>
							<?php echo e($contact->phones->first()->phone); ?>

						<?php endif; ?>
						</td>
						<td>
						<?php if(count($contact->emails)): ?>
							<?php echo e($contact->emails->first()->email); ?>

						<?php endif; ?>
						</td>
						<td><?php echo e($contact->url); ?></td>
						<td><?php echo e($contact->responsible_name); ?></td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>

<script>

function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}

$('.editDescriptionButton').click(function() {
	$(this).addClass('hidden');
	$('.cancelEditDescription').removeClass('hidden');
	$('.editTable').removeClass('hidden');
	$('.descriptionTable').addClass('hidden');
});

$('.cancelEditDescription').click(function() {
	$(this).addClass('hidden');
	$('.editDescriptionButton').removeClass('hidden');
	$('.editTable').addClass('hidden');
	$('.descriptionTable').removeClass('hidden');
})

var idClicked = null
$('.openContactLayer').click(function() {
	idClicked = $(this).attr('content');
	$.ajax({
	  type: "POST",
	  url: '/contacts/getCompanyContactDetails',
	  data: {
	    'id' : idClicked
	  },
	  success: function(response) {
	  	$('#myNav').css('width', 'calc(96% - 170px)');
	  	//DisplayLayer
	  	$('.overlayName').text(response.name != null ? response.name : "-");
	  	$('.overlayURL').text(response.url != null ? response.url : "-");
	  	$('.overlayResponsible').text(response.responsible_name != null ? response.responsible_name : "-");
	  	$('.overlayPhoto').attr('src', '/uploads/company_contacts/' + response.photo);
	  	//EditLayer
	  	$('.overlayInputName').val(response.name);
	  	$('.overlayInputURL').val(response.url);
	  	if(response.responsible != null) {
	  		$('.overlayInputResponsible option[value="'+ response.responsible +'"]').prop('selected', true);
	  	} else {
	  		$('.overlayInputResponsible option[value="0"]').prop('selected', true);
	  	}
	  	$('.overlayInputPhoto').attr('src', '/uploads/company_contacts/' + response.photo);
	  }
	 });
});

$('.saveContact').click(function() {
	var formData = new FormData($('#editContactForm')[0]);
    formData.append('id', idClicked);
	$.ajax({
		type: 'POST',
		url: '/contacts/editCompanyContact',
		data: formData,
		processData: false,
        contentType: false,
        cache: false,
        success: function(){
        	location.reload();
        },
        error: function() {
        	console.log('error');
        }
	});

});

$(document).on('click', '.btn-add-email', function(e) {
    e.preventDefault();

   	$('.emailFiller').after('<tr class="email"><td></td><td><input type="email" name="email[]" class="form-control"></td><td style="padding-left: 0; padding-top: 2.5%;"><span class="input-group-btn"><button class="btn btn-danger btn-remove-email" type="button"><span class="glyphicon glyphicon-minus"></span></button></span></td></tr>')
});

$(document).on('click', '.btn-remove-email', function(e) {
	e.preventDefault();

	$(this).closest('tr').remove();
});

$(document).on('click', '.btn-add-phone', function(e) {
	e.preventDefault();

	$('.phoneFiller').after('<tr class="phone"><td></td><td><input type="text" name="phone[]" class="form-control"></td><td style="padding-left: 0; padding-top: 2.5%;"><span class="input-group-btn"><button class="btn btn-danger btn-remove-phone" type="button"><span class="glyphicon glyphicon-minus"></span></button></span></td></tr>');
});

$(document).on('click', '.btn-remove-phone', function(e) {
	e.preventDefault();

	$(this).closest('tr').remove();
});
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>