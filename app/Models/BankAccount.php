<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BankAccount
 * 
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $number
 * @property string $currency_code
 * @property float $opening_balance
 * @property string|null $bank_name
 * @property string|null $branch
 * @property string|null $bank_address
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class BankAccount extends Model
{
	protected $table = 'bank_accounts';

	protected $casts = [
		'user_id' => 'int',
		'opening_balance' => 'float',
		'status' => 'bool'
	];

	protected $fillable = [
		'user_id',
		'name',
		'number',
		'currency_code',
		'opening_balance',
		'bank_name',
		'branch',
		'bank_address',
		'status'
	];
}
