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

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    // teams that the user belongs to
    public function teams()
    {
        return $this->belongsToMany(Team::class)
            ->withTimestamps();
    }

    public function ownedTeams()
    {
        return $this->teams()
            ->where('owner_id', $this->id);
    }

    public function isOwnerOfTeam($team)
    {
        return (bool)$this->teams()
                        ->where('id', $team->id)
                        ->where('owner_id', $this->id)
                        ->count();
    }


    // Relationships for invitations
    // public function invitations()
    // {
    //     return $this->hasMany(Invitation::class, 'recipient_email', 'email');
    // }

    // relationships for chat messaging
    // public function chats()
    // {
    //     return $this->belongsToMany(Chat::class, 'participants');
    // }

    // public function messages()
    // {
    //     return $this->hasMany(Message::class);
    // }

    // public function getChatWithUser($user_id)
    // {
    //     $chat = $this->chats()
    //                 ->whereHas('participants', function($query)  use ($user_id){
    //                     $query->where('user_id', $user_id);
    //                 })
    //                 ->first();
    //     return $chat;
    // }
    

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