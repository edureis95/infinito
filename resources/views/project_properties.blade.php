@extends('layouts.app')

@section('content')

	<div class="col-md-6" style="padding: 0%;">
		<div class="panel panel-default">
			<div class="panel-heading"><h2 style="text-align: center;"> {{$project->name}} </h2></div>
			<div class="panel-body">
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<img src="/uploads/projects/{{ $project->picture }}" style="max-width:200px; float:left; margin-right:25px; padding:2px; border:1px solid #C0C0C0">
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<p> <b>Número Projeto:</b> {{$project->number}} </p>
					<p> <b>Responsável: </b>{{$userResponsible->name}} </p>
					<p> <b>Criado Em: </b>{{$project->created_at}} </p>
					<p> <b>Membros: </b>
					<ul>
					@foreach($userMembers as $userMember)
					<li> {{$userMember->name}} </li>
					@endforeach
					</ul>
					</p>
				</div>
			</div>
		</div>
	</div>
	@include('layouts.project_sidebar')

@endsection