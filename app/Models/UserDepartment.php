<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserDepartment
 * 
 * @property int $id
 * @property int $department_id
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property User $user
 * @property Department $department
 *
 * @package App\Models
 */
class UserDepartment extends Model
{
	protected $table = 'user_departments';

	protected $casts = [
		'department_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'department_id',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class)->withDefault(['name' => 'Not Defined']);

	}

	public function department()
	{
		return $this->belongsTo(Department::class);
	}
}
