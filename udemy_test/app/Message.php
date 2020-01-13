<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Message extends Authenticatable implements JWTSubject
{
    //
    protected $table = "messages";
    protected $filable = [
        'title',
        'content',
        'description',
        'created_at',
        'updated_at'
    ];
    protected $attributes = [
        // 'description' => "Nothing"
    ];
    protected $casts = [
        'created_at'  => 'datetime:d-m-Y H:i:s'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
