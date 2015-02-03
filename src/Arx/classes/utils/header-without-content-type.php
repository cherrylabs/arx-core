<?php
/**
 * Headers helper for the utils class
 */

$data = include_once __DIR__ . '/header.php';

return array_map(function ($n) {
    return str_replace('Content-Type:', "", $n);
}, $data);