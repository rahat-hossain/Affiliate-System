<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password', 'type', 'refrrel_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function referrals()
    {
        return $this->hasMany(Marketing::class, 'refered_user_id');
    }


    protected $appends = ['referral_link'];


    public function getReferralLinkAttribute()
    {
        return $this->referral_link = route('register', ['ref' => $this->refrrel_token]);
    }

    function relationToProfile()
    {
        return $this->hasOne('App\Profile', 'user_id', 'id');
    }
}
