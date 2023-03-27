<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientInstallment
 *
 * @package App\Models
 */

class ClientInstallment extends Model
{
	protected $table = 'client_installments';
	public $incrementing = true;

	protected $casts = [
		'id' => 'int',
		'client_id' => 'int',
		'user_id' => 'int'
	];


    protected $dates = [
		'start_date',
		'end_date'
    ];
    
	protected $fillable = [
		'id',
		'name',
		'start_date',
		'end_date',
		'received_amount',
		'amount',
		'user_id',
		'client_id',
		'installment_id',
		'status'
	];

	public function payments()
	{
		return $this->hasMany(Payment::class, 'installment_id', 'id');
	}

	public function installment()
	{
		return $this->belongsTo(Installment::class, 'installment_id', 'id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id')->withDefault(['name' => "Undefined"]);
	}

	public function client()
	{
		return $this->belongsTo(Clients::class, 'client_id', 'id')->withDefault(['name' => 'Not Defined']);
	}
}
