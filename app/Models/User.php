<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SpatialTrait;

    protected $fillable = [
        'name',
        'email',
        'password',
        'tagline',
        'about',
        'username',
        'location',
        'formatted_address',
        'available_to_hire'
    ];

    protected $spatialFields = [
        'location'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ownsTopic(Topic $topic) {
        return $this->id === $topic->user->id;
    }
    public function ownsPost(Post $post) {
        return $this->id === $post->user->id;
    }

    public function hasLikedPost(Post $post) {
		return $post->likes->where('user_id', $this->id)->count() === 1;
	}


    public function designs()
    {
        return $this->hasMany(Design::class);
    }
    

    public function getJWTIdentifier()
    {
        // Return primary key of the user - user id
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // Return a key value array, containing any custom claims to be added to the JWT.
        return [];
    }
}