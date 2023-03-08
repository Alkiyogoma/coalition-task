<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
/**
 * Class Client
 * @package App\Models
 */
class Client extends Model
{
	protected $table = 'clients';

	protected $casts = [
		'amount' => 'float',
		'status' => 'int',
		'user_id' => 'int',
		'partner_id' => 'int',
		'branch_id' => 'int',
		'code_id' => 'int',
		'group_id' => 'int',
		'ptpamount' => 'float'
	];

	protected $dates = [
		'ptpdate'
	];

	protected $fillable = [
		'name',
		'phone',
		'address',
		'sex',
		'uuid',
		'employer',
		'employer_id',
		'amount',
		'status',
		'account',
		'deposit_account',
		'collector',
		'user_id',
		'partner_id',
		'branch_id',
		'branch',
		'placement',
		'code',
		'code_id',
		'nextkin',
		'kinphone',
		'group_id',
		'ptpdate',
		'ptpamount'
	];

	public function user()
	{
		return $this->belongsTo(User::class)->withDefault(['name' => 'Not Defined']);

	}

	public function partner()
	{
		return $this->belongsTo(Partner::class);
	}

	public function group()
	{
		return $this->belongsTo(Group::class);
	}

	public function codename()
	{
		return $this->belongsTo(ActionCode::class, 'code_id', 'id');
	}

	public function messages()
	{
		return $this->hasMany(Message::class);
	}

	public function employers()
	{
		return $this->belongsTo(Employer::class, 'employer_id', 'id');
	}
	public function branchs()
	{
		return $this->belongsTo(Branch::class, 'branch_id', 'id');
	}

	public function installments()
	{
		return $this->belongsToMany(Installment::class, 'client_installments')
					->withPivot('id', 'name', 'start_date', 'end_date', 'received_amount', 'amount', 'status', 'user_id', 'installment_type_id')
					->withTimestamps();
	}

	public function payments()
	{
		return $this->hasMany(Payment::class);
	}

	public function tasks()
	{
		return $this->hasMany(Task::class);
	}

	public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where(DB::raw('lower(name)'), 'like', '%'.strtolower($search).'%')
				->orWhere(DB::raw('lower(phone)'), 'like', '%'.strtolower($search).'%')
				->orWhere(DB::raw('lower(branch)'), 'like', '%'.strtolower($search).'%');
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
