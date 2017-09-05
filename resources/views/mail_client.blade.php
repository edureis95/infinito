@extends('layouts.app')


@section('content')
<link href="css/mail_client.css" rel="stylesheet" type="text/css" media="all">
<link href='//fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>

<style>

</style>

<div class="col-xs-12 insideContainer">
    <div class="panel panel-default borderless">
        <div class="panel-body" style="padding: 0">
            <div class="row">
            <iframe src="https://infinito.elementofinito.com/roundcube/" frameBorder="0" style="height: calc(100% - 70px); width: 100%"></iframe>   
        </div>
        </div>
    </div>
</div>

<script>
/*var locked = 0;
$('.lockSidebar').click(function() {
    locked = 1;
    $(this).addClass('hidden');
    $('.unlockSidebar').removeClass('hidden');
})

$('.unlockSidebar').click(function() {
    locked = 0;
    $(this).addClass('hidden');
    $('.lockSidebar').removeClass('hidden');
})

$('.sidebar').mouseenter(function(e) {
    $('.sidebar .pinSidebar').css('display', 'block');
    $( ".sidebar" ).animate({
        width: "170px"
      }, 150, function() {
        // Animation complete.
    });
    $('#page-wrapper').animate({
        "margin-left": "170px"
      }, 150, function() {
        // Animation complete.
    });
})*/

/*$('.sidebar').mouseleave(function(e) {
    if(locked == 0) {
        $('.sidebar .pinSidebar').css('display', 'none');
        $( ".sidebar" ).animate({
            width: "10px"
          }, 150, function() {
            // Animation complete.
        });
        $('#page-wrapper').animate({
            "margin-left": "10px"
          }, 150, function() {
            // Animation complete.
        });
    }
})  */

</script>

@endsection