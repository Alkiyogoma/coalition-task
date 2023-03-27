<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 */
class ActionCode extends Model
{
	protected $table = 'action_codes';

	protected $fillable = [
		'code',
        'partner_id',
        'name',
		'about'
	];

    
	public function partner()
	{
		return $this->belongsTo(Partner::class);
	}
}
