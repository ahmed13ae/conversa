<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Post extends Model
{   
    use Searchable;
    use HasFactory;
    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];  
    //name is important in the search function
    public function toSearchableArray()
{
    $array = [
        'title' => $this->title,
        'body' => $this->body,
    ];

    

    return $array;
}
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
