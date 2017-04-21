<?php 

use Psr\Http\Message\ServerRequestInterface;

$app
	->get('/bill-receives', function() use($app) {
		$repository = $app->service('bill-receive.repository');
		$view = $app->service('view.renderer');
		$auth = $app->service('auth');

		$bills = $repository->findByField('user_id', $auth->user()->getId());

		return $view->render('bill-receives/list.html.twig', [
			'bills' => $bills
		]);

	}, 'bill-receives.list')

	->get('/bill-receives/new', function() use($app) {
		$view = $app->service('view.renderer');
		return $view->render('bill-receives/create.html.twig');
	}, 'bill-receives.new')

	->post('/bill-receives/store', function(ServerRequestInterface $request) use($app) {
		$repository = $app->service('bill-receive.repository');
		$auth = $app->service('auth');

		$data = $request->getParsedBody();
		$data['user_id'] = $auth->user()->getId();
		$data['date_launch'] = dateParse($data['date_launch']);
		$data['value'] = numberParse($data['value']);

		$repository->create($data);

		return $app->route('bill-receives.list');

	}, 'bill-receives.store')

	->get('/bill-receives/{id}/edit', function(ServerRequestInterface $request) use($app) {
		$repository = $app->service('bill-receive.repository');
		$auth = $app->service('auth');
		$view = $app->service('view.renderer');
		$id = $request->getAttribute('id');

		$bill = $repository->findOneBy([
			'id' => $id,
			'user_id' => $auth->user()->getId()
		]);

		return $view->render('bill-receives/edit.html.twig', [
			'bill' => $bill
		]);

	}, 'bill-receives.edit')

	->post('/bill-receives/{id}/update', function(ServerRequestInterface $request) use($app) {
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

		return $app->route('bill-receives.list');

	}, 'bill-receives.update')

	->get('/bill-receives/{id}/show', function(ServerRequestInterface $request) use($app) {
		$repository = $app->service('bill-receive.repository');
		$auth = $app->service('auth');
		$view = $app->service('view.renderer');
		$id = $request->getAttribute('id');

		$bill = $repository->findOneBy([
			'id' => $id,
			'user_id' => $auth->user()->getId()
		]);

		return $view->render('bill-receives/show.html.twig', [
			'bill' => $bill
		]);

	}, 'bill-receives.show')

	->get('/bill-receives/{id}/delete', function(ServerRequestInterface $request) use($app) {
		$repository = $app->service('bill-receive.repository');
		$auth = $app->service('auth');
		$id = $request->getAttribute('id');

		$repository->delete([
			'id' => $id,
			'user_id' => $auth->user()->getId()
		]);

		return $app->route('bill-receives.list');

	}, 'bill-receives.delete');