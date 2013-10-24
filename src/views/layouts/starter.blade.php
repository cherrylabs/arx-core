@extends('arx::layouts.bootstrap')

@section('head')
    @parent
@stop

@section('body')

@section('navbar')
    @include('arx::snippets.navbars.top-fixed')
@show

<div class="container">
    @section('container')
        @yield('content')
    @show
</div> <!-- /container -->
@stop