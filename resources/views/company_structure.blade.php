@extends('layouts.app')

@section('content')

<div class="col-xs-12" style="max-width: 98%;">

	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Modal Header</h4>
				</div>
				<div class="modal-body">

					<form enctype="multipart/form-data" action="/structure/add_department" method="POST">
						<div class="form-group row">
							<label class="col-md-4 col-form-label" style="text-align: right; padding-top: 5px;">Nome</label>
							<div class="col-md-6">
								<input class="form-control" type="text" value="" name="name">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 col-form-label" style="text-align: right;">Departamento Pai</label>
							<div class="col-md-6">
								<select class="add_department_select form-control" name="parent" style="width: 100%">
									
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4 col-form-label" style="text-align: right;">Supervisor</label>
							<div class="col-md-6">
								<select class="form-control select2" type="text" name="supervisor" style="width:100%;">
									@foreach($usersList as $user)
									<option value="{{$user->id}}">{{$user->name}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group row">
							<div class="col-md-offset-4 col-md-3">
								<input type="submit" class="btn btn-sm btn-primary">
							</div>
						</div>
					</form>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>

	<!-- Modal -->
	<div id="delete_department" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Elimina departamento</h4>
				</div>
				<div class="modal-body">

					<form enctype="multipart/form-data" action="/structure/delete_department" method="POST">
						<div class="form-group row">
							<label class="col-md-4 col-form-label" style="text-align: right;">Departamento a eliminar</label>
							<div class="col-md-6">
								<select class="add_department_select form-control" name="department" style="width: 100%">
									
								</select>
							</div>
						</div>

						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group row">
							<div class="col-md-offset-4 col-md-3">
								<input type="submit" class="btn btn-sm btn-primary">
							</div>
						</div>
					</form>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>

	<!-- Modal -->
	<div id="edit_department" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edita departamento</h4>
				</div>
				<div class="modal-body">

					<form enctype="multipart/form-data" action="/structure/edit_department" method="POST">
						<div class="form-group row">
							<label class="col-md-4 col-form-label" style="text-align: right;">Departamento a editar</label>
							<div class="col-md-6">
								<select class="add_department_select form-control" name="department" style="width: 100%">
									
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4 col-form-label" style="text-align: right; padding-top: 5px;">Nome</label>
							<div class="col-md-6">
								<input class="form-control edit_department_name" type="text" value="" name="name">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4 col-form-label" style="text-align: right;">Departamento Pai</label>
							<div class="col-md-6">
								<select class="edit_department_select_parent form-control" name="parent" style="width: 100%">
									
								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4 col-form-label" style="text-align: right;">Supervisor</label>
							<div class="col-md-6">
								<select class="form-control select2 edit_department_select_supervisor" type="text" name="supervisor" style="width:100%;">
									@foreach($usersList as $user)
									<option value="{{$user->id}}">{{$user->name}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group row">
							<div class="col-md-offset-4 col-md-3">
								<input type="submit" class="btn btn-sm btn-primary">
							</div>
						</div>
					</form>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>

	<!-- Modal -->
	<div id="add_user" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Adicione um utilizador ao departamento</h4>
				</div>
				<div class="modal-body">

					<form enctype="multipart/form-data" action="/structure/add_user" method="POST">
						<div class="form-group row">
							<label class="col-md-4 col-form-label" style="text-align: right;">Departamento</label>
							<div class="col-md-6">
								<select class="add_department_select form-control" name="department" style="width: 100%">
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 col-form-label" style="text-align: right;">Utilizador</label>
							<div class="col-md-6">
							<select class="form-control select2" type="text" name="user" style="width:100%;">
									@foreach($usersList as $user)
									<option value="{{$user->id}}">{{$user->name}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group row">
							<div class="col-md-offset-4 col-md-3">
								<input type="submit" class="btn btn-sm btn-primary">
							</div>
						</div>
					</form>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>

	@include('layouts.company_nav')
	<div class="row">
    	<hr style="margin-top: 0; margin-left: 0; width: 100%; border-color: #DCDCDC;">
	</div>
	<div class="panel panel-default structure-panel borderless" style="margin-right: 15px;">
		<div class="panel-body">
			<div id="chart" style=" min-width: 90%; width: 100%; margin: 0%;">
				<ul id="basic-chart-source" class="hide">
				</ul>
			</div>
		</div>
	</div>
</div>
<style>

	.structure-panel {
	}

	div.orgchart {
		background-color: white;
		border: none;
		overflow-x: scroll;;
	}

	div.orgChart div.node {
		width: 200px;
		height: auto;
	}

	div.orgChart div.node.level0 {
		background-color: #0088cd;
		border-color: #0088cd;
	}

	div.orgChart div.node.level0 hr{
		border-color: white;
	}

	div.orgChart div.node.level1 hr{
		border-color: white;
	}

	div.orgChart div.node.level1 {
		background-color: #39b1f0;
		border-color: #39b1f0;
	}

	div.orgChart div.node.level2 hr{
		border-color: white;
	}

	div.orgChart div.node.level2 {
		background-color: #b0b0b0;
		border-color: #b0b0b0;
	}

	div.orgChart div.node p{
		margin-top: 2%;
	}

	div.orgChart div.node hr {
		margin-top: 0%;
		width:105%;
		margin-left: -2%; 
		margin-bottom: 10px;
	}

	div.orgChart div.node .supervisor img {
		width: 30px;
		height: 30px;
		float: left;
		margin-right: 10px;
	}

	div.orgChart div.node .supervisor {
		text-align: left;
		font-size: 11px;
	}

	div.orgChart div.node .employees {
		margin-top: 20px;
		margin-bottom: 10px;
		color: white;
		font-size: 10px;
		clear: left;
		text-align: left;
	}

	div.orgChart div.node .employees img{
		height: 25px;
		width: 25px;
	}

	div.orgChart div.node .top_department {
		margin-top: 8px;
		text-align: left;
		font-size: 11px;
	}

	div.orgChart div.node .top_department img{
		float: right;
		height:15px;
		width: 15px;
	}

	.add_department, .edit_department{
		cursor: pointer;
	}

	.title img {
		display: none;
	}

</style>
<script>

	$(document).ready(function() {

	//$("select option[value='B']").attr("selected","selected");

	$(function() {
		$("#basic-chart-source").orgChart({container: $("#chart")});
	});


	$(".add_department_select, .edit_department_select_parent").append('<option value="0">Sem pai</option>')

	@foreach($departments as $department)
	if({{$department->parent}} == 0)
		$('#basic-chart-source').append('<li class="adjunct{{$department->id}}"> <div class="department" id="department{{$department->id}}"> <div class="top_department"> <p class="title"><b>{{$department->department_name}}</b> <img title="Adiciona utilizador" class="add_department" id="add_department{{$department->id}}" data-toggle="modal" data-target="#add_user" src=/images/add_user.png> <img title="Adiciona departamento" class="add_department" id="add_department{{$department->id}}" data-toggle="modal" data-target="#myModal" src=/images/add.png>  <img class="add_department" id="add_department{{$department->id}}" data-toggle="modal" data-target="#edit_department"  title="Edita departamento" src=/images/pencil.ico></p></div> <hr> <div class="supervisor"><img title="{{$department->user_name}}" src="/uploads/avatars/{{$department->user_avatar}}"> <p><b>{{$department->user_name}}</b></p> </div> <div class="employees"> <p> Employees </p> @foreach($department->employees as $employee) <img title="{{$employee->name}}" src="/uploads/avatars/{{$employee->avatar}}">  @endforeach </div></div> <ul id="{{$department->id}}"> </ul> </li>');
	else 
		$('#{{$department->parent}}').append('<li> <div class="department" id="department{{$department->id}}"> <div class="top_department"> <p class="title"><b>{{$department->department_name}}</b> <img title="Elimina departamento" class="add_department" id="add_department{{$department->id}}" data-toggle="modal" data-target="#delete_department" src=/images/delete.ico> <img title="Adiciona utilizador" class="add_department" id="add_department{{$department->id}}" data-toggle="modal" data-target="#add_user" src=/images/add_user.png> <img title="Adiciona departamento" class="add_department" id="add_department{{$department->id}}" data-toggle="modal" data-target="#myModal" src=/images/add.png>  <img class="add_department" id="add_department{{$department->id}}" data-toggle="modal" data-target="#edit_department" title="Edita departamento" src=/images/pencil.ico></p></div> <hr> <div class="supervisor"><img title="{{$department->user_name}}" src="/uploads/avatars/{{$department->user_avatar}}"> <p><b>{{$department->user_name}}</b></p> </div> <div class="employees"> @if(count($department->employees) > 0)<p> Employees </p> @endif @foreach($department->employees as $employee) <img title="{{$employee->name}}" src="/uploads/avatars/{{$employee->avatar}}">  @endforeach </div></div> <ul id="{{$department->id}}"> </ul> </li>');

	$("#chart").on("mouseenter", "#department{{$department->id}}", function() {
		$("#department{{$department->id}} .title img").show();
	});

	$("#chart").on("mouseleave", "#department{{$department->id}}", function() {
		$(".title img").hide();
	});

	$("#chart").on("click", "#add_department{{$department->id}}", function(event){
		$(".add_department_select").val('{{$department->id}}');
		$(".edit_department_select_parent").val('{{$department->parent}}');
		$(".edit_department_select_supervisor").val('{{$department->supervisor}}').trigger('change');
		$(".edit_department_name").val('{{$department->department_name}}');
	});

	$(".add_department_select, .edit_department_select_parent").append('<option value="{{$department->id}}"> {{$department->department_name}} </option>');
	@endforeach

});

</script>

@endsection