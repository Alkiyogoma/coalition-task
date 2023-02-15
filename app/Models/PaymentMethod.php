<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentMethod
 * 
 * @property int $id
 * @property string|null $name
 * @property int|null $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Payment[] $payments
 *
 * @package App\Models
 */
class PaymentMethod extends Model
{
	protected $table = 'payment_methods';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'status'
	];

	public function payments()
	{
		return $this->hasMany(Payment::class, 'method_id');
	}
}