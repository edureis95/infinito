@extends('layouts.app')

@section('content')


<div class="col-xs-12 insideContainer">
	@include('layouts.commercial_project_nav')
	@include('layouts.commercial_project_secondNav')
	<div class="panel panel-default borderless">
		<div class="panel-body link-nav">
			<div class="col-xs-12">
				<table class="table phasesSelectTable smallFontTable" style="max-width: 50%; min-width: 50%; float: left;">
					<thead>
						<th></th>
						@foreach($projectPhases as $phase)
							<th class="text-center">{{$phase->p_sigla}}</th>
						@endforeach
						<th class="text-center">Valor</th>
					</thead>	
					<tbody>
						@foreach($projectExpertise as $expert)
						<tr>
							<td>{{$expert->e_sigla}} - {{$expert->e_name}}</td>
							@foreach($projectPhases as $phase)
							<td class="text-center" style="width: 80px;">
								@if($expert->phases->contains('phase_id', $phase->p_id))
								<input style="float: left;" disabled checked class="expertCheckbox" content="{{$expert->e_id}}" 2ndContent="{{$phase->p_id}}" type="checkbox">
								@else
								<input style="float: left;" disabled class="expertCheckbox" content="{{$expert->e_id}}" 2ndContent="{{$phase->p_id}}" type="checkbox">
								@endif
								@if($expert->phases->where("phase_id", $phase->p_id)->first() != null)
								<input class="form-control input-sm text-right expertisePercentage" content='{{$expert->p_e_id}}' 2ndContent='{{$phase->p_id}}' placeholder="%" disabled style="width: 80%; float: left;" type="number" max="100" min="0" value='{{$expert->phases->where("phase_id", $phase->p_id)->first()->percentage}}'>
								@else
								<input class="form-control input-sm text-right expertisePercentage" content='{{$expert->p_e_id}}' 2ndContent='{{$phase->p_id}}' placeholder="%" disabled style="width: 80%; float: left;" type="number" max="100" min="0">
								@endif
							</td>
							@endforeach
							<td>
							@if($expert->e_value != null)
								<input class="form-control input-sm text-right valueInput expert{{$expert->p_e_id}}" value="{{$expert->e_value}}" placeholder="€" disabled  type="number" min="0">
							@else
								<input class="form-control input-sm text-right valueInput expert{{$expert->p_e_id}}" placeholder="€" disabled  type="number" min="0">
							@endif
							</td>
							@foreach($expert->subExpertise as $subExpert)
							<tr class="subExpertise{{$expert->p_e_id}}">
								<td><span style="padding-left: 10%;">{{$subExpert->e_sigla}} - {{$subExpert->e_name}}</span></td>
								@foreach($projectPhases as $phase)
								<td class="text-center" style="max-width: 30px;">
									@if($subExpert->phases->contains('phase_id', $phase->p_id))
									<input disabled checked class="expertCheckbox expertCheckbox{{$phase->p_id}}{{$subExpert->e_parent}}" 2ndContent="{{$phase->p_id}}" content="{{$subExpert->e_id}}" style="float: left;" type="checkbox">
									@else
									<input disabled class="expertCheckbox expertCheckbox{{$phase->p_id}}{{$subExpert->e_parent}}" 2ndContent="{{$phase->p_id}}" content="{{$subExpert->e_id}}" style="float: left;" type="checkbox">
									@endif
									<input disabled class="form-control input-sm text-right" placeholder="%" style="width: 80%; float: left;" type="number" max="100" min="0">
								</td>
								@endforeach
							</tr>
						@endforeach
						</tr>
						@endforeach
						<tr>
							<td>Total</td>
							@foreach($projectPhases as $phase)
							<td></td>
							@endforeach
							<td><input class="form-control input-sm text-right valueTotal" placeholder="€" disabled  type="number" min="0"></td>
						</tr>
					</tbody>
				</table>
				<table class="expertiseTable hidden table table-responsive borderless smallFontTable" style="width: 40%; float: right;">
					<thead>
						<th>Especialidade</th>
						<th>Ações</th>
						<th><button style="padding: 3px 5px;" class="btn btn-primary expertiseHiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
					</thead>
					<tr class="hidden expertiseHiddenForm">
						<form action="/commercialProject/expertise/addExpertise/{{$project->id}}" method="POST">
							<td>
								<select class="form-control input-sm" name="expertise">
									@foreach($expertise as $expert)
										<option value="{{$expert->id}}">{{$expert->sigla}} - {{$expert->name}}</option>
									@endforeach
								</select>
							</td>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
						</form>
					</tr>
					@foreach($projectExpertise as $expert)
					<tr>
						<td>{{$expert->e_sigla}} - {{$expert->e_name}}</td>
						<td data-editable='false'><button style="padding: 3px 5px;" content='{{$expert->p_e_id}}' class="btn btn-primary hiddenFormSubExpertButton" type="button"><i class="glyphicon glyphicon-plus"></i></button> 
						<button content='{{$expert->p_e_id}}' style="padding: 3px 5px;" class="btn btn-danger removeExpertise" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
						<tr class="subExpertiseForm{{$expert->p_e_id}} hidden">
							<form action="/commercialProject/expertise/addExpertise/{{$project->id}}" method="POST">
								<td style="padding-left: 40px;">
									<select class="form-control input-sm" name="expertise">
										@foreach($subExpertise as $subExpert)
										@if($subExpert->parent == $expert->e_id)
											<option value="{{$subExpert->id}}">{{$subExpert->sigla}} - {{$subExpert->name}}</option>
										@endif
										@endforeach
									</select>
								</td>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
							</form>
						</tr>
						@foreach($expert->subExpertise as $subExpert)
						<tr class="subExpertise{{$expert->p_e_id}}">
								<td style="padding-left: 40px !important;">{{$subExpert->e_sigla}} - {{$subExpert->e_name}}</td>
								<td><button content='{{$subExpert->p_e_id}}' style="padding: 3px 5px;" class="btn btn-danger removeExpertise" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
						</tr>
						@endforeach
					</tr>
					@endforeach
				</table>
				<table class="phaseTable hidden table table-responsive borderless smallFontTable" style="width: 40%; float: right;">
					<thead>
						<th>Fase</th>
						<th>Ação</th>
						<th><button style="padding: 3px 5px;" class="btn btn-primary phasesHiddenFormButton" type="button"><i class="glyphicon glyphicon-plus"></i></button></th>
					</thead>
					<tr class="hidden phasesHiddenForm">
						<form action="/commercialProject/phases/addPhase/{{$project->id}}" method="POST">
							<td>
								<select class="form-control input-sm" name="phase">
									@foreach($phases as $phase)
										<option value="{{$phase->id}}">{{$phase->sigla}} - {{$phase->name}}</option>
									@endforeach
								</select>
							</td>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<td><button type="submit" class="btn btn-primary input-sm">Inserir</button></td>
						</form>
					</tr>
					@foreach($projectPhases as $phase)
					<tr>
						<td>{{$phase->p_sigla}} - {{$phase->p_name}}</td>
						<td data-editable='false'><button content='{{$phase->proj_p_id}}' style="padding: 3px 5px;" class="btn btn-danger removePhase" type="button"><i class="glyphicon glyphicon-minus"></i></button></td>
					</tr>
					@endforeach
				</table>
				<table class="table borderless" style="width: auto; clear: left;">
					<tbody>
						<tr>
							<td>Valor s/iva</td>
							<td class="noIvaValue"><span>0</span> €</td>
						</tr>
						<tr>
							<td style="vertical-align: middle !important;">IVA</td>
							<td style="vertical-align: middle !important;">
								<select class="ivaSelect form-control input-sm">
								@foreach($iva as $ivaOption)
								<option value="{{$ivaOption->id}}">{{$ivaOption->percentage}}</option>
								@endforeach
								</select>
							</td>
						</tr>	
						<tr>
							<td>Valor c/iva</td>
							<td class="ivaValue"><span>0</span> €</td>
						</tr>
						<tr>	
							<td style="vertical-align: middle !important;">Preço (€)/h</td>
							<td style="vertical-align: middle !important;">
								<select class="hourlyRateSelect form-control input-sm">
								@foreach($hourlyRate as $rate)
								<option value="{{$rate->id}}">{{$rate->value}}</option>
								@endforeach
								</select>
							</td>
						</tr>
						<tr>
							<td>Horas Previstas</td>
							<td class="estimatedHours"><span>0</span> h</td>
						</tr>
						<tr></tr>
						<tr>
							<td><button type="button" class="btn btn-success saveButton hidden btn-xs">Guardar</button></td>
						</tr>
					</tbody>
				</table>	
			</div>
		</div>
	</div>
