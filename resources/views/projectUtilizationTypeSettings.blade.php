@extends('layouts.app')

@section('content')

<div class="col-xs-12 insideContainer">
	@include('layouts.settings_nav')
	@include('layouts.project_settings_2nd_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<table class="table typesTable smallFontTable">
				<thead>
					<th class="text-center">Código</th>
					<th class="text-center">Tipo de utilização</th>
					<th class="text-center">Ação
					<th class="text-center">
						<button style="padding: 3px 5px;" class="btn btn-primary addType" type="button"><i class="glyphicon glyphicon-plus"></i></button>
						<button style="padding: 3px 5px;" class="btn btn-success editButton" type="button"><i class="glyphicon glyphicon-edit"></i></button>
					</th>
				</thead>
				<tbody class="text-center">
					<tr class="hiddenForm hidden">
						<form action="/settings/project/addUtilizationType" method="POST">
							<td style="max-width: 100px;"><input type="number" class="form-control" name="code"></td>
							<td><input type="text" class="form-control" name="name"></td>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<td><button type="submit" class="btn btn-primary">Inserir</button></td>
						</form>
					</tr>
					@foreach($utilizationTypes as $type)
					<tr>
						<td>{{$type->code}}</td>
						<td>{{$type->name}}</td>
						<td></td>
						<td></td>
					</tr>
				@endforeach
				</tbody>
			</table>
			<div class="editableTypes hidden">
				<table class="table editableTypesTable smallFontTable">
					<thead>
						<th class="text-center">Código</th>
						<th class="text-center">Tipo de utilização</th>
						<th class="text-center">Ação
						<th class="text-center">
							<button style="padding: 3px 5px;" class="btn btn-primary addType" type="button"><i class="glyphicon glyphicon-plus"></i></button>
							<button style="padding: 3px 5px;" class="btn btn-danger cancelEdit" type="button"><i class="glyphicon glyphicon-edit"></i></button>
						</th>
					</thead>
					<tbody class="text-center">
						<tr class="hiddenForm hidden">
							<form action="/settings/project/addUtilizationType" method="POST">
								<td style="max-width: 100px;"><input type="number" class="form-control" name="code"></td>
								<td><input type="text" class="form-control" name="name"></td>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<td><button type="submit" class="btn btn-primary">Inserir</button></td>
							</form>
						</tr>
					@foreach($utilizationTypes as $type)
					<tr class="editableType" content="{{$type->id}}">
						<td>{{$type->code}}</td>
						<td>{{$type->name}}</td>
						<td><button content='{{$type->id}}' style="padding: 3px 5px; margin-bottom: 5px;" class="btn btn-danger removeType" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
						<td></td>
						<td></td>
					</tr>
					@endforeach
					</tbody>
				</table>
				<button type="button" class="btn btn-success pull-right saveButton">Guardar</button>
			</div>
		</div>
	</div>
</div>

<script>

$('.addType').click(function() {
	$('.hiddenForm').removeClass('hidden');
});

$('.editableTypesTable').editableTableWidget();

$('.editButton').click(function() {
	$('.editableTypes').removeClass('hidden');
	$('.typesTable').addClass('hidden');
});

$('.cancelEdit').click(function() {
	$('.editableTypes').addClass('hidden');
	$('.typesTable').removeClass('hidden');
});

$('.saveButton').click(function() {
	var obj = {};
	var ids = [];
	$('.editableType').each(function() {
		var id = $(this).attr('content');
		var expertise = [];
		$(this).find('td').each(function(index) {
			if(index < 2)
				expertise.push($(this).text());
		})
		if(expertise.length > 0) {
			ids.push(id);
			obj[id] = expertise;
		}
	});

	$.ajax({
	  type: "POST",
	  url: '/settings/projects/utilizationTypes/edit',
	  data: {
	  	'obj': obj,
	  	'ids': ids
	  },
	  success: function() {
	  	location.reload();
	  }
	});
});


$('.removeType').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().find('td').remove();
	//$.get('/settings/project/removeUtilizationType/' + id, function() {
	//});
});	
</script>


@endsection