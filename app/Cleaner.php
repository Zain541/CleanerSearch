<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cleaner extends Authenticatable implements JWTSubject
{
    use Notifiable;
	protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'company_name',
        'email',
        'username',
        'password',
        'speciality_other',
        'tracking',
        'availability',
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
      return $this->hasMany(Order::class);
    }


    public function orderProposals()
    {
      return $this->hasMany(OrderProposal::class);
    }


    public function specialities()
    {
      return $this->belongsToMany(Speciality::class);
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
