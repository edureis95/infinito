<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/datepicker-pt.js"></script>

<div id="myNav" class="overlay">
  <!-- Button to close the overlay navigation -->
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

<form id="editContactForm" enctype="multipart/form-data">
<div class="panel panel-default borderless pull-right">
	<div class="panel-heading nameAndButtons">
		<button class="btn btn-warning editDescriptionButton pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button><button class="btn btn-danger cancelEditDescription hidden pull-right" type="button"><i class="glyphicon glyphicon-edit"></i></button>
		<button type="button" class="hidden saveContact btn btn-success pull-right">Guardar</button>
		<button class="btn btn-danger removeContact pull-right" type="button">Remover Contacto</button>
		<h3 style="padding-left: 6px;"><b><span class="overlayFirstName"></span> <span class="overlayLastName"></span></b></h3>
	</div>
  <div class="panel panel-info">
  		<div class="panel-heading smallPanelHeading">
  			<h5>
  				<span>Informações do Contacto</span>
  			</h5>
  		</div>
  		<div class="panel-body">
  			<div class="descriptionTable">
	  			<div class="col-xs-10">
		  			<table class="table borderless descriptionTable" style="margin-bottom: 0;">
		  				<tr>
		  					<td>Primeiro Nome: <span class="overlayDetail overlayFirstName">Eduardo</span></td>
		  					<td>Nomes do Meio: <span class="overlayDetail overlayMiddleNames">Jorge Duarte</span></td>
		  					<td>Último Nome: <span class="overlayDetail overlayLastName">Reis</span></td>
		  				</tr>
		  				<tr>
		  					<td> Email: <span class="overlayDetail overlayEmail">edureis95@hotmail.com</span></td>
		  					<td> Telemóvel: <span class="overlayDetail overlayPhoneNumber">966652665</span></td>
		  					<td> Skype: <span class="overlayDetail overlaySkype">966652665</span></td>		  				
		  				</tr>
		  				<tr>
		  					<td> Empresa: <span class="overlayDetail overlayCompany">Elemento Finito</span></td>
		  					<td> Posição: <span class="overlayDetail overlayCompanyPosition">Diretor</span></td>
		  				</tr>
		  				<tr>
		  					<td> Tipo de Contacto: <span class="overlayDetail overlayContactType">Elemento Finito</span></td>
		  					<td> Origem: <span class="overlayDetail overlaySource">Diretor</span></td><!-- dropdowns-->
		  					<td> Responsável do Contacto: <span class="overlayDetail overlayResponsible">Diretor</span></td> <!--dropdown empresa-->
		  				</tr>
		  			</table>
	  			</div>
	  			<div class="col-xs-2" style="padding: 0;">
	  				<img class="img img-thumbnail overlayPhoto" src="/uploads/avatars/default.jpg" style="max-width: 100px; max-height: 100px; margin-left: 37%;">
	  			</div>
  			</div>
  			<div class="editTable hidden">
  				<div class="row">
			  			<div class="col-xs-10">
				  			<table class="table borderless information" style="">
				  				<tr>
				  					<td><span class="inputLabel">Primeiro Nome: </span><input class="overlayInputFirstName form-control" name="firstName" type="text"> </td>
				  					<td><span class="inputLabel">Nomes do Meio: </span><input class="overlayInputMiddleNames form-control" name="middleName" type="text"></td>
				  					<td><span class="inputLabel">Último Nome: </span><input class="overlayInputLastName form-control" name="lastName" type="text"></td>
				  				</tr>
				  				<tr>
				  					<td><span class="inputLabel">Email: </span><input class="overlayInputEmail form-control" name="email" type="text"></td>
				  					<td><span class="inputLabel">Telemóvel: </span><input class="overlayInputPhoneNumber form-control" name="phoneNumber" type="text"></td>
				  				</tr>
				  				<tr>
				  					<td> 
				  						<span class="inputLabel">Empresa: </span>
				  						<select class="overlayInputCompany form-control" name="company">
				  							<option value="0">Sem Empresa</option>
					  						<?php $__currentLoopData = $companyContacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					  						<option value="<?php echo e($contact->id); ?>"><?php echo e($contact->name); ?></option>
					  						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				  						</select>
				  						</td>
				  				</tr>
				  			</table>
			  			</div>
			  			<div class="col-xs-2">
			  				<img class="img img-thumbnail overlayInputPhoto" src="/uploads/avatars/default.jpg" style="max-width: 100px; max-height: 100px; margin-left: 37%;">
			  				<input id="input" name="photo" type="file" class="file" data-show-upload="false" data-show-caption="true">
								<script>
									$("#input").fileinput({
										language: "pt",
										allowedFileExtensions: ["jpg", "png", "gif"]
									});
								</script>
			  			</div>
	  			</div>
			</div>
  		</div>
  </div>


  <div class="panel panel-info">
  		<div class="panel-heading smallPanelHeading">
  			<h5>
  				<span>Sobre o Contacto</span>
  			</h5>
  		</div>
  		<div class="panel-body">
  			<div class="descriptionTable">
	  			<div class="col-xs-9">
		  			<table class="table borderless" style="">
		  				<tr>
		  					<td> Data de Nascimento: <span class="overlayDetail overlayBirthDate">11-09-1995</span></td>
		  				</tr>
		  				<tr>
		  					<td> Morada: <span class="overlayDetail overlayAddress">Urb. Cidade do Sol Nº 22</span></td>
		  					<td> Nº de Porta: <span class="overlayDetail overlayDoorNumber">22</span></td>
		  					<td> Cidade: <span class="overlayDetail overlayCity">Lamego</span></td>
		  				</tr>
		  				<tr>
		  					<td> Distrito: <span class="overlayDetail overlayRegion">Viseu</span></td>
		  					<td> Cód. Postal: <span class="overlayDetail overlayZipCode">5100-215</span></td>
		  					<td> País: <span class="overlayDetail overlayCountry">Portugal</span></td>
		  				</tr>
		  			</table>
	  			</div>
  			</div>
  			<div class="editTable hidden">
  				<div class="row">

			  			<div class="col-xs-12">
				  			<table class="table borderless information" style="">
				  				<tr>
				  					<td><span class="inputLabel">Data de Nascimento: </span><input class="overlayInputBirthDate form-control datepicker" name="birthDate" type="text"></td>
				  				</tr>
				  				<tr>
				  					<td><span class="inputLabel">Morada: </span><input class="overlayInputAddress form-control" name="address" type="text"></td>
				  					<td><span class="inputLabel">Nº de Porta: </span><input class="overlayInputDoorNumber form-control" name="doorNumber" type="text"></td>
				  					<td><span class="inputLabel">Cidade: </span><input class="overlayInputCity form-control" name="city" type="text"></td>
				  				</tr>
				  				<tr>
				  					<td><span class="inputLabel">Distrito: </span><input class="overlayInputRegion form-control" name="region" type="text"></td>
				  					<td><span class="inputLabel">Cód. Postal: </span><input class="overlayInputZipCode form-control" name="zip_code" type="text"></td>
				  					<td><span class="inputLabel">País: </span><select class="overlayInputCountry form-control bfh-countries" name="country" data-country="PT"></select></td>
				  				</tr>
				  			</table>
			  			</div>
	  			</div>
			</div>
  		</div>
  </div>



  <div class="panel panel-info">
  		<div class="panel-heading smallPanelHeading">
  			<h5>
  				<span>Envolvimento</span>
  			</h5>
  		</div>
  		<div class="panel-body">
  			<div class="col-xs-9">
	  			<table class="table borderless" style="">
	  				<tr>
	  					<td>Projetos: <span class="overlayComunicationProjects">Não trabalhou em nenhum</span></td>
	  				</tr>
	  			</table>
  			</div>
  		</div>
  	</div>
