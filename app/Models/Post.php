<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 * 
 * @property int $id
 * @property string|null $title
 * @property string|null $content
 * @property string|null $attach
 * @property int|null $status
 * @property int|null $category_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int|null $views
 * @property int $user_id
 * 
 * @property User $user
 * @property PostCategory|null $post_category
 * @property Collection|PostComment[] $post_comments
 * @property Collection|PostView[] $post_views
 *
 * @package App\Models
 */
class Post extends Model
{
	protected $table = 'posts';

	protected $casts = [
		'status' => 'int',
		'category_id' => 'int',
		'views' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'title',
		'content',
		'attach',
		'status',
		'category_id',
		'views',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class)->withDefault(['name' => 'Not Defined']);

	}

	public function post_category()
	{
		return $this->belongsTo(PostCategory::class, 'category_id');
	}

	public function post_comments()
	{
		return $this->hasMany(PostComment::class);
	}

	public function post_views()
	{
		return $this->hasMany(PostView::class);
	}
}
