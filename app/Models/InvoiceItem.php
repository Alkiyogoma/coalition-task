<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InvoiceItem
 * 
 * @property int $id
 * @property int $user_id
 * @property int $invoice_id
 * @property int|null $item_id
 * @property string $name
 * @property float $quantity
 * @property float $price
 * @property float $total
 * @property float $tax
 * @property Carbon|null $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class InvoiceItem extends Model
{
	protected $table = 'invoice_items';

	protected $casts = [
		'user_id' => 'int',
		'invoice_id' => 'int',
		'item_id' => 'int',
		'quantity' => 'float',
		'price' => 'float',
		'total' => 'float',
		'tax' => 'float'
	];

	protected $fillable = [
		'user_id',
		'invoice_id',
		'item_id',
		'name',
		'quantity',
		'price',
		'total',
		'tax'
	];
}
