<?php
/**
 * Created by PhpStorm.
 * User: dada
 * Date: 15/01/2016
 * Time: 19:35
 */

// include the prod configuration
require __DIR__.'/prod.php';

// enable the debug mode
$app['debug'] = true;
// define log level
$app['monolog.level'] = 'INFO';