</div>
</form>
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
        <form action="/contacts/createContact" enctype="multipart/form-data" method="POST">
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
					<td class="text-right">Empresa</td>
					<td>
						<select class="form-control" name="company">
							<option value="0">Sem Empresa</option>
							<?php $__currentLoopData = $companyContacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($contact->id); ?>"><?php echo e($contact->name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="text-right">Data de Nascimento</td>
					<td><input class="form-control datepicker" name="birthDate"></td>
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
	<button style="padding: 3px 5px; margin-right: 5%; margin-top: 0.5%; background-color: grey; color: white; font-size: 12px;" class="btn addType pull-right" data-toggle="modal" data-target="#myModal" type="button">Filtro</button>
	<button style="padding: 3px 5px; margin-right: 5%; margin-top: 0.5%; font-size: 12px;" class="btn btn-primary addType pull-right" data-toggle="modal" data-target="#myModal" type="button"><i class="glyphicon glyphicon-plus"></i> Contacto</button>
	<div class="panel panel-default borderless" style="margin-top: 19px;">
		<div class="panel-body" style="padding-left: 0;">
			<table class="table smallFontTable">
				<thead>
					<th class="text-center">Foto</th>
					<th class="text-left">Nome</th>
					<th class="text-left">Telemóvel</th>
					<th class="text-left">Email Principal</th>
					<th class="text-left">Skype</th>
					<th class="text-left">Empresa</th>
					<th class="text-left">Posição</th>
				</thead>
				<tbody>
				<?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr class="text-left">
						<td class="text-center"><img src="/uploads/contacts/<?php echo e($contact->photo); ?>" style="max-width: 30px;"></td>
						<td class="buttonCursor openContactLayer" content="<?php echo e($contact->id); ?>" style="padding-top: 5px !important"><?php echo e($contact->firstName); ?> <?php echo e($contact->lastName); ?></td>
						<td style="padding-top: 5px !important"><?php echo e($contact->phoneNumber); ?></td>
						<td style="padding-top: 5px !important"><?php echo e($contact->email); ?></td>
						<td style="padding-top: 5px !important"><?php echo e($contact->skype); ?> edureis95</td>
						<td style="padding-top: 5px !important"><?php echo e($contact->company != null ? $companyContacts->find($contact->company)->name : ""); ?></td>
						<td style="padding-top: 5px !important">Diretor</td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>

