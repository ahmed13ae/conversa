<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Follow extends Model
{
    use HasFactory;

    public function follower(){
        return $this->belongsTo(User::class,'follower_id');
    }

    public function followed(){
        return $this->belongsTo(User::class,'followed_id');
    }

}
