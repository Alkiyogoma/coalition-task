<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class AccountGroup
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

	public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where(DB::raw('lower(name)'), 'like', '%'.strtolower($search).'%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
