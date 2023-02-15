<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Employer
 *
 * @package App\Models
 */
class Employer extends Model
{
	protected $table = 'employers';

	protected $fillable = [
		'name',
		'phone',
		'address'
	];
}
