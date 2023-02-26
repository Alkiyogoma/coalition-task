<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * 
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string|null $email
 * @property string|null $short_name
 * @property string|null $photo
 * @property string $director_name
 * @property string $director_phone
 * @property string $director_email
 * @property string $director_sex
 * @property Carbon $created_at
 * @property string|null $api_key
 * @property string|null $secret_key
 * @property string|null $website
 * @property string|null $motto
 * @property int|null $sms_enabled
 * @property string|null $signature
 * @property string|null $source
 * @property string|null $region
 * @property string $about
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
