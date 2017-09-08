@extends('layouts.app')

@section('content')

<div class="col-xs-12 insideContainer">
	@include('layouts.settings_nav')
	@include('layouts.project_settings_2nd_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<table class="table typesTable smallFontTable">
			<thead>
				<th>Cód.</th>
				<th>Sigla</th>
				<th>Tipo Milestone</th>
				<th class="text-center">Ações</th>
				<th>
					<button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button>
				</th>
				<th style="padding: 0;" class="hidden hiddenForm">
					<form action="/settings/addPlanningType" method="POST">
						<div class="col-md-3">
							<input type="text" required  class="form-control" name="code" placeholder="Cód.">
						</div>
						<div class="col-md-3">
							<input type="text" required  class="form-control" name="sigla" placeholder="Sigla">
						</div>
						<div class="col-md-4">
							<input type="text" required  class="form-control" name="type" placeholder="Tipo Milestone">
						</div>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<button type="submit" class="btn btn-primary">Inserir</button>
					</form>
				</th>
			</thead>
			<tbody>
				@foreach($planning as $type) 
					<tr class="typeEdit{{$type->id}} hidden">
						<td><input class="input-sm form-control codeInput" required name="code" value="{{$type->code}}" type="text"></td>
						<td><input class="input-sm form-control siglaInput" required name="sigla" type="text" value="{{$type->sigla}}"></td>
						<td><input class="input-sm form-control nameInput" required name="name" type="text" value="{{$type->name}}"></td>
						<td class="text-center">
							<button class="btn btn-xs btn-danger cancelEdit" content="{{$type->id}}"><i class="glyphicon glyphicon-edit"></i></button>
							<button class="btn btn-xs btn-success saveEdit" content="{{$type->id}}"><i class="glyphicon glyphicon-check"></i></button>
						</td>
					</tr>
					<tr class="type{{$type->id}}">
						<td content='{{$type->id}}' class="code">{{$type->code}}</td>
						<td content='{{$type->id}}' class="sigla">{{$type->sigla}}</td>
						<td content='{{$type->id}}' class="type name">{{$type->name}}</td>
						<td class="text-center">
							<button content='{{$type->id}}' class="btn btn-warning btn-xs editType" type="button"><i class="glyphicon glyphicon-edit"></i></button>
							<button content='{{$type->id}}' class="btn btn-danger btn-xs removeType" type="button"><i class="glyphicon glyphicon-minus"></i></button>
						</td>
						<td></td>
					</tr>
				@endforeach
			</tbody>
			</table>
		</div>
	</div>
</div>

<script>

$('.hiddenFormButton').click(function() {
	$(this).parent().parent().find('.hiddenForm').removeClass('hidden');
});


$('.editType').click(function() {
	var id = $(this).attr('content');
	$('.type' + id).addClass('hidden');
	$('.typeEdit' + id).removeClass('hidden');
})

$('.cancelEdit').click(function() {
	var id = $(this).attr('content');
	$('.type' + id).removeClass('hidden');
	$('.typeEdit' + id).addClass('hidden');
})

$('.saveEdit').click(function() {
	var id = $(this).attr('content');
	var code = $('.typeEdit' + id + ' .codeInput').val();
	var sigla = $('.typeEdit' + id + ' .siglaInput').val();
	var name = $('.typeEdit' + id + ' .nameInput').val();
	$.ajax({
		method: 'POST',
		url: '/settings/projects/planning/editPlanningType',
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

$('.removeType').click(function() {
	var id = $(this).attr('content');
	var txt;
	var r = confirm("Tem a certeza que quer eliminar este tipo de planeamento?");
	if (r == true) {
		$.ajax({
			method: 'POST',
			url: '/settings/contacts/projects/removePlanningType',
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


@endsection