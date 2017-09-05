@extends('layouts.app')

@section('content')

<div class="col-xs-12 insideContainer">
	@include('layouts.personal_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<table class="table approvalTable smallFontTable">
				<thead>
					<th class="text-center">Início</th>
					<th class="text-center">Fim<br>Horas</th>
					<th class="text-center">Motivo</th>
					<th class="text-center" style="width: 50%;">Descrição</th>	
					<th class="text-center">Aprovado</th>
				</thead>
				<tbody>
				@foreach($absences as $absence)
					<tr class="text-center">
						<td>{{$absence->start_date}}</td>
						<td>{{$absence->end_date}}</td>
						<td>{{$absence->a_name}}</td>
						<td class="text-left">{{$absence->text}}</td>
						@if($absence->a_ap == 0)
						<td class="taskNotApproved">Não</td>
						@else
						<td class="taskApproved">Sim</td>
						@endif
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