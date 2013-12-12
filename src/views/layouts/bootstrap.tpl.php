@extends('arx::html')

@section('head')
    @parent

    @section('css')
    <link rel="stylesheet" href="/packages/arx/dist/css/arx-combined.css" />
    <% Hook::output('css') %>
    @show
@stop

@section('js')
    <script type="text/javascript" src="<% url('/packages/arx/dist/js/arx-combined.js') %>"></script>
    <% Hook::output('js') %>
@stop