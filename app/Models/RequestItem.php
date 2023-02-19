<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestItem
 * 
 * @property int $id
 * @property int $request_id
 * @property int $item_id
 * @property float $amount
 * @property int|null $quantity
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Item $item
 * @property Request $request
 *
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
