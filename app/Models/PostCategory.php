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
 * @property int $id
 * @property string|null $name
 * @property string|null $about
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Post[] $posts
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
