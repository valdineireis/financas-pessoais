<?php
use Psr\Http\Message\ServerRequestInterface;

$app
    ->get(
        '/charts', function (ServerRequestInterface $request) use ($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('category-cost.repository');
            $auth = $app->service('auth');
            $data = $request->getQueryParams();

            $dateStart = dateTryParse($data['date_start'] ?? (new \DateTime())->modify('-1 month'));
            $dateEnd = dateTryParse($data['date_end'] ?? new \DateTime());

            $categories = $repository->sumByPeriod($dateStart, $dateEnd, $auth->user()->getId());

            return $view->render(
                'charts.html.twig', [
                'categories' => $categories,
                'dateStart' => $dateStart,
                'dateEnd' => $dateEnd
                ]
            );
        }, 'charts.list'
    );
