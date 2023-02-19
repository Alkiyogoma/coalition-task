<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Request
 * 
 * @property int $id
 * @property string|null $title
 * @property string $body
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property int $user_id
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string|null $phone
 * @property string|null $name
 * @property string|null $approve_id
 * @property int|null $method_id
 * 
 * @property User $user
 * @property Collection|Item[] $items
 *
 * @package App\Models
 */
class Request extends Model
{
	protected $table = 'requests';

	protected $casts = [
		'user_id' => 'int',
		'status' => 'int',
		'method_id' => 'int'
	];

	protected $dates = [
		'start_date',
		'end_date'
	];

	protected $fillable = [
		'title',
		'body',
		'start_date',
		'end_date',
		'user_id',
		'status',
		'phone',
		'name',
		'approve_id',
		'method_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function items()
	{
		return $this->belongsToMany(Item::class, 'request_items')
					->withPivot('id', 'amount', 'quantity')
					->withTimestamps();
	}
}
