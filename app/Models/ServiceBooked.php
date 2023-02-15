<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ServiceBooked
 * 
 * @property int $id
 * @property int $appointment_id
 * @property int $service_id
 * @property float $amout
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class ServiceBooked extends Model
{
	protected $table = 'service_booked';

	protected $casts = [
		'appointment_id' => 'int',
		'service_id' => 'int',
		'amout' => 'float',
		'status' => 'int'
	];

	protected $fillable = [
		'appointment_id',
		'service_id',
		'amout',
		'status'
	];
}
