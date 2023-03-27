<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Appointment
 * 
 * @property int $id
 * @property string $title
 * @property string $about
 * @property Carbon $date
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $service_id
 * @property int $client_id
 * @property int $user_id
 *
 * @package App\Models
 */
class Appointment extends Model
{
	protected $table = 'appointments';

	protected $casts = [
		'service_id' => 'int',
		'client_id' => 'int',
		'user_id' => 'int'
	];

	protected $dates = [
		'date',
		'start_date',
		'end_date'
	];

	protected $fillable = [
		'title',
		'about',
		'date',
		'start_date',
		'end_date',
		'service_id',
		'client_id',
		'user_id'
	];
}
