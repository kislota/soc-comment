<?php

/**
 * @param string $value
 */
function dd($value = '')
{
    echo '<pre>';
    var_dump($value);
    die;
}

/**
 * @param $url
 */
function redirect($url)
{
    header('location: ' . $url);
    exit;
}