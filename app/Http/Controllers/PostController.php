<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function showCreateForm(){
        
        return view('create-post');
    }

    public function createPost(Request $request){
        $data=$request->validate([
            'title'=>'required',
            'body'=>'required'
        ]);   
        $data['title']=strip_tags($data['title']);
        $data['body']=strip_tags($data['body']);
        $data['user_id'] = auth()->user()->id;

        $post=Post::create($data);
        
        return redirect('/post/' . $post->id)->with('success','Post created successfully!');
    }
    //this is type hinting to make laravel automaticlly fetch the post with the same id comming from the url
    public function showSinglePost(Post $post){
        $post['body']=Str::markdown($post->body);
        return view('single-post',['post'=>$post]);
    }
    //delete a post
    public function delete(Post $post){
        // if(auth()->user()->cannot('delete',$post)){
        //     return "You cann't delete this post"; 
        // }
        
        
        $post->delete();
        return redirect("/profile/" . auth()->user()->username)->with('success','post deleted!');
    }
    public function showEditForm(Post $post){
       
        return view('edit-post',['post'=>$post]);
    }
    public function update(Request $request, Post $post){
        $data=request()->validate([
            'title'=> 'required',
            'body'=>'required'
        ]);
        $data['title']=strip_tags($data['title']);
        $data['body']=strip_tags($data['body']);
        $post->update($data);
        return back()->with('success','successfully updated !');
    }
    //searching
    public function search($term){
        $posts=Post::search($term)->get();
        $posts->load('user:id,username,avatar');
        return $posts;
    }
}
