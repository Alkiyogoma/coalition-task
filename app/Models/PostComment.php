<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PostComment
 * 
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string|null $content
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Post $post
 *
 * @package App\Models
 */
class PostComment extends Model
{
	protected $table = 'post_comments';

	protected $casts = [
		'post_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'post_id',
		'user_id',
		'content'
	];

	public function post()
	{
		return $this->belongsTo(Post::class);
	}
}
