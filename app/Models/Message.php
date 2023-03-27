<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 * @package App\Models
 */

class Message extends Model
{
	protected $table = 'messages';

	protected $casts = [
		'user_id' => 'int',
		'status' => 'int',
		'client_id' => 'int',
		'sms_count' => 'int',
		'sms_type' => 'int'
	];

	protected $fillable = [
		'title',
		'body',
		'phone',
		'user_id',
		'status',
		'return_code',
		'client_id',
		'sms_count',
		'sender_id',
		'sms_id',
		'sms_type'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function client()
	{
		return $this->belongsTo(Client::class);
	}
}
