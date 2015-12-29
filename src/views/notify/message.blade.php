@if (Session::has('notify.options'))
    <div class="alert alert-{{ Session::get('notify.settings.type', 'info') }} animated fadeIn">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! Session::get('notify.options.message') !!}
    </div>
@endif