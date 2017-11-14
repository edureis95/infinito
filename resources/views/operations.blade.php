@extends('layouts.app')

@section('content')

<div class="col-xs-12" style="max-width: 98%;">
	@include('layouts.management_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body members" style="padding-left: 0;">
			<div class="col-xs-6">
			<table class="table borderless" style="width: 75%;">
					<tr>
						<td><button class="btn btn-info newProject" role="button" data-toggle="modal" data-target="#myModal">Criar Projeto</button></td>
					</tr>
					<tr></tr>
					<tr>
						<td> Ano </td>
						<td>
							<select class="form-control yearFilter">
								<option value="0">Sem Filtro</option>
							</select>
						</td>
					</tr>

					<tr>
						<td>Especialidade</td>
						<td>
							<select class="form-control expertiseFilter">
								<option value="0">Sem filtro</option>
								@foreach($expertise as $expert)
								@if($expert->parent == 0)
								@if(isset($filter) and $filter->expertise == $expert->id)
								<option selected value="{{$expert->id}}">{{$expert->name}}</option>
								@else
								<option value="{{$expert->id}}">{{$expert->name}}</option>
								@endif
								@endif
								@endforeach
							</select>
						</td>
					</tr>
					<tr>
						<td>Estado</td>
						<td>
							<select class="form-control stateFilter">
								<option value="0">Sem filtro</option>
								@foreach($states as $state)
									@if(isset($filter) and $filter->state == $state->id)
									<option selected value="{{$state->id}}">{{$state->name}}</option>
									@else
									<option value="{{$state->id}}">{{$state->name}}</option>
									@endif
								@endforeach
							</select>
						</td>
					</tr>
					</tr>
					<td></td>
					</tr>
					<tr>
					<td></td>
					</tr>
					<tr>
						<td><button type="button" class="btn refreshFilter">Atualizar</button></td>
					</tr>
				</table>
			</div>
			<div class="col-xs-6">
				<table class="table projectsTable">
				<thead>
					<th class="text-center">Código</th>
					<th class="text-center">Nome</th>
					<th class="text-center">Horas</th>
				</thead>
				<tbody class="text-center">
				@foreach($projects as $project)
					<tr>
						<td><a href="/project/gantt/{{$project->id}}">{{str_pad($project->number, 5, '0', STR_PAD_LEFT)}}</a></td>
					<td><a href="/project/gantt/{{$project->id}}">{{$project->name}}</a></td>
					@if(!empty($project->taskTimer))
					<td>{{$project->taskTimer->hours + ceil($project->taskTimer->minutes/60)}}</td>
					@else
					<td>0</td>
					@endif
					<td>
					</tr>
				@endforeach
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Criar Projeto</h4>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" role="form" action="/projects/new" method="POST">
			<div class="panel-group">
				<div class="panel panel-info">
					<div class="panel-heading" style="height: 40px;">
						<p>Dados do projeto</p>
					</div>
					<div class="panel-body">
						  <div class="form-group">
						    <label for="input1" class="col-xs-2 control-label">Código</label>
						    <div class="col-xs-10">
						      <input style="width: 50px;display:inline;" type="text"  required class="form-control number input-medium bfh-phone" data-format="dd" name="code">
						      <input type="text" style="display:inline; width: 60px;" required class="form-control number input-medium bfh-phone" data-format="ddd" name="code2">
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="input2" class="col-xs-2 control-label">Nome</label>
						    <div class="col-xs-4">
						      <input type="text" required class="form-control" name="name">
						    </div>
						  </div>
						  
					</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading" style="height: 40px;">
						<p>Especialidades e Fases</p>
					</div>
					<div class="panel-body controls">
						<div class="row">
						<div class="form-group col-xs-12 phases">
							<div class="col-xs-10 entry input-group">
									<div class="col-xs-4">
										<label class="col-form-label" style="text-align: right;">Fases</label>
									</div>
									<div class="col-xs-5">
									<select class="form-control" type="text" name="phases[]">
										<option value="0"> Sem fases </option>
										@foreach($phases as $phase)
										<option value="{{$phase->id}}"> {{$phase->name}} </option>
										@endforeach
									</select>
									</div>
									<div class="col-xs-1" style="padding-left: 0; margin: 0;">
									<span class="input-group-btn">
			                            <button class="btn btn-success btn-add-phase" type="button">
			                                <span class="glyphicon glyphicon-plus"></span>
			                            </button>
			                        </span>
			                        </div>
		                        </div>
							</div>
						</div>
						<div class="row">
						<div class="form-group col-xs-12 expertise">
							<div class="col-xs-10 entryExpert input-group">
									<div class="col-xs-4">
										<label class="col-form-label" style="text-align: right;">Especialidades</label>
									</div>
									<div class="col-xs-5">
									<select class="form-control expertiseSelect" type="text" name="expertise[]">
										<option value="0"> Sem especialidades </option>
										@foreach($expertise as $expert)
										@if($expert->parent == 0)
											<option value="{{$expert->id}}"> {{$expert->name}} </option>
										@endif
										@endforeach
									</select>
									</div>
									<div class="col-xs-1" style="padding-left: 0; margin: 0;">
									<span class="input-group-btn">
			                            <button class="btn btn-success btn-add-expert" type="button">
			                                <span class="glyphicon glyphicon-plus">Esp.</span>
			                            </button>
			                        </span>
			                        <span class="input-group-btn">
			                            <button class="btn btn-success btn-add-subexpert" type="button">
			                                <span class="glyphicon glyphicon-plus">Sub.</span>
			                            </button>
			                        </span>
			                        </div>
			                        <div class="subexpertise">
			                        	
			                        </div>
		                        </div>
							</div>
						</div>
					</div>

					</div>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group row">
						<div class="col-xs-offset-3 col-xs-3">
							<input type="submit" class="btn btn-primary">
						</div>
						<div class="col-xs-offset-3 col-xs-3">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						</div>
					</div>
				</div>
			</div>
			</form>
      </div>
    </div>
  </div>
</div>

<script>

function appendYears() {
	var i,yr,now = new Date();
	for (i=0; i<13; i++) {
	    yr = now.getFullYear()-11+i; // or whatever
	    @if(isset($filter))
	    	if(yr == {{$filter->year}})
	    		$('.yearFilter').append($('<option/>').val(yr).text(yr).prop('selected', true));
	    	else
	    		$('.yearFilter').append($('<option/>').val(yr).text(yr));
	    @else
	    $('.yearFilter').append($('<option/>').val(yr).text(yr));
	    @endif
	}
}

appendYears();

$('.refreshFilter').click(function() {
	var year = $('.yearFilter').val();
	var expertise = $('.expertiseFilter').val();
	var state = $('.stateFilter').val();
	$.ajax({
		type: "POST",
		url: '/management/operations/filterProjects',
		data: {
			'year': year,
			'expertise': expertise,
			'state': state
		},
		success: function(response) {
			$('.projectsTable tbody').empty();
			for(var i = 0; i < response.length; i++) {
				var hours = 0;
				if(response[i].taskTimer != null)
					hours = parseInt(response[i].taskTimer.hours) + Math.ceil(response[i].taskTimer.minutes / 60);
				var toAppend = '<tr>'+
						'<td><a href="/project/gantt/' + response[i].id + '">'+("0" + response[i].number).slice(-5)+'</a></td>'+
					'<td><a href="/project/gantt/'+response[i].id+'">'+response[i].name+'</a></td>'+
					'<td>'+ hours + '</td>'+
					'</tr>';
				$('.projectsTable tbody').append(toAppend);
			}
		}
	});
})

$(function () {
	$(document).on('click', '.btn-add-phase', function(e) {
	    e.preventDefault();

	    var controlForm = $('.controls .phases:first'),
	        currentEntry = $(this).parents('.entry:first'),
	        newEntry = $(currentEntry.clone()).appendTo(controlForm);

	   	newEntry.find('label').addClass('hidden');

	    newEntry.find('input').val('');
	    controlForm.find('.entry:not(:last) .btn-add-phase')
	        .removeClass('btn-add-phase').addClass('btn-remove-phase')
	        .removeClass('btn-success').addClass('btn-danger')
	        .html('<span class="glyphicon glyphicon-minus"></span>');
	}).on('click', '.btn-remove-phase', function(e) {
		$(this).parents('.entry:first').remove();
		$('.controls .phases:first').find('label:first').removeClass('hidden');

		e.preventDefault();
		return false;
	});

	$(document).on('click', '.btn-add-expert', function(e) {
	    e.preventDefault();

	    var toClone = '<div class="col-xs-10 entryExpert input-group">'+
						'<div class="col-xs-4">'+
							'<label class="col-form-label" style="text-align: right;">Especialidades</label>'+
						'</div>'+
						'<div class="col-xs-5">'+
						'<select class="form-control expertiseSelect" type="text" name="expertise[]">'+
							'<option value="0"> Sem especialidades </option>'+
							'@foreach($expertise as $expert)'+
							'@if($expert->parent == 0)' +
							'<option value="{{$expert->id}}"> {{$expert->name}} </option>'+
							'@endif' +
							'@endforeach'+
						'</select>'+
						'</div>'+
						'<div class="col-xs-1" style="padding-left: 0; margin: 0;">'+
						'<span class="input-group-btn">'+
	                        '<button class="btn btn-success btn-add-expert" type="button">'+
	                            '<span class="glyphicon glyphicon-plus">Esp.</span>'+
	                        '</button>'+
	                    '</span>'+
	                    '<span class="input-group-btn">'+
	                        '<button class="btn btn-success btn-add-subexpert" type="button">'+
	                            '<span class="glyphicon glyphicon-plus">Sub.</span>'+
	                        '</button>'+
	                    '</span>'+
	                    '</div>'+
	                    '<div class="subexpertise">'+
	                    	
	                    '</div>'+
	                '</div>';

	    var controlForm = $('.controls .expertise:first'),
	        currentEntry = $(this).parents('.entryExpert:first'),
	        newEntry = $(toClone).appendTo(controlForm);

	   	newEntry.find('label').addClass('hidden');

	    newEntry.find('input').val('');
	    controlForm.find('.entryExpert:not(:last) .btn-add-expert')
	        .removeClass('btn-add-expert').addClass('btn-remove-expert')
	        .removeClass('btn-success').addClass('btn-danger')
	        .html('<span class="glyphicon glyphicon-minus"></span>');
	}).on('click', '.btn-remove-expert', function(e) {
		$(this).parents('.entryExpert:first').remove();
		$('.controls .expertise:first').find('label:first').removeClass('hidden');

		e.preventDefault();
		return false;
	});

	$(document).on('click', '.btn-add-subexpert', function(e) {
	    e.preventDefault();

	    var value = $(this).parent().parent().parent().find('.expertiseSelect').val();
	    if(value == undefined) {
	    	value = $(this).parent().parent().parent().parent().parent().find('.expertiseSelect').val();
	    }
	    var toClone = '<div class="toClone hidden">'+
	                	'<div class="col-md-offset-2 col-xs-4">'+
						'</div>'+
						'<div class="col-xs-5">'+
						'<select class="form-control subExpertiseSelect" type="text" name="expertise[]">'+
							'<option value="0"> Sem sub-especialidades </option>'+
							'@foreach($expertise as $expert)'+
							'@if($expert->parent != 0)'+
							'<option value="{{$expert->id}}" class="subOption" content="{{$expert->parent}}"> {{$expert->name}} </option>'+
							'@endif'+
							'@endforeach'+
						'</select>'+
						'</div>'+
						'<div class="col-xs-1" style="padding-left: 0; margin: 0;">'+
						'<span class="input-group-btn">'+
	                        '<button class="btn btn-success btn-add-subexpert" type="button">'+
	                            '<span class="glyphicon glyphicon-plus"></span>'+
	                        '</button>'+
	                    '</span>'+
	                    '</span>'+
	                    '</div>'+
	                    '</div>';


	    var controlForm = $(this).parent().parent().parent().find('.subexpertise');

	    if(controlForm.html() == undefined)
	    	controlForm = $(this).parent().parent().parent().parent().parent().find('.subexpertise');
	    var newEntry = $(toClone).appendTo(controlForm);

	    newEntry.find('label').addClass('hidden');
	    newEntry.parent().find('.toClone:last').removeClass('hidden');

	    newEntry.find('.subOption').each(function() {
			$(this).removeClass('hidden');
			var parent = $(this).attr('content');
			if(parent != value) {
				$(this).addClass('hidden');
			}
		});

	    newEntry.find('input').val('');
	    $('.toClone:not(:last) .btn-add-subexpert')
	        .removeClass('btn-add-subexpert').addClass('btn-remove-subexpert')
	        .removeClass('btn-success').addClass('btn-danger')
	        .html('<span class="glyphicon glyphicon-minus"></span>');
	}).on('click', '.btn-remove-subexpert', function(e) {
		$(this).parents('.toClone:first').remove();
		$('.controls .expertise:first').find('label:first').removeClass('hidden');

		e.preventDefault();
		return false;
	});

	$(document).on('change', '.expertise .expertiseSelect', function() {
		var value = this.value;
		$(this).parent().parent().find('.subOption').each(function() {
			$(this).removeClass('hidden');
			var parent = $(this).attr('content');
			if(parent != value) {
				$(this).addClass('hidden');
			}
		});
	});
});

</script>


@endsection