@extends('layouts.app')

@section('content')

<div class="col-xs-12 insideContainer">
	@include('layouts.settings_nav')
	@include('layouts.project_settings_2nd_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body" style="">
			<button class="dropdown-toggle addFunction btn btn-primary" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-left: 93%;">
					<span style="font-size: 12px;">Adicionar</span>
			</button>
			<div class="formButtons hidden">
				<button class="dropdown-toggle cancelFunction btn btn-danger" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-left: 80%;">
					<span style="font-size: 12px;">Cancelar</span>
				</button>
				<button class="dropdown-toggle saveFunction btn btn-primary" data-toggle="dropdown" style="padding-top: 2; padding-bottom: 2; margin-top: -30px; margin-left: 93%;">
						<span style="font-size: 12px;">Guardar</span>
				</button>
			</div>
			<table class="smallFontTable table">
				<thead>
					<th class="text-center" style="width: 33.3%;">Código</th>
					<th class="text-center" style="width: 33.3%;">Sigla</th>
					<th class="text-left" style="width: 33.3%;">Nome</th>
				</thead>
				<tbody class="text-center">
					<tr class="hidden hiddenForm">
						<form action="/settings/projects/generalUserFunction/addFunction" method="POST">
							<td><input class="input-sm form-control" required name="code" type="text"></td>
							<td><input class="input-sm form-control" required name="sigla" type="text"></td>
							<td><input class="input-sm form-control" required name="name" type="text"></td>
							<td class="hidden"><input type="hidden" name="_token" value="{{ csrf_token() }}"></td>
							<td class="hidden"><button type="submit" class="submitButton">Guardar</button></td>
						</form>
					</tr>
					@foreach($functions as $function)
					<tr>
						<td>{{str_pad($function->code, 3, '0', STR_PAD_LEFT)}}</td>
						<td>{{$function->sigla}}</td>
						<td class="text-left">{{$function->name}}</td>
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
</script>

@endsection