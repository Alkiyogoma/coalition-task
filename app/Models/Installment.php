<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;



class Installment extends Model
{
	protected $table = 'installments';
	public $incrementing = true;

	protected $casts = [
		'id' => 'int',
		'user_id' => 'int'
	];


	protected $fillable = [
		'id',
		'name',
		'code',
		'user_id',
		'status'
	];

	public function payments()
	{
		return $this->hasMany(Payment::class, 'installment_id', 'id');
	}

	public function clients()
	{
		return $this->hasMany(ClientInstallment::class, 'installment_id', 'id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id')->withDefault(['name' => "Undefined"]);
	}

}
