<form enctype="multipart/form-data" action="/project/client/new" method="POST">
	<div class="form-group row">
		<label class="col-md-4 col-form-label vcenter" style="text-align: right;">Nome</label>
		<div class="col-md-6 vcenter">
			<input class="form-control" type="text" value="" name="name">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label vcenter" style="text-align: right;">Morada</label>
		<div class="col-md-6 vcenter">
			<input class="form-control" type="text" value="" name="address">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label vcenter" style="text-align: right;">Cidade</label>
		<div class="col-md-6 vcenter">
			<input class="form-control" type="text" value="" name="city">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label vcenter" style="text-align: right;">País</label>
		<div class="col-md-6 vcenter">
			<input class="form-control" type="text" value="" name="country">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label vcenter" style="text-align: right;">Contacto</label>
		<div class="col-md-6 vcenter">
			<input class="form-control" type="text" value="" name="contact">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label vcenter" style="text-align: right;">Nome do Representante</label>
		<div class="col-md-6 vcenter">
			<input class="form-control" type="text" value="" name="representant_name">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label vcenter" style="text-align: right;">Contacto do Representante</label>
		<div class="col-md-6 vcenter">
			<input class="form-control" type="text" value="" name="representant_contact">
		</div>
	</div>

	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<div class="form-group row">
		<div class="col-md-offset-4 col-md-3">
			<input type="submit" class="btn btn-sm btn-primary">
		</div>
	</div>
</form>