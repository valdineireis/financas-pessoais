<?php 
declare(strict_types=1);

namespace VRSFin\Repository;

interface RepositoryInterface
{
	public function all(): array;

	public function create(array $data);

	public function update(int $id, array $data);

	public function delete(int $id);
}