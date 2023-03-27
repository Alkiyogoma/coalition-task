<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PartnerGroup
 * 
 * @property int $id
 * @property string $name
 * @property string|null $about
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Partner[] $partners
 *
 * @package App\Models
 */
class PartnerGroup extends Model
{
	protected $table = 'partner_groups';

	protected $fillable = [
		'name',
		'about'
	];

	public function partners()
	{
		return $this->hasMany(Partner::class);
	}
}
