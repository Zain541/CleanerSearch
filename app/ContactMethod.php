<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactMethod extends Model
{
     protected $fillable = [
        'name',
    ];

    public function contactMethodable()
    {
        return $this->morphTo();
    }
}
