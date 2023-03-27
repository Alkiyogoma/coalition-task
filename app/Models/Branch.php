<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Branch
 * 
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $address
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Branch extends Model
{
	protected $table = 'branches';

	protected $fillable = [
		'name',
		'phone',
		'email',
		'address'
	];

	public function clients()
	{
		return $this->hasMany(Client::class);
	}
}
