@extends('arx::html')

@section('head')
    @parent
    @section('css')
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo url('/packages/arx/core/dist/css/arx-combined.css') ?>" />
    <?php echo Hook::output('css') ?>
    @show
@stop

@section('js')
    <script type="text/javascript" src="<?php echo url('/packages/arx/core/dist/js/arx-combined.js') ?>"></script>
    <?php echo Hook::output('js') ?>
@stop