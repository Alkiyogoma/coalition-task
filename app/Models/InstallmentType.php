<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InstallmentType
 * @package App\Models
 */
class InstallmentType extends Model
{
	protected $table = 'installment_types';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'name'
	];

	public function client_installments()
	{
		return $this->hasMany(ClientInstallment::class);
	}
}
