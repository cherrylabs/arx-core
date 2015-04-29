@extends('arx::layouts.bootstrap')

@section('content')
    <div class="container" style="max-width: 1000px;">

        <div class="row">
            <div class="col-xs-12">
                <h1><?php echo $invoice['header']; ?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <h4><?php echo $invoice['title_left']; ?></h4>
            </div>
            <div class="col-sm-6 text-right">
                <h4><?php echo $invoice['title_right']; ?></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6">
                <table>
                    @foreach($invoice['block_left'] as $row)
                        <tr>
                            <td><?php echo $row ?: '&nbsp;'; ?></td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-xs-6 text-right">
                <table class="pull-right">
                @foreach($invoice['block_right'] as $row)
                    <tr>
                        <td><?php echo $row ?: '&nbsp;'; ?></td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3><strong><?php echo $invoice['body_title']; ?></strong></h3>

                <div class="table-responsive">
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                @foreach($invoice['table_header'] as $col)
                                    <td><?php echo $col; ?></td>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice['table'] as $row)
                            <tr>
                                @foreach($row as $col)
                                    <td><?php echo $col; ?></td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>


                        <tbody>
                        @foreach($invoice['table_footer'] as $row)
                            <tr>
                                @foreach($row as $key => $col)
                                    <td @if($key==0) class="text-right" colspan="<?php echo count($invoice['table_header']) - count($row) + 1; ?>" @endif><?php echo $col; ?></td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row text-center">
                <?php echo $invoice['footer']; ?>
            </div>
        </div>
    </div>
@stop

@section('js')
    @parent
    @if(Input::get('action') == 'download')
        <script>
            window.print();
        </script>
    @endif
@stop
