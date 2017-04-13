<?php 
declare(strict_types=1);

namespace VRSFin\Repository;

class DefaultRepository implements RepositoryInterface
{
	/**
	 * @var string
	 */
	private $modelClass;

	/**
	 * @var Model
	 */
	private $model;

	/**
	 * DefaultRepository constructor
	 * @param string $modelClass
	 */
	public function __construct(string $modelClass)
	{
		$this->modelClass = $modelClass;
		$this->model = new $modelClass;
	}

	public function all(): array
	{
		return $this-model->all();
	}

	public function create(array $data)
	{
		$this->model->fill($data);
		$this->model->save();
		return $this->model;
	}

	public function update(int $id, array $data)
	{
		$model = $this->model->findOrFail($id);
		$model->fill($data);
		$model->save();
		return $model;
	}

	public function delete(int $id)
	{
		$model = $this->model->findOrFail($id);
		$model->delete();
	}
}