<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Collection
 * 
 * @property int $id
 * @property int $user_id
 * @property int $partner_id
 * @property int|null $clients
 * @property Carbon|null $date
 * @property int $status
 * @property float $amount
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $uuid
 * 
 * @property User $user
 * @property Partner $partner
 *
 * @package App\Models
 */
class Collection extends Model
{
	protected $table = 'collections';

	protected $casts = [
		'user_id' => 'int',
		'partner_id' => 'int',
		'clients' => 'int',
		'status' => 'int',
		'amount' => 'float'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'user_id',
		'partner_id',
		'clients',
		'date',
		'status',
		'amount',
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
