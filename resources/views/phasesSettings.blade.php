@extends('layouts.app')

@section('content')

<div class="col-xs-12 insideContainer">
	@include('layouts.settings_nav')
	@include('layouts.project_settings_2nd_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<button class="dropdown-toggle editButton btn btn-primary pull-right" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-right: 90px">
					<span style="font-size: 12px;">Editar</span>
			</button>
			<button class="dropdown-toggle hiddenFormButton btn btn-primary pull-right" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px;">
					<span style="font-size: 12px;">Adicionar</span>
			</button>
			<div class="editButtons hidden">
				<button class="dropdown-toggle cancelEdit btn btn-danger pull-right" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-right: 80px;">
					<span style="font-size: 12px;">Cancelar</span>
				</button>
				<button class="dropdown-toggle saveEdit btn btn-primary pull-right" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px;">
						<span style="font-size: 12px;">Guardar</span>
				</button>
			</div>
			<div class="formButtons hidden">
				<button class="dropdown-toggle cancelFunction btn btn-danger pull-right" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-right: 80px;">
					<span style="font-size: 12px;">Cancelar</span>
				</button>
				<button class="dropdown-toggle saveFunction btn btn-primary pull-right" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px;">
						<span style="font-size: 12px;">Guardar</span>
				</button>
			</div>
			<table class="table phasesTable smallFontTable">
			<thead>
				<th>Cód.</th>
				<th>Sigla</th>
				<th>Nome Fase</th>
			</thead>
			<tbody>
			<tr class="hiddenForm hidden">
				<form action="/settings/addPhase" method="POST">
					<td>
						<input type="text" required  class="form-control" name="code" placeholder="Cód.">
					</td>
					<td>
						<input type="text" required  class="form-control" name="sigla" placeholder="Sigla">
					</td>
					<td>
						<input type="text" required  class="form-control" name="phase" placeholder="Fase">
					</td>
					<td class="hidden"><button type="submit" class="submitButton">Guardar</button></td>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				</form>
			</tr>
			@foreach($phases as $phase) 
				<tr>
					<td content='{{$phase->id}}' class="code">{{$phase->code}}</td>
					<td content='{{$phase->id}}' class="sigla">{{$phase->sigla}}</td>
					<td content='{{$phase->id}}' class="phase name">{{$phase->name}}</td>
				</tr>
			@endforeach
			</tbody>
			</table>
			<div class="phasesEditable hidden">
				<table class="table phasesTableEditable smallFontTable">
				<thead>
					<th>Cód.</th>
					<th>Sigla</th>
					<th>Nome Fase</th>
					<th>Ações</th>
				</thead>
				<tbody>
				@foreach($phases as $phase) 
					<tr class="editablePhase" content="{{$phase->id}}">
						<td content='{{$phase->id}}' class="code">{{$phase->code}}</td>
						<td content='{{$phase->id}}' class="sigla">{{$phase->sigla}}</td>
						<td content='{{$phase->id}}' class="phase name">{{$phase->name}}</td>
						<td data-editable='false'><button content='{{$phase->id}}' style="padding: 3px 5px;" class="btn btn-danger removePhase" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
					</tr>
				@endforeach
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>

$('.hiddenFormButton').click(function() {
	$('.hiddenForm').removeClass('hidden');
	$('.hiddenFormButton').addClass('hidden');
	$('.formButtons').removeClass('hidden');
	$('.editButton').addClass('hidden');
});

$('.cancelFunction').click(function() {
	$('.formButtons').addClass('hidden');
	$('.hiddenForm').addClass('hidden');
	$('.hiddenFormButton').removeClass('hidden');
	$('.editButton').removeClass('hidden');
})

$('.saveFunction').click(function() {
	$('.submitButton').click();
})


$('.removePhase').click(function() {
	//var id = $(this).attr('content');
	$(this).parent().parent().find('.phase').parent().remove();
	/*$.get('/settings/projects/phases/deletePhase/' + id, function() {
	});*/

});

$('.phasesTableEditable').editableTableWidget();

$('.editButton').click(function() {
	$('.phasesEditable').removeClass('hidden');
	$('.phasesTable').addClass('hidden');
	$('.editButtons').removeClass('hidden');
	$('.hiddenFormButton').addClass('hidden');
	$(this).addClass('hidden');
});

$('.cancelEdit').click(function() {
	$('.phasesEditable').addClass('hidden');
	$('.phasesTable').removeClass('hidden');
	$('.editButtons').addClass('hidden');
	$('.hiddenFormButton').removeClass('hidden');
	$('.editButton').removeClass('hidden');
});

$('.saveEdit').click(function() {
	var obj = {};
	var ids = [];
	$('.editablePhase').each(function() {
		var id = $(this).attr('content');
		var expertise = [];
		$(this).find('td').each(function(index) {
			if(index < 3)
				expertise.push($(this).text());
		})
		if(expertise.length > 0) {
			ids.push(id);
			obj[id] = expertise;
		}
	});

	$.ajax({
	  type: "POST",
	  url: '/settings/projects/phases/edit',
	  data: {
	  	'obj': obj,
	  	'ids': ids
	  },
	  success: function() {
	  	location.reload();
	  }
	});
});

</script>


@endsection