@if(Session::has('notify.options'))
<script type="text/javascript">
$(function(){
    window.notify = $.notify(<?php
    echo json_encode(Session::get('notify.options'));
?>, <?php
    echo json_encode(Session::get('notify.settings'));
?>);
});
</script>
@endif