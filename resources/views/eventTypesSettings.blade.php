@extends('layouts.app')

@section('content')

<div class="col-xs-12 insideContainer">
	@include('layouts.settings_nav')
	@include('layouts.project_settings_2nd_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<table class="table typesTable smallFontTable">
			<thead>
				<th class="text-center">Cód.</th>
				<th class="text-center">Sigla</th>
				<th class="text-center">Tipo Acontecimento</th>
				<th class="text-center">Ações</th>
				<th class="text-center">
					<button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button>
				</th>
			</thead>
			<tbody class="text-center">
			<tr class="hiddenForm hidden">
				<form action="/settings/addProjectEventType" method="POST">
					<td>
						<input type="text" required  class="form-control" name="code">
					</td>
					<td>
						<input type="text" required  class="form-control" name="sigla">
					</td>
					<td>
						<input type="text" required  class="form-control" name="type">
					</td>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<td>
						<button type="submit" class="btn btn-primary">Inserir</button>
					</td>
				</form>
			</tr>
			@foreach($types as $type) 
				<tr>
					<td content='{{$type->id}}' class="code">{{$type->code}}</td>
					<td content='{{$type->id}}' class="sigla">{{$type->sigla}}</td>
					<td content='{{$type->id}}' class="type name">{{$type->name}}</td>
					<td data-editable='false'><button content='{{$type->id}}' style="padding: 3px 5px;" class="btn btn-danger removeType" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
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
	$('.hiddenForm').removeClass('hidden');
});

$('.removeType').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().find('.type').parent().remove();
	$.get('/settings/projects/documentTypes/deleteDocumentType/' + id, function() {
	});

});
</script>


@endsection