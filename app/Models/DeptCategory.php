<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DeptCategory
 * 
 * @property int $id
 * @property string $name
 * @property float $start_amount
 * @property float $end_amount
 * @property string $about
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class DeptCategory extends Model
{
	protected $table = 'dept_category';

	protected $casts = [
		'start_amount' => 'float',
		'end_amount' => 'float',
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'start_amount',
		'end_amount',
		'about',
		'status'
	];
}