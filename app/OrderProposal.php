<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProposal extends Model
{
    protected $fillable = [
        'order_id',
        'customer_id',
        'cleaner_id',
        'cost',
        'order_status_id',
        'sent_by',
    ];


    public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }

    public function cleaner()
    {
    	return $this->belongsTo(Cleaner::class);
    }

    public function order()
    {
    	return $this->belongsTo(Order::class);
    }

    public function status()
    {
    	return $this->belongsTo(Status::class);
    }


    public function getRejectedAttribute()
    {
        return $this->status_id == 3;
    }


}
