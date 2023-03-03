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
 * @property string $phone
 * @property string $address
 * @property int $partner_group_id
 * @property string|null $about
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property PartnerGroup $partner_group
 * @property Collection|Client[] $clients
 *
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
}