<script>
$( function() {
	$( ".datepicker" ).datepicker();
    $( ".datepicker" ).datepicker("option", "dateFormat",'yy-mm-dd');
});

$('.removeContact').click(function() {
	var txt;
	var r = confirm("Tem a certeza que quer eliminar este contacto?");
	if (r == true) {
	    $.ajax({
		  type: "POST",
		  url: '/contacts/removeContact',
		  data: {
		    'id' : idClicked
		  },
		  success: function() {
		  	location.reload();
		  }
		});
	} else {
	   
	}
})

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}

$('.editDescriptionButton').click(function() {
	$(this).addClass('hidden');
	$('.cancelEditDescription').removeClass('hidden');
	$('.editTable').removeClass('hidden');
	$('.descriptionTable').addClass('hidden');
	$('.saveContact').removeClass('hidden');
});

$('.cancelEditDescription').click(function() {
	$(this).addClass('hidden');
	$('.editDescriptionButton').removeClass('hidden');
	$('.editTable').addClass('hidden');
	$('.descriptionTable').removeClass('hidden');
	$('.saveContact').addClass('hidden');
})

var idClicked = null
$('.openContactLayer').click(function() {
	idClicked = $(this).attr('content');
	$.ajax({
	  type: "POST",
	  url: '/contacts/getContactDetails',
	  data: {
	    'id' : idClicked
	  },
	  success: function(response) {
	  	$('#myNav').css('width', 'calc(96% - 170px)');
	  	//DisplayLayer
	  	$('.overlayFirstName').text(response.firstName != null ? response.firstName : " -");
	  	$('.overlayMiddleNames').text(response.middleName != null ? response.middleName : " -");
	  	$('.overlayLastName').text(response.lastName != null ? response.lastName : " -");
	  	$('.overlayBirthDate').text(response.birthDate != null ? response.birthDate : " -");
	  	$('.overlayEmail').text(response.email != null ? response.email : " -");
	  	$('.overlayPhoneNumber').text(response.phoneNumber != null ? response.phoneNumber : " -");
	  	$('.overlayAddress').text(response.address != null ? response.address : " -");
	  	$('.overlayDoorNumber').text(response.doorNumber != null ? response.doorNumber : " -");
	  	$('.overlayCity').text(response.city != null ? response.city : " -");
	  	$('.overlayRegion').text(response.region != null ? response.region : " -");
	  	$('.overlayZipCode').text(response.zip_code != null ? response.zip_code : " -");
	  	$('.overlayCountry').text(response.country != null ? response.country : " -");
	  	$('.overlayCompany').text(response.companyName);
	  	$('.overlayPhoto').attr('src', '/uploads/contacts/' + response.photo);
	  	//EditLayer
	  	$('.overlayInputFirstName').val(response.firstName);
	  	$('.overlayInputMiddleNames').val(response.middleName);
	  	$('.overlayInputLastName').val(response.lastName);
	  	$('.overlayInputBirthDate').val(response.inputBirthDate);
	  	$('.overlayInputEmail').val(response.email);
	  	$('.overlayInputPhoneNumber').val(response.phoneNumber);
	  	$('.overlayInputAddress').val(response.address);
	  	$('.overlayInputDoorNumber').val(response.doorNumber);
	  	$('.overlayInputCity').val(response.city);
	  	$('.overlayInputRegion').val(response.region);
	  	$('.overlayInputZipCode').val(response.zip_code);
	  	$('.overlayInputCountry option[value="'+ response.country + '"]').prop('selected', true);
	  	if(response.company != null) {
	  		$('.overlayInputCompany option[value="'+ response.company +'"]').prop('selected', true);
	  	} else {
	  		$('.overlayInputCompany option[value="0"]').prop('selected', true);
	  	}
	  	$('.overlayInputPhoto').attr('src', '/uploads/contacts/' + response.photo);
	  	$('.overlayComunicationProjects').text(response.projectsWorked != null ? response.projectsWorked : " -");
	  }
	 });
});

$('.saveContact').click(function() {
	var formData = new FormData($('#editContactForm')[0]);
    formData.append('id', idClicked);
	$.ajax({
		type: 'POST',
		url: '/contacts/editContact',
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

</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>