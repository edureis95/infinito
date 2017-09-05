@extends('layouts.app')

@section('content')


<div class="col-xs-11" style="max-width: 100%;">
	@include('layouts.project_nav')
	@include('layouts.project_second_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav" style="padding: 0;">
			<div class="col-xs-12">
				<table class="table table-responsive borderless" style="width: auto;">
					<thead>
						<th>Fase</th>
					</thead>
					@foreach($projectPhase as $phase)
					<tr>
						<td>{{$phase->p_sigla}} - {{$phase->p_name}}</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
</div>

<script>
</script>

@endsection