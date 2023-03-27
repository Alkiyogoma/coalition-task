<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountType
 * 
 * @property int $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Account[] $accounts
 *
 * @package App\Models
 */
class AccountType extends Model
{
	protected $table = 'account_types';

	protected $fillable = [
		'name'
	];

	public function accounts()
	{
		return $this->hasMany(Account::class, 'type_id');
	}
}
