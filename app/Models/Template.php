<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Template
 * 
 * @property int $id
 * @property int $user_id
 * @property string $alias
 * @property string $name
 * @property string $subject
 * @property string $body
 * @property Carbon|null $created_at
 * @property Carbon $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class Template extends Model
{
	use SoftDeletes;
	protected $table = 'templates';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'alias',
		'name',
		'subject',
		'body'
	];
}
