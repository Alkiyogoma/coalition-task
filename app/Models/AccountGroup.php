<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountGroup
 * 
 * @property int $id
 * @property int $account_id
 * @property string $name
 * @property string|null $about
 * @property string|null $code
 * @property int|null $status
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Account $account
 * @property Collection|Expense[] $expenses
 * @property Collection|Revenue[] $revenues
 *
 * @package App\Models
 */
class AccountGroup extends Model
{
	protected $table = 'account_groups';

	protected $casts = [
		'account_id' => 'int',
		'status' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'account_id',
		'name',
		'about',
		'code',
		'status',
		'user_id'
	];

	public function account()
	{
		return $this->belongsTo(Account::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function expenses()
	{
		return $this->hasMany(Expense::class);
	}

	public function revenues()
	{
		return $this->hasMany(Revenue::class);
	}
}
