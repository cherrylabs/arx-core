@extends('arx::html')

@section('head')
    @parent

    <% Hook::output('css') %>
@stop

@section('body')
    @yield('content')
@stop

<% Hook::output('js') %>