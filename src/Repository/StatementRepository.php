<?php 
declare(strict_types=1);

namespace VRSFin\Repository;

use VRSFin\Models\BillPay;
use VRSFin\Models\BillReceives;

class StatementRepository implements StatementRepositoryInterface
{
	public function all(string $dateStart, string $dateEnd, int $userId): array
	{
		$billPays = BillPay::query()
						->selectRaw('bill_pays.*, category_costs.name as category_name')
						->leftJoin('category_costs', 'category_costs.id', '=', 'bill_pays.category_cost_id')
						->whereBetween('date_launch', [$dateStart, $dateEnd])
						->where('bill_pays.user_id', $userId)
						->get();

		$billReceives = BillReceives::query()
						->whereBetween('date_launch', [$dateStart, $dateEnd])
						->where('user_id', $userId)
						->get();
	}
}