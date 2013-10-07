@extends('arx::layouts.bootstrap')

@section('head')
    @parent
    <style>
        body {
            padding-top: 60px;
        }
    </style>
@stop

@section('body')

@include('arx::snippets.navbars.top-fixed')

<div class="container">
    @section('container')
        @yield('content')
    @show
</div> <!-- /container -->
@stop