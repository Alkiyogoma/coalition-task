<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * 
 * @property int $id
 * @property string $type
 * @property string $phone
 * @property string|null $client
 * @property int|null $user_id
 * @property int|null $client_id
 * @property string $about
 * @property Carbon|null $notify_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notifications';

	protected $casts = [
		'user_id' => 'int',
		'client_id' => 'int'
	];

	protected $dates = [
		'notify_at'
	];

	protected $fillable = [
		'type',
		'phone',
		'client',
		'user_id',
		'client_id',
		'about',
		'notify_at'
	];
}
