@extends('arx::layouts.bootstrap')

@section('head')
    @parent
@stop

@section('body')

@include('arx::snippets.navbars.top-fixed')

<div class="container">
    @section('container')
        @yield('content')
    @show
</div> <!-- /container -->
@stop