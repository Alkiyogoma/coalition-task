<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Partner
 * 
 * @property int $id
 * @property string $name
 * @package App\Models
 */
class Partner extends Model
{
	protected $table = 'partners';

	protected $casts = [
		'partner_group_id' => 'int'
	];

	protected $fillable = [
		'name',
		'phone',
		'address',
		'email',
		'website',
		'uuid',
		'logo',
		'partner_group_id',
		'about'
	];

	public function partnerGroup()
	{
		return $this->belongsTo(PartnerGroup::class);
	}

	public function clients()
	{
		return $this->hasMany(Client::class);
	}
	
	public function codes()
	{
		return $this->hasMany(ActionCode::class);
	}

	public function groups()
	{
		return $this->hasMany(Group::class);
	}

	
	public function user()
	{
		return $this->belongsTo(User::class)->withDefault(['name' => 'Not Defined']);

	}

}
