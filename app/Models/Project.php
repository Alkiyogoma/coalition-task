<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 */
class Project extends Model
{
	protected $table = 'projects';

	protected $fillable = [
		'code',
        'id',
        'name',
		'about'
	];

    
	public function tasks()
	{
		return $this->hasMany(Task::class, 'project_id', 'id');
	}
}
