<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

 

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	   /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
	
	protected $fillable = [
		'name',
		'email',
		'phone',
		'sex',
		'uuid',
		'code',
		'photo',
		'dob',
		'address',
		'department_id',
		'role_id',
		'jod',
		'salary',
		'status',
		'email_verified_at',
		'client_status_id',
		'password',
		'remember_token'
	];



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
				->orWhere(DB::raw('lower(email)'), 'like', '%'.strtolower($search).'%');
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
