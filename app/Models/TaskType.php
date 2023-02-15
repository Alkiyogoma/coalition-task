<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TaskType
 * 
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $about
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Task[] $tasks
 *
 * @package App\Models
 */
class TaskType extends Model
{
	protected $table = 'task_type';

	protected $fillable = [
		'name',
		'code',
		'about'
	];

	public function tasks()
	{
		return $this->hasMany(Task::class);
	}
}
