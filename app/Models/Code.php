<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Code
 * @package App\Models
 */

class Code extends Model
{
	protected $table = 'codes';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'code',
		'about',
		'partner_id',
		'status'
	];

	
	public function partner()
	{
		return $this->belongsTo(Partner::class);
	}
}
