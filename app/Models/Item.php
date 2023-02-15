<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 * 
 * @property int $id
 * @property string|null $name
 * @property int|null $unit_id
 * @property float|null $unit_price
 * @property int|null $category_id
 * @property int|null $user_id
 * @property int|null $quantity
 * @property string|null $about
 * @property Carbon $updated_at
 * @property Carbon|null $created_at
 *
 * @package App\Models
 */
class Item extends Model
{
	protected $table = 'items';

	protected $casts = [
		'unit_id' => 'int',
		'unit_price' => 'float',
		'category_id' => 'int',
		'user_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'name',
		'unit_id',
		'unit_price',
		'category_id',
		'user_id',
		'quantity',
		'about'
	];
}
