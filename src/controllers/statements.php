<?php
use Psr\Http\Message\ServerRequestInterface;

$app
    ->get(
        '/statements', function (ServerRequestInterface $request) use ($app) {
            $view = $app->service('view.renderer');
            $repository = $app->service('statement.repository');
            $auth = $app->service('auth');
            $data = $request->getQueryParams();

            $dateStart = dateTryParse($data['date_start'] ?? (new \DateTime())->modify('-1 month'));
            $dateEnd = dateTryParse($data['date_end'] ?? new \DateTime());

            $statements = $repository->all($dateStart, $dateEnd, $auth->user()->getId());

            return $view->render(
                'statements.html.twig', [
                'statements' => $statements,
                'dateStart' => $dateStart,
                'dateEnd' => $dateEnd
                ]
            );
        }, 'statements.list'
    );
