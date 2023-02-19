<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Expense
 * 
 * @property int $id
 * @property int $user_id
 * @property int $account_group_id
 * @property float $amount
 * @property Carbon $date
 * @property int|null $method_id
 * @property string $note
 * @property string|null $reference
 * @property string|null $name
 * @property string|null $phone
 * @property int|null $status
 * @property string|null $type
 * @property int $added_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property AccountGroup $account_group
 * @property PaymentMethod|null $payment_method
 * @property User $user
 *
 * @package App\Models
 */
class Expense extends Model
{
	protected $table = 'expenses';

	protected $casts = [
		'user_id' => 'int',
		'account_group_id' => 'int',
		'amount' => 'float',
		'method_id' => 'int',
		'status' => 'int',
		'added_by' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'user_id',
		'account_group_id',
		'amount',
		'date',
		'method_id',
		'note',
		'reference',
		'name',
		'phone',
		'status',
		'type',
		'added_by'
	];

	public function account_group()
	{
		return $this->belongsTo(AccountGroup::class);
	}

	public function payment_method()
	{
		return $this->belongsTo(PaymentMethod::class, 'method_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'added_by');
	}
}
