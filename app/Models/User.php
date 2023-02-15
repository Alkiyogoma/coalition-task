<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
		'sex',
		'code',
		'photo',
		'dob',
		'address',
		'department_id',
		'role_id',
		'jod',
		'salary',
		'status',
		'private_email',
		'email_verified_at',
		'password',
		'remember_token'
	];

	public function client_installments()
	{
		return $this->hasMany(ClientInstallment::class);
	}

	public function clients()
	{
		return $this->hasMany(Client::class);
	}

	public function departments()
	{
		return $this->belongsToMany(Department::class, 'user_departments')
					->withPivot('id')
					->withTimestamps();
	}

	public function installments()
	{
		return $this->hasMany(Installment::class);
	}

	public function payments()
	{
		return $this->hasMany(Payment::class);
	}

	public function posts()
	{
		return $this->hasMany(Post::class);
	}

	public function tasks()
	{
		return $this->hasMany(Task::class);
	}
}
