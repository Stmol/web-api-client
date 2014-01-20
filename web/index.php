<?php
/**
 * Created by Yury Smidovich (Stmol)
 * Date: 17.01.14
 * Project: WebAPIClient
 * Url: http://stmol.me
 * Email: dev@stmol.me
 */

use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;

ini_set('display_errors', 1);

require_once __DIR__.'/../vendor/autoload.php';

$app = new Application();

$app['debug'] = true;

$app
    ->register(new FormServiceProvider())
    ->register(new TranslationServiceProvider())
    ->register(new TwigServiceProvider(), array(
        'twig.path'    => __DIR__.'/../views',
    ));

$app->error(function (\Exception $e) use($app) {
    return $app['twig']->render('error.html.twig', array('error' => $e->getMessage()));
});

$app
    ->mount('/', new \WebApiClient\Controller\DefaultController())
    ->run();
