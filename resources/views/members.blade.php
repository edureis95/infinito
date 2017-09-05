@extends('layouts.app')

@section('content')

@foreach($members as $member)
	<p> {{ $member-> name }} </p>
@endforeach

@endsection