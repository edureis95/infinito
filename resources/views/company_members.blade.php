@extends('layouts.app')

@section('content')

<style>
.buttonJquery {
cursor: pointer; 
	cursor: hand;
}
</style>	
<div class="col-xs-12" style="max-width: 98%;">
@include('layouts.company_nav')
<div class="row">
	<hr style="margin-top: 0; margin-left: 0; width: 104%; border-color: #DCDCDC;">
</div>
</div>
	<ul class="list-group">
		<li class="list-group-item borderless"> 
			<div class="row">
				<div class="col-xs-12 members">
					<div id="displaySquares" class="hidden">
					@foreach($members as $member)
                    <div class="col-xs-4">
                    		<div class="row">
                    		<div class="col-xs-12">
                            	<img src="/uploads/avatars/{{ $member->avatar }}" alt="" class="img img-responsive thumbnail" style="min-width:15; vertical-align: middle;max-height: 100px;">
                            </div> 
                            </div>
                            <div class="row">
                            <div class="col-xs-12">
                            	<p> {{ $member->name }}</p>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-xs-12">
                            	<p> Função: {{$member->department_name}} </p>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-xs-12">
								<p> Email: {{$member->email}}</p>
							</div>
							</div>
							@if($member->cell_phone != '')
							<div class="row">
							<div class="col-xs-12">
								<p> Telemóvel: {{$member->cell_phone}} </p>
							</div>
							</div>
							@else
							<div class="row">
							<div class="col-xs-12">
								<p> Telemóvel: Não tem </p>
							</div>
							</div>
							@endif
                    </div>
                    @endforeach 
                    </div>       

					<table class="table table-responsive smallFontTable" style="overflow-x: scroll;" id="displayLine"> 
                        <thead> 
                            <tr>
                                <th class="text-center">Foto</th>
                                <th class="text-left">Nome</th>
                                <th class="text-left">Sigla</th>
                                <th class="text-left">Departamento</th> 
                                <th class="text-left">Função</th> 
                                <th class="text-left">Email</th>
                                <th class="text-left">Skype</th>
                                <th class="text-left">Telemóvel</th> 
                            </tr>                                     
                        </thead>                       
                        <tbody class="text-left"> 
                        @foreach($members as $member)
                            <tr> 
                                <td class="text-center">
                                	<img src="/uploads/avatars/{{ $member->avatar }}" alt="" class="" style="min-width:15; max-width: 50px; max-height: 50px;"> 	
                                </td>
                                <td>
                                    <span>{{ $member->name }}</span>
                                </td>
                                <td>
                                	<span>{{$member->sigla}}</span>
                                </td>
                                <td>
                                    <span>{{$member->department_name}}</span>
                                </td>
                                <td>
                                	<span>Sem Função</span>
                                </td>
                                <td>
                                    @if($member->email != '')
									<span>{{$member->email}}</span>
									@endif
								</td>
								<td>
									@if($member->skype != '')
									<span>{{$member->skype}}</span>
									@endif
								</td>
								<td>
									@if($member->cell_phone != '')
									<span>{{$member->cell_phone}} </span>
									@endif
								</td>                                               
                                </div>
                                </td>                                                                                                 
                                <!--<td>
                                	@if($member->email != '')
									<p> Email: {{$member->email}} </p>
									@endif

									@if($member->cell_phone != '')
									<p> Telemóvel: {{$member->cell_phone}} </p>
									@endif

									@if($member->desk_phone != '')
									<p> Telefone: {{$member->desk_phone}} </p>
									@endif

									@if($member->skype != '')
									<p> Skype: {{$member->skype}} </p>
									@endif
                                </td>
                                <td>
                                	@foreach($member->supervisors as $supervisor)
									<p>Supervisor: {{$supervisor->name}}</p>
									@endforeach
									<p>{{$member->department_name}}</p>
                                </td> -->
                            </tr> 
                        @endforeach                                                                       
                        </tbody>
                    </table>
				</div>
			</div>
		</li>
	</ul>
</div>

<script>
$('#squares').click(function() {
	$('#displaySquares').removeClass('hidden');
	$('#displayLine').addClass('hidden');
});
$('#bullets').click(function() {
	$('#displayLine').removeClass('hidden');
	$('#displaySquares').addClass('hidden');
});
</script>

@endsection