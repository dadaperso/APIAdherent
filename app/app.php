<?php
/**
 * Created by PhpStorm.
 * User: dada
 * Date: 15/01/2016
 * Time: 18:30
 */

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Templating Service
$app->register(new \Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app['twig'] = $app->share($app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
}));

$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new \Silex\Provider\UrlGeneratorServiceProvider());

// Register Logging Service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/webservices.log',
    'monolog.name' => 'WebServices',
    'monolog.level' => $app['monolog.level']
));

// Profiler Service
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
if (isset($app['debug']) && $app['debug']) {
    $app->register(new Silex\Provider\HttpFragmentServiceProvider());
    $app->register(new Silex\Provider\WebProfilerServiceProvider(), array(
        'profiler.cache_dir' => __DIR__.'/../var/cache/profiler'
    ));
}

// Register services
$app['dao.user.reader'] = $app->share(function ($app) {
    $userTable = __DIR__.'/../db/users.csv';
    if(!file_exists($userTable)){
        $app->abort(404, "Le fichier d’entrée est introuvable");
    }

    $userReaderDAO = new \WebService\DAO\UserReaderDAO($userTable);

    return $userReaderDAO;
});


// Catch exception and return it in JSON format
$app->error(function (\Exception $e, $code) use($app) {
    switch ($code) {
        case 404:
            $responseData['code'] = 404;
            $responseData['msg']  = $e->getMessage();
            break;
        default:
            $responseData['code'] = $code;
            $responseData['msg'] = $e->getMessage();
    }
    return new JsonResponse($responseData, $code);
});
