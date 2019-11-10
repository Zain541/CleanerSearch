<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $fillable = 
	[
		'read',
		'message'
	];
    public function notificationable()
    {
        return $this->morphTo();
    }
}
