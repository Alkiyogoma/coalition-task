<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
 * @package App\Models
 */
class Client extends Model
{
	protected $table = 'clients';

	protected $casts = [
		'amount' => 'float',
		'status' => 'int',
		'user_id' => 'int',
		'partner_id' => 'int',
		'branch_id' => 'int'
	];

	protected $fillable = [
		'name',
		'phone',
		'address',
		'employer',
		'employer_id',
		'amount',
		'status',
		'account',
		'deposit_account',
		'collector',
		'user_id',
		'partner_id',
		'branch_id',
		'branch',
		'placement',
		'code'
	];

	public function user()
	{
		return $this->belongsTo(User::class)->withDefault(['name' => 'Not Defined']);

	}

	public function partner()
	{
		return $this->belongsTo(Partner::class);
	}

	public function installments()
	{
		return $this->belongsToMany(Installment::class, 'client_installments')
					->withPivot('id', 'name', 'start_date', 'end_date', 'received_amount', 'amount', 'status', 'user_id', 'installment_type_id')
					->withTimestamps();
	}

	public function payments()
	{
		return $this->hasMany(Payment::class);
	}

	public function tasks()
	{
		return $this->hasMany(Task::class);
	}
}
