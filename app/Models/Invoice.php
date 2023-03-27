<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Invoice
 * 
 * @property int $id
 * @property int $user_id
 * @property string $invoice_number
 * @property Carbon $invoiced_at
 * @property Carbon $due_at
 * @property float $amount
 * @property int $category_id
 * @property int $customer_id
 * @property string|null $customer_name
 * @property string|null $customer_email
 * @property string|null $customer_tax_number
 * @property string|null $customer_phone
 * @property string|null $customer_address
 * @property string|null $about
 * @property int $client_id
 * @property Carbon|null $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Invoice extends Model
{
	protected $table = 'invoices';

	protected $casts = [
		'user_id' => 'int',
		'amount' => 'float',
		'category_id' => 'int',
		'customer_id' => 'int',
		'client_id' => 'int'
	];

	protected $dates = [
		'invoiced_at',
		'due_at'
	];

	protected $fillable = [
		'user_id',
		'invoice_number',
		'invoiced_at',
		'due_at',
		'amount',
		'category_id',
		'customer_id',
		'customer_name',
		'customer_email',
		'customer_tax_number',
		'customer_phone',
		'customer_address',
		'about',
		'client_id'
	];
}
