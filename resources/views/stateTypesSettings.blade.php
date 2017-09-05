@extends('layouts.app')

@section('content')

<div class="col-xs-12 insideContainer">
	@include('layouts.settings_nav')
	@include('layouts.project_settings_2nd_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<table class="table smallFontTable typesTable">
				<thead>
					<th>Cód.</th>
					<th>Sigla</th>
					<th>Estado</th>
					<th>Ações</th>
					<th>
						<button style="padding: 3px 5px;" class="btn btn-primary hiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button>
					</th>
					<th style="padding: 0;" class="hidden hiddenForm">
						<form action="/settings/addStateType" method="POST">
							<div class="col-md-3">
								<input type="text" required  class="form-control" name="code" placeholder="Cód.">
							</div>
							<div class="col-md-3">
								<input type="text" required  class="form-control" name="sigla" placeholder="Sigla">
							</div>
							<div class="col-md-4">
								<input type="text" required  class="form-control" name="type" placeholder="Estado">
							</div>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<button type="submit" class="btn btn-primary">Inserir</button>
						</form>
					</th>
				</thead>
				<tbody>
					@foreach($states as $type) 
						<tr>
							<td content='{{$type->id}}' class="code">{{$type->code}}</td>
							<td content='{{$type->id}}' class="sigla">{{$type->sigla}}</td>
							<td content='{{$type->id}}' class="type name">{{$type->name}}</td>
							<td data-editable='false'><button content='{{$type->id}}' style="padding: 3px 5px;" class="btn btn-danger removeType" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
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

$('.removeType').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().find('.type').parent().remove();
	$.get('/settings/projects/states/deleteStateType/' + id, function() {
	});

});

$('.typesTable').editableTableWidget();

$('.typesTable td').on('change', function(evt, newValue) {
	var id = $(this).attr('content');
	if($(this).hasClass('code')) {
		$.ajax({
	      type: "POST",
	      url: '/settings/projects/states/changeTypeCode',
	      data: {
	      	'code': newValue,
	      	'id': id
	      },
	      success: function(response) {
	      }
	    });
	} else if($(this).hasClass('sigla')) {
		$.ajax({
	      type: "POST",
	      url: '/settings/projects/states/changeTypeSigla',
	      data: {
	      	'sigla': newValue,
	      	'id': id
	      },
	      success: function(response) {
	      }
	    });
	} else if($(this).hasClass('name')) {
		$.ajax({
	      type: "POST",
	      url: '/settings/projects/states/changeTypeName',
	      data: {
	      	'name': newValue,
	      	'id': id
	      },
	      success: function(response) {
	      	console.log(response);
	      }
	    });
	}
});	
</script>


@endsection