<?php

/**
 * require to autoload
 */
require_once __DIR__ . '/autoload.php';

/**
 * require to load modules
 */
$modules = glob(__DIR__ . '/modules/*.modules.php');

foreach ($modules as $module) {
    require_once $module;
}