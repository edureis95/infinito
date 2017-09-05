@extends('layouts.app')

@section('content')

<script type="text/javascript" src="/js/canvasjs.min.js"></script>
<div class="col-xs-12 insideContainer">
	@include('layouts.project_nav')
	@include('layouts.project_management_nav')
	<div class="panel panel-default borderless">
		<div class="panel-body">
			<div>
				<p>Tempo de Execução: {{$task_timer_hours}}</p>
				<p>Nº de Tarefas: {{$totalNumberTasks}}</p>
			</div>
			<div id="taskByType" class="chart" style="float: left; height: 40%; width: 50%;"></div>
			<div id="members" class="chart" style="float: left; height: 40%; width: 50%;"></div>
			<div id="expertise" class="chart" style="float: left; height: 40%; width: 50%; margin-top: 50px;"></div>
			<div id="phases" class="chart" style="float: left; height: 40%; width: 50%; margin-top: 50px;"></div>
		</div>
	</div>
</div>
<style>
.canvasjs-chart-credit {
   display: none;
}
</style>

<script>

var array = [];
@foreach(json_decode($pieDataTaskType) as $key => $data)
	var object = {};
	object['y'] = {{$data}};
	object['indexLabel'] = '{{$key}}';
	array.push(object);
@endforeach

var membersArray = [];
@foreach(json_decode($pieDataMembers) as $key => $data)
	var object = {};
	object['y'] = {{$data}};
	object['indexLabel'] = '{{$key}}';
	membersArray.push(object);
@endforeach

var expertiseArray = [];
@foreach(json_decode($pieDataExpertise) as $key => $data)
	var object = {};
	object['y'] = {{$data}};
	object['indexLabel'] = '{{$key}}';
	expertiseArray.push(object);
@endforeach

var phasesArray = [];
@foreach(json_decode($pieDataPhases) as $key => $data)
	var object = {};
	object['y'] = {{$data}};
	object['indexLabel'] = '{{$key}}';
	phasesArray.push(object);
@endforeach

var chart = new CanvasJS.Chart("taskByType",
{
	title:{
		text: "Nº de Tarefas por Tipo"
	},		
	data: [
	{       
		type: "pie",
		showInLegend: true,
		indexLabel:"#percent",
		toolTipContent: "{y} - #percent %",
		legendText: "{indexLabel}",
		dataPoints: array
	}
	]
});
chart.render();

var membersChart = new CanvasJS.Chart("members",
{
	title:{
		text: "Nº de Horas por Colaborador"
	},		
	data: [
	{       
		type: "pie",
		showInLegend: true,
		toolTipContent: "{y} h - #percent %",
		legendText: "{indexLabel}",
		dataPoints: membersArray
	}
	]
});
membersChart.render();

var expertiseChart = new CanvasJS.Chart("expertise",
{
	title:{
		text: "Nº de Horas por Especialidade"
	},		
	data: [
	{       
		type: "pie",
		showInLegend: true,
		toolTipContent: "{y} h - #percent %",
		legendText: "{indexLabel}",
		dataPoints: expertiseArray
	}
	]
});
expertiseChart.render();

var phasesChart = new CanvasJS.Chart("phases",
{
	title:{
		text: "Nº de Horas por Fase"
	},		
	data: [
	{       
		type: "pie",
		showInLegend: true,
		toolTipContent: "{y} h - #percent %",
		legendText: "{indexLabel}",
		dataPoints: phasesArray
	}
	]
});
phasesChart.render();

</script>


@endsection