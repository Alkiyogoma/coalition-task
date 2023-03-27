<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Group
 * 
 * @property int $id
 * @property string $name
 * @property string $about
 * @property int $user_id
 * @property int $partner_id
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $uuid
 * 
 * @property User $user
 * @property Partner $partner
 *
 * @package App\Models
 */
class Group extends Model
{
	protected $table = 'groups';

	protected $casts = [
		'user_id' => 'int',
		'partner_id' => 'int',
		'status' => 'int'
	];

	protected $dates = [
		'start_date',
		'end_date'
	];

	protected $fillable = [
		'name',
		'about',
		'user_id',
		'partner_id',
		'start_date',
		'end_date',
		'status',
		'uuid'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function partner()
	{
		return $this->belongsTo(Partner::class);
	}
}
