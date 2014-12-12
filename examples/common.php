<?php

if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
} else {
    require_once __DIR__ . '/../../../autoload.php';
}

$hueHost     = getenv('HUE_HOST');
$hueUsername = getenv('HUE_USERNAME');
