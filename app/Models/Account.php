<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Account
 * 
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property int $type_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|AccountGroup[] $account_groups
 *
 * @package App\Models
 */
class Account extends Model
{
	protected $table = 'accounts';

	protected $casts = [
		'type_id' => 'int'
	];

	protected $fillable = [
		'name',
		'code',
		'type_id'
	];

	public function account_groups()
	{
		return $this->hasMany(AccountGroup::class);
	}
}
