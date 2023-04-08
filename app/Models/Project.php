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
		return $this->belongsTo(Task::class, 'id', 'project_id');
	}
}
