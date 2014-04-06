@extends('examples/blade-layout')

@section('heading')
	<h3>{{ $title }}</h3>
@stop

@section('body')
	<p>{{ $content }}</p>
@stop

@section('footer')
	@include('examples/blade-partial')
@stop