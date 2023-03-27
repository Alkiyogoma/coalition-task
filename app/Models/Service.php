<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 * 
 * @property int $id
 * @property string $name
 * @property string $about
 * @property string $attach
 * @property int $status
 * @property float $price
 * @property int $price_category_id
 * @property int $user_id
 * @property int $discount
 * @property Carbon $created_at
 * @property int $category_id
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Service extends Model
{
	protected $table = 'services';

	protected $casts = [
		'status' => 'int',
		'price' => 'float',
		'price_category_id' => 'int',
		'user_id' => 'int',
		'discount' => 'int',
		'category_id' => 'int'
	];

	protected $fillable = [
		'name',
		'about',
		'attach',
		'status',
		'price',
		'price_category_id',
		'user_id',
		'discount',
		'category_id'
	];
}
