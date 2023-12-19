<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
   public function createFollow(User $user){
    //you cant follow yourself
    if($user->id === auth()->user()->id){
        return back()->with("fail","You can't follow Yourself!");
    }

    //you can't follow someone u already follow
    $followCheck=Follow::where([['follower_id','=',auth()->user()->id],['followed_id','=',$user->id]])->count();
    if($followCheck){
        return back()->with('fail','you already following '. $user->username .'!');
    }
    $follow=new Follow;
    $follow->follower_id=auth()->user()->id;
    $follow->followed_id=$user->id;
    $follow->save();
    return back()->with('success','You followed '. $user->username .' !');

   }

   public function removeFollow(User $user){
    Follow::where([['follower_id','=',auth()->user()->id],['followed_id','=',$user->id]])->delete();
    return back()->with('success','You unfollowed '. $user->username .'.');
   }
}
