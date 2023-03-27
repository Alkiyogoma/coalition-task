<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TraceClient
 * @package App\Models
 */
class TraceClient extends Model
{
	protected $table = 'trace_clients';

	protected $casts = [
		'task_type_id' => 'int',
		'trace_id' => 'int',
		'user_id' => 'float',
	];

	protected $fillable = [
		'task_type_id',
		'trace_id',
		'about',
		'user_id'
	];


    
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

     
	public function trace()
	{
		return $this->belongsTo(Tracing::class, 'trace_id', 'id');
	}

    
	public function tasktype()
	{
		return $this->belongsTo(TaskType::class, 'task_type_id', 'id');
	}
}
