<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Post;

use App\Models\Follow;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];
    protected function avatar(): Attribute{
        return Attribute::make(get: function ($value) {
            return $value ? '/storage/avatars/'.$value : '/fallback-avatar.jpg';
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function feedPosts(){
        //this function works when u have an intermidiate table 
        //hasmanythrough(required model,intermediate model,forgiegn key to connect current model with int model,foriegn key with required model,primary key(local key),local key for int model (not mandadtory to be the pk but the key we want to use in this case it's the followed_id))
        return $this->hasManyThrough(Post::class ,Follow::class ,'follower_id' , 'user_id', 'id', 'followed_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function followers(){
        return $this->hasMany(Follow::class,'followed_id');
    }
    
    public function followeds(){
        return $this->hasMany(Follow::class,'follower_id');
    }

}
