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
		'uuid',
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
