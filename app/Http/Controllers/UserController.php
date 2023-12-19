<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;






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
        $user = User::create($data);
        auth()->login($user);
        return redirect('/')->with('success', 'Thanks for joinning Conversa!');
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
            return redirect('/')->with('success', 'You are logged in successfully');
        } else {
            return redirect('/')->with('fail', 'Invalid Username or Password');

        }
    }
    // showing the correct home page
    public function showCorrectHome()
    {
        if (auth()->check()) {
            $feedPosts=auth()->user()->feedPosts()->latest()->paginate(2);
                return view('home-feed', ['posts'=> $feedPosts]);
        } else {
            return view('home');
        }
    }
    // handling logging out
    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'You logged Out successsfully');
    }
    //---------------profile controllers---------------------

    //show profile
    private function profileData($user){
        $followCheck = 0;
        if (auth()->check()) {
            $followCheck = Follow::where([['follower_id', '=', auth()->user()->id], ['followed_id', '=', $user->id]])->count();
        }
        View::share('profileData', ['followCheck' => $followCheck, 'user' => $user, 'postsCount' => $user->posts()->count(),
    'followersCount'=>$user->followers()->count(),'followedsCount'=>$user->followeds()->count()]);
    }
    public function profilePosts(User $user)
    {
       $this->profileData($user);

        return view('profile-posts', [  'posts' => $user->posts()->latest()->get()]);
    }
    //show profile followers
    public function profileFollowers(User $user)
    {
        $this->profileData($user);

        return view('profile-followers', [ 'followers' => $user->followers()->latest()->get()]);
    }

    //show profile followings

    public function profileFollowing(User $user)
    {
        $this->profileData($user);

        return view('profile-following', [  'followeds' => $user->followeds()->latest()->get()]);
    }

    //avatar related
    public function showAvatarForm()
    {
        return view('avatar-form');
    }
    public function changeAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:6000',
        ]);

        $user = auth()->user();
        $imageManager = ImageManager::withDriver(Driver::class);

        // Generate a unique filename for the avatar
        $fileName = $user->id . '-' . uniqid() . '.jpg';

        $image = $imageManager->read($request->file('avatar'));
        $image->resize(120, 120);

        $imgData = $image->toJpeg();
        Storage::put('public/avatars/' . $fileName, $imgData);
        $oldAvatar = $user->avatar;

        $user->avatar = $fileName;
        $user->save();

        if ($oldAvatar != $user->avatar || $oldAvatar != "/fallback-avatar.jpg") {
            Storage::delete(str_replace("/storage/", "public/", $oldAvatar));
        }
        return back()->with("success", "avatar changed!");
    }
}