</div>

<script>
$('.expertiseHiddenFormButton').click(function() {
	$('.expertiseHiddenForm').removeClass('hidden');
});

$('.phasesHiddenFormButton').click(function() {
	$('.phasesHiddenForm').removeClass('hidden');
});

$('.hiddenFormSubExpertButton').click(function() {
	var id = $(this).attr('content');
	$('.subExpertiseForm' + id).removeClass('hidden');
})

$('.removeExpertise').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().remove();
	$('.subExpertiseForm' + id).remove();
	$('.subExpertise' + id).remove();
	$.get('/project/deleteExpertise/' + id, function() {
	});
});

$('.removePhase').click(function() {
	var id = $(this).attr('content');
	$(this).parent().parent().remove();
	$.get('/project/deletePhase/' + id, function() {
	});
});

$('.expertCheckbox').change(function() {
	if($(this).is(":checked")) {
		var content = $(this).attr('content');
		var secondContent = $(this).attr('2ndContent');
		$('.expertCheckbox' + secondContent + content).prop('checked', true);
	}
});

$('.saveButton').click(function() {
	var obj = {};
	$('.phasesSelectTable .expertCheckbox').each(function() {
		if($(this).is(':checked')) {
			if(obj[$(this).attr('content')] == null)
				obj[$(this).attr('content')] = new Array();
			obj[$(this).attr('content')].push($(this).attr('2ndContent'));
		} else {
			if(obj[$(this).attr('content')] == null)
				obj[$(this).attr('content')] = new Array();
			obj[$(this).attr('content')].push('-' + $(this).attr('2ndContent'));
		}
	});

	var percentages = {};
	$('.phasesSelectTable .expertisePercentage').each(function() {
		if(percentages[$(this).attr('content')] == null)
			percentages[$(this).attr('content')] = new Array();
		percentages[$(this).attr('content')].push([$(this).attr('2ndContent'), this.value]);
		
	});

	var expertValues = {};
	@foreach($projectExpertise as $expertise)
		var value = $('.expert{{$expertise->p_e_id}}').val();
		expertValues['{{$expertise->p_e_id}}'] = value;
	@endforeach

	$.ajax({
	  type: "POST",
	  url: '/commercialProject/expertise/editExpertisePhases',
	  data: {
	  	'obj': obj,
	  	'project_id': {{$project->id}},
	  	'expertValues': expertValues,
	  	'percentages': percentages
	  },
	  success: function(response) {
	  	location.reload();
	  }
	});
});

function updateValues() {
	var value = 0;
	$('.valueInput').each(function() {
		if(this.value > 0)
			value += parseInt(this.value);
	})
	$('.valueTotal').val(value);
	$('.noIvaValue span').text(value);
	var iva = $('.ivaSelect option:selected').text() / 100;
	$('.ivaValue span').text(value - (iva * value));
	$('.estimatedHours span').text($('.ivaValue span').text() / $('.hourlyRateSelect option:selected').text());
}

updateValues();

$('.valueInput').keyup(function() {
	updateValues();
})

$('.ivaSelect').change(function() {
	updateValues();
})

if({{Auth::user()->profile == 1}}) {
	$('input').each(function() {
		$(this).prop('disabled', false);
	})
	$('.valueTotal').prop('disabled', true);
	$('.expertiseTable').removeClass('hidden');
	$('.phaseTable').removeClass('hidden');
	$('.saveButton').removeClass('hidden');
}
</script>

@endsection