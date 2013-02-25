<?php

require_once 'core.php';

$manifest = new c_manifest();

$manifest->version = "0.1b";

$manifest->title = "Arx";

$manifest->description = "The reflexive kit";

$manifest->url = "http://www.arx.xxx";

$manifest->icon = "icon-arx";

$manifest->license = "GTPL/MIT Licence";

$manifest->output();
