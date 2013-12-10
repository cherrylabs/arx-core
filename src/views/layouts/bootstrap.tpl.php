@extends('arx::html')

@section('head')
    @parent
    @section('css')
       <link rel="stylesheet" href="<% asset('/packages/arx/dist/css/arx-combined.css') %>" />
        <% Hook::output('css') %>
    @show
@stop

@section('content')
    @parent
    @section('js')
        <script type="text/javascript" src="<% asset('/packages/arx/dist/js/arx-combined.js') %>"></script>
        <% Hook::output('js') %>
    @stop
@stop

