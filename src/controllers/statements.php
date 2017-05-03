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

            /*
            $dateStart = isset($data['date_start']) && !empty($data['date_start']) ? 
                $data['date_start'] : (new \DateTime())->modify('-1 month');
            $dateStart = $dateStart instanceof \DateTime ? $dateStart->format('Y-m-d') 
            : \DateTime::createFromFormat('d/m/Y', $dateStart)->format('Y-m-d');
            */

            $dateEnd = dateTryParse($data['date_end'] ?? new \DateTime());

            /*
            $dateEnd = isset($data['date_end']) && !empty($data['date_end']) ? 
                $data['date_end'] : new \DateTime();
            if (!($dateEnd instanceof \DateTime)) 
                $dateEnd = \DateTime::createFromFormat('d/m/Y', $dateEnd);
            if ($dateEnd === false) {
                throw new \InvalidArgumentException();
            } else {
                $dateEnd = $dateEnd->format('Y-m-d');
            }*/

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
