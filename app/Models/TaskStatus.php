<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TaskStatus
 * @package App\Models
 */
class TaskStatus extends Model
{
	protected $table = 'task_status';

	protected $fillable = [
		'name',
		'about'
	];

	public function tasks()
	{
		return $this->hasMany(Task::class, 'status_id');
	}
}
