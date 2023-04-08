<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TaskType
 * @package App\Models
 */
class TaskType extends Model
{
	protected $table = 'task_type';

	protected $fillable = [
		'name',
		'code',
		'group_id',
		'about'
	];

	public function tasks()
	{
		return $this->hasMany(Task::class);
	}
}
