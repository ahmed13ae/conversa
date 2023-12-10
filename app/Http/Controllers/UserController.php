<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Stub\ReturnSelf;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|min:3|max:30|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'

        ]);
        $data['password'] = bcrypt($data['password']);
        $user=User::create($data);
        auth()->login($user);
        return redirect('/')->with('success','Thanks for joinning Conversa!');
    }
    //    login utility
    public function login(Request $request)
    {
        $data = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);
        if (auth()->attempt(['username' => $data['loginusername'], 'password' => $data['loginpassword']])) {
            $request->session()->regenerate();
            return redirect('/')->with('success','You are logged in successfully');
        } else {
            return redirect('/')->with('fail','Invalid Username or Password');

        }
    }
    // showing the correct home page
    public function showCorrectHome()
    {
        if (auth()->check()) {
            return view('home-logged');
        } else {
            return view('home');
        }
    }
    // handling logging out
    public function logout()
    {
       auth()->logout();
       return redirect('/')->with('success','You logged Out successsfully');
    }
    //---------------profile controllers---------------------

    //show profile
    public function profile(User $user){
        return view('profile-posts',['user'=>$user,'posts'=>$user->posts()->latest()->get(),'postsCount'=>$user->posts()->count()]);
    }
    public function showAvatarForm(){
        return view('avatar-form');
    }
    public function changeAvatar(Request $request){
        $request->file('avatar')->store('public/avatars');
        Return 'hey';
    }
}
