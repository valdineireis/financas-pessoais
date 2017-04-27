<?php
use Psr\Http\Message\ServerRequestInterface;

$app
    ->get('/statements', function (ServerRequestInterface $request) use ($app) {
    	$view = $app->service('view.renderer');
    	return $view->render('statements.html.twig');
    }, 'statements.list');