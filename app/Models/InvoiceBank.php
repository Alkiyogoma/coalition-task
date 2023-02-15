<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InvoiceBank
 * 
 * @property int $id
 * @property int $user_id
 * @property int $invoice_id
 * @property int $bank_account_id
 * @property Carbon|null $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class InvoiceBank extends Model
{
	protected $table = 'invoice_banks';

	protected $casts = [
		'user_id' => 'int',
		'invoice_id' => 'int',
		'bank_account_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'invoice_id',
		'bank_account_id'
	];
}
