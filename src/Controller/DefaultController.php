<?php
/**
 * Created by Yury Smidovich (Stmol)
 * Date: 17.01.14
 * Project: WebAPIClient
 * Url: http://stmol.me
 * Email: dev@stmol.me
 */

namespace WebApiClient\Controller;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use WebApiClient\Client\Request as WebApiRequest;
use WebApiClient\Client\RequestOptions;
use WebApiClient\Form\WebApiFormType;

class DefaultController implements ControllerProviderInterface
{
    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $app['web_api_form'] = function () use ($app) {
            $options = new RequestOptions();

            return $app["form.factory"]
                ->create(new WebApiFormType(), $options)
                ->add('submit', 'submit', array('label' => 'Send'));
        };

        // GET /
        $controllers->get('/', function () use ($app) {

            /** @var Form $form */
            $form = $app['web_api_form'];

            return $app['twig']->render('index.html.twig', array(
                'form' => $form->createView(),
            ));
        })->bind('home');

        // POST /
        $controllers->post('/', function (Request $request) use ($app) {

            /** @var Form $form */
            $form = $app['web_api_form'];

            $form->handleRequest($request);

            if ($form->isValid()) {
                $client = new WebApiRequest($form->getData());
                $response = $client->send();

                return $app['twig']->render('index.html.twig', array(
                    'form'     => $form->createView(),
                    'response' => $response,
                ));
            }

            return $app['twig']->render('index.html.twig', array(
                'form' => $form->createView(),
            ));
        });

        return $controllers;
    }
}