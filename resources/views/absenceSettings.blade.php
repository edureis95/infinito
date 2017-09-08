@extends('layouts.app')

@section('content')

<div class="col-xs-12 insideContainer">
	@include('layouts.settings_nav')
	@include('layouts.company_settings_2nd_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body">
			@if(count($absenceReasons))
			<table class="table smallFontTable">
				<thead>
					<th>Código</th>
					<th>Motivo de ausência </th>
					<th class="text-center">Ação
					<th><button style="padding: 3px 5px;" class="btn btn-primary addReason" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
				</thead>
				<tr class="hiddenForm hidden">
					<form action="/settings/company/absence/addReason" method="POST">
						<td style="max-width: 100px;"><input type="number" class="form-control" name="code"></td>
						<td><input type="text" class="form-control" name="reason"></td>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<td><button type="submit" class="btn btn-primary">Inserir</button></td>
						<td></td>
					</form>
				</tr>
				@foreach($absenceReasons as $reason)
				<tr class="reasonEdit{{$reason->id}} hidden">
						<td><input class="input-sm form-control codeInput" required name="code" value="{{$reason->code}}" type="text"></td>
						<td><input class="input-sm form-control nameInput" required name="name" type="text" value="{{$reason->name}}"></td>
						<td class="text-center">
							<button class="btn btn-xs btn-danger cancelEdit" content="{{$reason->id}}"><i class="glyphicon glyphicon-edit"></i></button>
							<button class="btn btn-xs btn-success saveEdit" content="{{$reason->id}}"><i class="glyphicon glyphicon-check"></i></button>
						</td>
					</tr>
				<tr class="reason{{$reason->id}}">
					<td>{{str_pad($reason->code, 3, '0', STR_PAD_LEFT)}}</td>
					<td>{{$reason->name}}</td>
					<td class="text-center">
						<button content='{{$reason->id}}' class="btn btn-warning btn-xs editReason" type="button"><i class="glyphicon glyphicon-edit"></i></button>
						<button content='{{$reason->id}}' class="btn btn-danger btn-xs removeReason" type="button"><i class="glyphicon glyphicon-minus"></i></button>
					</td>
					<td></td>
				</tr>
				@endforeach
			</table>
			@endif
		</div>
	</div>
</div>

<script>

$('.addReason').click(function() {
	$('.hiddenForm').removeClass('hidden');
});

$('.removeReason').click(function() {
	var id = $(this).attr('content');
	var txt;
	var r = confirm("Tem a certeza que quer eliminar este tipo de ausência?");
	if (r == true) {
		$.get('/settings/company/absence/removeReason/' + id, function() {
			location.reload();
		});
	}
});	

$('.editReason').click(function() {
	var id = $(this).attr('content');
	$('.reason' + id).addClass('hidden');
	$('.reasonEdit' + id).removeClass('hidden');
})

$('.cancelEdit').click(function() {
	var id = $(this).attr('content');
	$('.reason' + id).removeClass('hidden');
	$('.reasonEdit' + id).addClass('hidden');
})

$('.saveEdit').click(function() {
	var id = $(this).attr('content');
	var code = $('.reasonEdit' + id + ' .codeInput').val();
	var name = $('.reasonEdit' + id + ' .nameInput').val();
	$.ajax({
		method: 'POST',
		url: '/settings/company/absence/editReason',
		data: {
			id: id,
			code: code,
			name: name
		},
		success: function() {
			location.reload();
		}
	})
})

</script>


@endsection