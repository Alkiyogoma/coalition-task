<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
/**
 * Class Task
 * @package App\Models
 */
class Task extends Model
{
	protected $table = 'tasks';

	protected $casts = [
		'user_id' => 'int',
		'client_id' => 'int',
		'task_type_id' => 'int',
		'priority_id' => 'int',
		'status_id' => 'int',
		'next_type_id' => 'int',
		'created_by' => 'int'
	];

	protected $dates = [
		'task_date',
		'next_date'
	];

	protected $fillable = [
		'title',
		'about',
		'user_id',
		'client_id',
		'task_type_id',
		'task_date',
		'uuid',
		'priority_id',
		'status_id',
		'next_date',
		'next_type_id',
		'created_by'
	];

	public function client()
	{
		return $this->belongsTo(User::class)->withDefault(['name' => 'Not Defined']);

	}

	public function tasktype()
	{
		return $this->belongsTo(TaskType::class, 'task_type_id', 'id');
	}

	public function project()
	{
		return $this->belongsTo(TaskType::class, 'next_type_id', 'id');
	}

	public function createdBy()
	{
		return $this->belongsTo(User::class, 'created_by', 'id')->withDefault(['name' => 'Not Defined']);
	}
	public function user()
	{
		return $this->belongsTo(User::class)->withDefault(['name' => 'Not Defined']);

	}

	public function priority()
	{
		return $this->belongsTo(TaskPriority::class, 'priority_id');
	}

	public function taskstatus()
	{
		return $this->belongsTo(TaskStatus::class, 'status_id');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'task_users')
					->withPivot('id')
					->withTimestamps();
	}
	public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where(DB::raw('lower(title)'), 'like', '%'.strtolower($search).'%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
