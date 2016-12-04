<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements JWTSubject, AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $table = 'users';

    protected $fillable = [
        'username', 'email', 'password'
    ];

    protected $hidden = [
        'password',
    ];

    public function getUserId()
    {
        return $this->id;
    }

    public function vocabs()
    {
        return $this->hasMany('App\Models\Vocab', 'user_id');
    }

    public function createUser($request)
    {
        return $this->create([
                    'email' => $request->input('email'), 
                    'username' => $request->input('username'),
                    'password' => Hash::make($request->input('password')),
               ]);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}