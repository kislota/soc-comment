<?php
if (version_compare(phpversion(), '7.0.0', '<') == true) { die ('Версия PHP ниже 7.0'); }
use core\App;
session_start();
require_once  __DIR__ . '/../core/load.php';
$app = new App();