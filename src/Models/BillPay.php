<?php 

namespace VRSFin\Models;

use Illuminate\Database\Eloquent\Model;

class BillPay extends Model
{
	// Mass Assignment
	protected $fillable = [
		'date_launch',
		'name',
		'value',
		'user_id',
		'category_cost_id'
	];
}