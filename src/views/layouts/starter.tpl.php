@extends('arx::layouts.bootstrap')

@section('head')
    @parent
@stop

@section('body')

@section('navbar')
    @include('arx::snippets.navbars.top-fixed')
@show

@section('container')
<div class="container">
    @show
</div> <!-- /container -->
@yield('content')

@stop