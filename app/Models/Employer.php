<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Employer
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
class Employer extends Model
{
	protected $table = 'employers';

	protected $fillable = [
		'name',
		'phone',
		'address'
	];

	public function clients()
	{
		return $this->hasMany(Client::class);
	}
}
