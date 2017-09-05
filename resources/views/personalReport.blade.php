@extends('layouts.app')

@section('content')
<div class="col-xs-12 insideContainer">
	<div class="panel panel-default borderless">
		<div class="panel-body" style="padding-left: 0;">
			<table>
				<tbody>
					<tr>
						<td>Ano</td>
						<td>
							<select class="form-control yearSelect" style="width: 60%;">
								
							</select>
						</td>
					</tr>	
					<tr>
						<td></td>
						<td>Número de horas de trabalho:</td>
						<td class="executedHours">{{$numberOfExecutedHours}}</td>
					</tr>
					<tr>
						<td></td>
						<td>Número de horas previstas:</td>
						<td class="plannedHours">{{$numberOfPlannedHours}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
function appendYears() {
	var i,yr,now = new Date();

	for (i=0; i>=0; i++) {
	    yr = 2006 + i; // or whatever
	    $('.yearSelect').append($('<option/>').val(yr).text(yr));
	    if(yr == now.getFullYear())
	    	break;
	}

	$('.yearSelect option[value="' + now.getFullYear() + '"]').prop('selected', true);
}

appendYears();

$('.yearSelect').change(function() {
	var year = $(this).val();
	$.ajax({
      type: "POST",
      url: '/personal/reportFromYear',
      data: {
        'year' : year
      },
      success: function(response) {
        $('.executedHours').text(response[0]);
        $('.plannedHours').text(response[1]);
      }
    });
});
</script>
@endsection