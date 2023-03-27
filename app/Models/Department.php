<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * @package App\Models
 */
class Department extends Model
{
	protected $table = 'departments';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'name',
		'about',
		'address',
		'uuid',
		'phone',
		'email',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class)->withDefault(['name' => 'Not Defined']);

	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'user_departments')
					->withPivot('id')
					->withTimestamps();
	}
}
