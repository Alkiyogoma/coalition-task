<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tracing
 * @package App\Models
 */
class Tracing extends Model
{
	protected $table = 'trace_clients';

	protected $casts = [
		'task_type_id' => 'int',
		'staff_id' => 'int',
		'client_id' => 'int',
		'user_id' => 'float',
	];

	protected $fillable = [
		'task_type_id',
		'user_id',
		'staff_id',
		'client_id',
		'phone',
		'about',
		'date',
		'status'
	];

   
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function client()
	{
		return $this->belongsTo(Client::class, 'client_id', 'id');
	}

	public function staff()
	{
		return $this->belongsTo(User::class, 'staff_id', 'id');
	}

	public function traces()
	{
		return $this->hasMany(TraceClient::class, 'trace_id', 'id');
	}

	public function tasktype()
	{
		return $this->belongsTo(TaskType::class, 'task_type_id', 'id');
	}
}
