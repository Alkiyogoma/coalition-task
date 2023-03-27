<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Revenue
 * 
 * @property int $id
 * @property int $user_id
 * @package App\Models
 */
class Revenue extends Model
{
	protected $table = 'revenues';
 
	protected $casts = [
		'user_id' => 'int',
		'account_group_id' => 'int',
		'amount' => 'float',
		'method_id' => 'int',
		'status' => 'int',
		'added_by' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'uuid',
		'user_id',
		'account_group_id',
		'amount',
		'date',
		'method_id',
		'note',
		'reference',
		'phone',
		'name',
		'type',
		'status',
		'added_by'
	];

	public function account_group()
	{
		return $this->belongsTo(AccountGroup::class);
	}

	public function payment_method()
	{
		return $this->belongsTo(PaymentMethod::class, 'method_id');
	}

	public function addedBy()
	{
		return $this->belongsTo(User::class, 'added_by');
	}

	
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where(DB::raw('lower(name)'), 'like', '%'.strtolower($search).'%')
				->orWhere(DB::raw('lower(reference)'), 'like', '%'.strtolower($search).'%')
				->orWhere(DB::raw('lower(amount)'), 'like', '%'.strtolower($search).'%');
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
