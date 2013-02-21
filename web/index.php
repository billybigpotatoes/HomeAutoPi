<?php 
// web/index.php

require_once __DIR__.'/../vendor/autoload.php';

use Silex\ServiceProviderInterface;
use Silex\Application;


class Test implements ServiceProviderInterface {

  public function register(Application $app){
    $app['test_service'] = $app->share(function() use($app) {
      return new Test();
    });
  }

  public function boot(Application $app) {
  }

  public function hi() {
    return "hi";
  }
}


$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../development.log',
));

$app->register(new Test());

$app->get('/ninja', function() use ($app) {
    return 'Hello Ninja';
});

$app->get('/hello/{name}', function($name) use ($app) {
    $app['monolog']->addInfo(sprintf("User '%s' registered.", $name));
    $name = $app['test_service']->hi().$name;;
    return $app['twig']->render('hello.html.twig', array('name' => $name));
});

$app->get('/', function() use ($app) {
    return $app['twig']->render('index.html.twig');
});


$app->run();
