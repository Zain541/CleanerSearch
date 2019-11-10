<?php

namespace App;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable implements JWTSubject
{
     use Notifiable;


    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'postal_code',
        'email',
        'password',
        'address',
        'avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNameAttribute()
    {
        $name = $this->first_name . " " . $this->last_name;
        return $name;
    }

    public function orders()
    {
      return $this->hasMany('App\Order');
    }

    public function orderProposals()
    {
        return $this->hasMany(OrderProposal::class);
    }

    public function contractType()
    {
        return $this->belongsTo(ContractType::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
