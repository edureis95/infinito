@extends('layouts.app')

@section('content')

<div class="col-xs-12 insideContainer">
	@include('layouts.settings_nav')
	@include('layouts.project_settings_2nd_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body" style="">
			<button class="dropdown-toggle addFunction btn btn-primary pull-right" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px;">
					<span style="font-size: 12px;">Adicionar</span>
			</button>
			<div class="formButtons hidden">
				<button class="dropdown-toggle cancelFunction btn btn-danger pull-right" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-right: 80px;">
					<span style="font-size: 12px;">Cancelar</span>
				</button>
				<button class="dropdown-toggle saveFunction btn btn-primary pull-right" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px;">
						<span style="font-size: 12px;">Guardar</span>
				</button>
			</div>
			<table class="smallFontTable table">
				<thead>
					<th class="text-center">Código</th>
					<th class="text-center">Sigla</th>
					<th class="text-left">Nome</th>
					<th></th>
				</thead>
				<tbody class="text-center">
					<tr class="hidden hiddenForm">
						<form action="/settings/projects/generalExpertise/addGeneralExpertise" method="POST">
							<td><input class="input-sm form-control" required name="code" type="text"></td>
							<td><input class="input-sm form-control" required name="sigla" type="text"></td>
							<td><input class="input-sm form-control" required name="name" type="text"></td>
							<td class="hidden"><input type="hidden" name="_token" value="{{ csrf_token() }}"></td>
							<td class="hidden"><button type="submit" class="submitButton">Guardar</button></td>
						</form>
					</tr>
					@foreach($expertise as $expert)
					<tr class="expertiseEdit{{$expert->id}} hidden">
						<td><input class="input-sm form-control codeInput" required name="code" value="{{$expert->code}}" type="text"></td>
						<td><input class="input-sm form-control siglaInput" required name="sigla" type="text" value="{{$expert->sigla}}"></td>
						<td><input class="input-sm form-control nameInput" required name="name" type="text" value="{{$expert->name}}"></td>
						<td class="text-center">
							<button class="btn btn-xs btn-danger cancelEdit" content="{{$expert->id}}"><i class="glyphicon glyphicon-edit"></i></button>
							<button class="btn btn-xs btn-success saveEdit" content="{{$expert->id}}"><i class="glyphicon glyphicon-check"></i></button>
						</td>
					</tr>
					<tr class="expertise{{$expert->id}}">
						<td>{{str_pad($expert->code, 3, '0', STR_PAD_LEFT)}}</td>
						<td>{{$expert->sigla}}</td>
						<td class="text-left">{{$expert->name}}</td>
						<td class="text-center">
							<button class="btn btn-warning btn-xs editExpertise" content="{{$expert->id}}"><i class="glyphicon glyphicon-edit"></i></button>
							<button content='{{$expert->id}}' class="btn btn-danger btn-xs removeExpertise" type="button"><i class="glyphicon glyphicon-minus"></i></button>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('.addFunction').click(function() {
		$(this).addClass('hidden');
		$('.formButtons').removeClass('hidden');
		$('.hiddenForm').removeClass('hidden');
	})

	$('.cancelFunction').click(function() {
		$('.formButtons').addClass('hidden');
		$('.hiddenForm').addClass('hidden');
		$('.addFunction').removeClass('hidden');
	})

	$('.saveFunction').click(function() {
		$('.submitButton').click();
	})

	$('.editExpertise').click(function() {
		var id = $(this).attr('content');
		$('.expertise' + id).addClass('hidden');
		$('.expertiseEdit' + id).removeClass('hidden');
	})

	$('.cancelEdit').click(function() {
		var id = $(this).attr('content');
		$('.expertise' + id).removeClass('hidden');
		$('.expertiseEdit' + id).addClass('hidden');
	})

	$('.saveEdit').click(function() {
		var id = $(this).attr('content');
		var code = $('.expertiseEdit' + id + ' .codeInput').val();
		var sigla = $('.expertiseEdit' + id + ' .siglaInput').val();
		var name = $('.expertiseEdit' + id + ' .nameInput').val();
		$.ajax({
			method: 'POST',
			url: '/settings/projects/generalExpertise/editExpertise',
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

	$('.removeExpertise').click(function() {
		var id = $(this).attr('content');
		var txt;
		var r = confirm("Tem a certeza que quer eliminar esta especialidade?");
		if (r == true) {
			$.ajax({
				method: 'POST',
				url: '/settings/projects/generalExpertise/removeExpertise',
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