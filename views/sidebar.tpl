<ul class="nav nav-tabs nav-stacked">
    <script type="texT/mustache" id="sidebar">
        <li>{{filename}}</li>
    </script>
    <script>
        can.control('#sidebar', aSidebar);
    </script>
    <?php

    ?>
</ul>
<script id="sidebar">
    var aSidebar = <?= json_encode($aMenu) ?>;
</script>