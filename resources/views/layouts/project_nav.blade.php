<div class="panel panel-default panelMenu borderless">
	<div class="panel-body link-nav">
		<span style="color: rgb(57,177,240); font-size: 20px;">{{str_pad($project->number, 5, '0', STR_PAD_LEFT)}} - {{$project->name}}</span>
		<div class="pull-right" style="margin-right: 20px;">
			<a href="/project/gantt/{{$project->id}}" class=" gestão" style="margin-right: 40px;"> <span>PROJETO</span> </a>
			<a href="/project/{{$project->id}}" class="informação"> <span>INFORMAÇÃO</span> </a>
		</div>
	</div>
</div>
<div class="row">
    <hr style="margin-top: 0; margin-left: 0; width: 100%; border-color: #DCDCDC; margin-bottom: 0;">
</div>