<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestItem
 * @package App\Models
 */
class RequestItem extends Model
{
	protected $table = 'request_items';

	protected $casts = [
		'request_id' => 'int',
		'item_id' => 'int',
		'amount' => 'float',
		'quantity' => 'int'
	];

	protected $fillable = [
		'request_id',
		'item_id',
		'amount',
		'quantity'
	];

	public function item()
	{
		return $this->belongsTo(Item::class);
	}

	public function request()
	{
		return $this->belongsTo(Request::class);
	}
}
