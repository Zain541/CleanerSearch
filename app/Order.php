<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
	        'first_name',
	        'last_name',
	        'email',
	        'phone_number',
	        'post_code',
	        'address',
	        'alternative_address',
	        'property_type_id',
	        'property_type',
	        'contract_type_id',
	        'contract_type',
	        'no_of_bedrooms',
	        'no_of_bathrooms',
	        'customer_id',
	        'best_day',
	        'best_time',
	        'cleaning_type',
        ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }


    public function contractType()
    {
        return $this->belongsTo(ContractType::class);
    }


    public function contactMethods()
    {
        return $this->morphMany(ContactMethod::class, 'contactMethodable');
    }

    public function orderProposals()
    {
        return $this->hasMany(OrderProposal::class);
    }
}
