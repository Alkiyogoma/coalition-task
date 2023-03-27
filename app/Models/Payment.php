<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * @package App\Models
 */
class Payment extends Model
{
	protected $table = 'payments';

	protected $casts = [
		'client_id' => 'int',
		'installment_id' => 'int',
		'amount' => 'float',
		'method_id' => 'int',
		'status' => 'int',
		'user_id' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'client_id',
		'uuid',
		'installment_id',
		'amount',
		'date',
		'method_id',
		'about',
		'reference',
		'status',
		'user_id'
	];

	public function client()
	{
		return $this->belongsTo(Client::class)->withDefault(['name' => 'Not Defined']);

	}

	public function installment()
	{
		return $this->belongsTo(Installment::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class)->withDefault(['name' => 'Not Defined']);

	}

	public function payment_method()
	{
		return $this->belongsTo(PaymentMethod::class, 'method_id');
	}
}
