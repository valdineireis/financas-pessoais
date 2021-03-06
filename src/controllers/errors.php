<?php

$app
    ->get(
        '/bad-request-400', function () use ($app) {
            $view = $app->service('view.renderer');
            return $view->render('400.html.twig');
        }, 'errors.400'
    )
    ->get(
        '/page-not-found-404', function () use ($app) {
            $view = $app->service('view.renderer');
            return $view->render('404.html.twig');
        }, 'errors.404'
    )
    ->get(
        '/forbidden-403', function () use ($app) {
            $view = $app->service('view.renderer');
            return $view->render('403.html.twig');
        }, 'errors.403'
    );
