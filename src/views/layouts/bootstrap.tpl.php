@extends('arx::html')

@section('head')
    @parent

    @section('css')
    <link rel="stylesheet" href="<% Config::get('arx::theme.path') %>/dist/css/arx-combined.css" />
    <% Hook::output('css') %>
    @show
@stop

@section('js')
    <script type="text/javascript" src="<% Config::get('arx::theme.path') %>/dist/js/arx-combined.js"></script>
    <% Hook::output('js') %>
@stop