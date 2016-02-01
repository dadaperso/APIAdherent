<?php
/**
 * Created by PhpStorm.
 * User: dada
 * Date: 15/01/2016
 * Time: 18:36
 */

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

//require __DIR__.'/../app/config/dev.php';
require __DIR__.'/../app/config/prod.php';
require __DIR__.'/../app/app.php';
require __DIR__.'/../app/routes.php';

$app->run();