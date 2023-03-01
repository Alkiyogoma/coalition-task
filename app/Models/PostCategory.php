<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PostCategory
 *
 * @package App\Models
 */
class PostCategory extends Model
{
	protected $table = 'post_category';

	protected $fillable = [
		'name',
		'about'
	];

	public function posts()
	{
		return $this->hasMany(Post::class, 'category_id');
	}
}
