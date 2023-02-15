<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ServiceProvided
 * 
 * @property int $id
 * @property int $appointment_id
 * @property int $service_id
 * @property int $amount
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class ServiceProvided extends Model
{
	protected $table = 'service_provided';

	protected $casts = [
		'appointment_id' => 'int',
		'service_id' => 'int',
		'amount' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'appointment_id',
		'service_id',
		'amount',
		'status'
	];
}
