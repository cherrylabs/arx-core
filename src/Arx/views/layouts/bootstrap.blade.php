@extends('arx::html')

@section('head')
    @parent
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
@stop

@section('body')
    @include('arx::snippets.container')
@stop

@section('js')
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
@stop