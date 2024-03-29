@extends('layouts.app')

@section('content')

<div class="col-xs-12 insideContainer">
	@include('layouts.settings_nav')
	@include('layouts.contacts_settings_nav')
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
						<form action="/settings/contacts/companyField/addType" method="POST">
							<td><input class="input-sm form-control" required name="code" type="text"></td>
							<td><input class="input-sm form-control" required name="sigla" type="text"></td>
							<td><input class="input-sm form-control" required name="name" type="text"></td>
							<td class="hidden"><input type="hidden" name="_token" value="{{ csrf_token() }}"></td>
							<td class="hidden"><button type="submit" class="submitButton">Guardar</button></td>
						</form>
					</tr>
					@foreach($types as $type) 
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
						<td>{{str_pad($type->code, 3, '0', STR_PAD_LEFT)}}</td>
						<td>{{$type->sigla}}</td>
						<td class="text-left">{{$type->name}}</td>
						<td class="text-center">
							<button class="btn btn-warning btn-xs editType" content="{{$type->id}}"><i class="glyphicon glyphicon-edit"></i></button>
							<button content='{{$type->id}}' class="btn btn-danger btn-xs removeType" type="button"><i class="glyphicon glyphicon-minus"></i></button>
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
			url: '/settings/contacts/companyFields/editField',
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
		var r = confirm("Tem a certeza que quer eliminar esta área?");
		if (r == true) {
			$.ajax({
				method: 'POST',
				url: '/settings/contacts/companyFields/removeField',
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