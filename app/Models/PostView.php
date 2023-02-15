<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PostView
 * 
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property Carbon|null $ondate
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Post $post
 *
 * @package App\Models
 */
class PostView extends Model
{
	protected $table = 'post_views';

	protected $casts = [
		'post_id' => 'int',
		'user_id' => 'int'
	];

	protected $dates = [
		'ondate'
	];

	protected $fillable = [
		'post_id',
		'user_id',
		'ondate'
	];

	public function post()
	{
		return $this->belongsTo(Post::class);
	}
}
