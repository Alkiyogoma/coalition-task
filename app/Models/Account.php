<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Account
 * 
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property int $type_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string|null $uuid
 * 
 * @property AccountType $account_type
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
		'type_id',
		'uuid'
	];

	public function account_type()
	{
		return $this->belongsTo(AccountType::class, 'type_id');
	}

	public function account_groups()
	{
		return $this->hasMany(AccountGroup::class);
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
