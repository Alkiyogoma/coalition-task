<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/*
 * @package App\Models
 */
class DeptReward extends Model
{
	protected $table = 'dept_rewards';

	protected $casts = [
		'start_amount' => 'float',
		'end_amount' => 'float',
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'start_amount',
		'end_amount',
		'about',
		'status'
	];
}
