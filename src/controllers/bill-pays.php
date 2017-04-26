<?php 

use Psr\Http\Message\ServerRequestInterface;

$app
	->get('/bill-pays', function() use($app) {
		$repository = $app->service('bill-receive.repository');
		$view = $app->service('view.renderer');
		$auth = $app->service('auth');

		$bills = $repository->findByField('user_id', $auth->user()->getId());

		return $view->render('bill-pays/list.html.twig', [
			'bills' => $bills
		]);

	}, 'bill-pays.list')

	->get('/bill-pays/new', function() use($app) {
		$view = $app->service('view.renderer');
		return $view->render('bill-pays/create.html.twig');
	}, 'bill-pays.new')

	->post('/bill-pays/store', function(ServerRequestInterface $request) use($app) {
		$repository = $app->service('bill-receive.repository');
		$auth = $app->service('auth');

		$data = $request->getParsedBody();
		$data['user_id'] = $auth->user()->getId();
		$data['date_launch'] = dateParse($data['date_launch']);
		$data['value'] = numberParse($data['value']);

		$repository->create($data);

		return $app->route('bill-pays.list');

	}, 'bill-pays.store')

	->get('/bill-pays/{id}/edit', function(ServerRequestInterface $request) use($app) {
		$repository = $app->service('bill-receive.repository');
		$auth = $app->service('auth');
		$view = $app->service('view.renderer');
		$id = $request->getAttribute('id');

		$bill = $repository->findOneBy([
			'id' => $id,
			'user_id' => $auth->user()->getId()
		]);

		return $view->render('bill-pays/edit.html.twig', [
			'bill' => $bill
		]);

	}, 'bill-pays.edit')

	->post('/bill-pays/{id}/update', function(ServerRequestInterface $request) use($app) {
		$repository = $app->service('bill-receive.repository');
		$auth = $app->service('auth');

		$id = $request->getAttribute('id');
		$data = $request->getParsedBody();
		$data['user_id'] = $auth->user()->getId();
		$data['date_launch'] = dateParse($data['date_launch']);
		$data['value'] = numberParse($data['value']);

		$repository->update([
			'id' => $id,
			'user_id' => $auth->user()->getId()
		], $data);

		return $app->route('bill-pays.list');

	}, 'bill-pays.update')

	->get('/bill-pays/{id}/show', function(ServerRequestInterface $request) use($app) {
		$repository = $app->service('bill-receive.repository');
		$auth = $app->service('auth');
		$view = $app->service('view.renderer');
		$id = $request->getAttribute('id');

		$bill = $repository->findOneBy([
			'id' => $id,
			'user_id' => $auth->user()->getId()
		]);

		return $view->render('bill-pays/show.html.twig', [
			'bill' => $bill
		]);

	}, 'bill-pays.show')

	->get('/bill-pays/{id}/delete', function(ServerRequestInterface $request) use($app) {
		$repository = $app->service('bill-receive.repository');
		$auth = $app->service('auth');
		$id = $request->getAttribute('id');

		$repository->delete([
			'id' => $id,
			'user_id' => $auth->user()->getId()
		]);

		return $app->route('bill-pays.list');

	}, 'bill-pays.delete');