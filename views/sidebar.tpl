<ul class="nav nav-tabs nav-stacked">
    <script type="texT/mustache" id="sidebar">
        <li>{{filename}}</li>
    </script>
    <script>
        can.control('#sidebar', aSidebar);
    </script>
    <?php
        $this->a_mustache();
    ?>
</ul>
<script id="sidebar">
    var aSidebar = <?= json_encode($aMenu) ?>;
</script>