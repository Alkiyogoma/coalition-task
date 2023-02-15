<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TaskPriority
 * 

 * @property Collection|Task[] $tasks
 *
 * @package App\Models
 */
class TaskPriority extends Model
{
	protected $table = 'task_priority';

	protected $fillable = [
		'name',
		'about'
	];

	public function tasks()
	{
		return $this->hasMany(Task::class, 'priority_id');
	}
}
