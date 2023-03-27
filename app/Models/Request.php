<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Request
 * @package App\Models
 */
class Request extends Model
{
	protected $table = 'requests';

	protected $casts = [
		'user_id' => 'int',
		'status' => 'int',
		'method_id' => 'int'
	];

	protected $dates = [
		'start_date',
		'end_date'
	];

	protected $fillable = [
		'title',
		'body',
		'start_date',
		'end_date',
		'user_id',
		'status',
		'phone',
		'name',
		'approve_id',
		'method_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function items()
	{
		return $this->belongsToMany(Item::class, 'request_items')
					->withPivot('id', 'amount', 'quantity')
					->withTimestamps();
	}
}
