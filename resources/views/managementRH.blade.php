@extends('layouts.app')

@section('content')

<div class="col-xs-12 insideContainer">
	@include('layouts.management_nav')
	@include('layouts.commercial_management_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<table class="table smallFontTable">
				<thead>
					<th>Nome</th>
					<th>Operações(h)</th>
					<th>Ausências(h)</th>
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr>
						<td>{{$user->name}}</td>
						<td>{{$user->operationHours + ceil($user->operationMinutes/60)}}</td>
						<td>{{$usersAbsence->where('id', $user->id)->first()->absenceHours != '' ? $usersAbsence->where('id', $user->id)->first()->absenceHours : 0}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
</script>


@endsection