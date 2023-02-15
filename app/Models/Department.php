<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * 
 * @property int $id
 * @property string $name
 * @property string $about
 * @property string $address
 * @property string $phone
 * @property string|null $email
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon $updated_at
 * 
 * @property User $user
 * @property Collection|User[] $users
 *
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
