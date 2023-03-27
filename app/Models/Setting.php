<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * 
 * @package App\Models
 */
class Setting extends Model
{
	protected $table = 'setting';
	public $timestamps = false;

	protected $casts = [
		'sms_enabled' => 'int'
	];

	protected $hidden = [
		'secret_key'
	];

	protected $fillable = [
		'name',
		'phone',
		'address',
		'email',
		'short_name',
		'photo',
		'director_name',
		'director_phone',
		'director_email',
		'director_sex',
		'api_key',
		'secret_key',
		'website',
		'motto',
		'sms_enabled',
		'signature',
		'source',
		'region',
		'about'
	];
}
