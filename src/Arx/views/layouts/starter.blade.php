@extends('layouts.bootstrap')

@section('head')
    @parent
    <style>
        body {
            padding-top: 60px;
        }
    </style>
@stop

@section('body')

@include('snippets.navbars.top-fixed')

<div class="container">
    @section('container')
    <h1>Bootstrap starter template</h1>
    <p>Use this document as a way to quick start any new project.<br> All you get is this message and a barebones HTML document.</p>
    @stop
</div> <!-- /container -->
@stop