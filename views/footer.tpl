<style type="text/css">

        /* Sticky footer styles
        -------------------------------------------------- */

    html,
    body {
        height: 100%;
        /* The html and body elements cannot have any padding or margin. */
    }

        /* Wrapper for page content to push down footer */
    #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it's height */
        margin: 0 auto -60px;
    }

        /* Set the fixed height of the footer here */
    #push,
    #footer {
        height: 60px;
    }
    #footer {
        background-color: #f5f5f5;
    }

        /* Lastly, apply responsive CSS fixes as necessary */
    @media (max-width: 767px) {
        #footer {
            margin-left: -20px;
            margin-right: -20px;
            padding-left: 20px;
            padding-right: 20px;
        }
    }



        /* Custom page CSS
        -------------------------------------------------- */
        /* Not required for template or sticky footer method. */

    #wrap > .container {
        padding-top: 60px;
    }
    .container .credit {
        margin: 20px 0;
    }

    code {
        font-size: 80%;
    }

</style>

<div id="footer">
    <div class="container">
        <p class="muted credit">Arx 2013© Powered by <a href="http://www.cherrylabs.net">5th Power</a></p>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?= ARX_JS ?>/bootstrap.min.js"></script>
<script src="<?= ARX_JS ?>/sparkline.js"></script>
<script src="<?= ARX_JS ?>/morris.min.js"></script>
<script src="<?= ARX_JS ?>/jquery.dataTables.min.js"></script>
<script src="<?= ARX_JS ?>/jquery.masonry.min.js"></script>
<script src="<?= ARX_JS ?>/jquery.imagesloaded.min.js"></script>
<script src="<?= ARX_JS ?>/jquery.facybox.js"></script>
<script src="<?= ARX_JS ?>/jquery.alertify.min.js"></script>
<script src="<?= ARX_JS ?>/jquery.knob.js"></script>
<script src="<?= ARX_JS ?>/fullcalendar.min.js"></script>
<script src="<?= ARX_JS ?>/jquery.gritter.min.js"></script>
<script src="<?= ARX_JS ?>/bootstrap-datepicker.js"></script>

<script src="<?= ARX_JS ?>/script.js"></script>

<script src="<?= APP_URL ?>/assets/js/datamanager.js"></script>
<?php
	echo \arx\c_hook::output('js');
?>

<script type="text/javascript">
	$(function () {
		<?php echo \arx\c_hook::output('domReady') ?>
	});
</script>