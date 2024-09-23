<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function loadHomePage()
    {
        $logged_user = Auth::user();
        $user_profile_data = UserProfile::where('user_id',$logged_user->id)->first();
        $user_image = $user_profile_data->image;
        return view('user.home-page', compact(['logged_user','user_image']));
    }

    public function loadMyPosts()
    {
        $logged_user = Auth::user();
        $user_profile_data = UserProfile::where('user_id',$logged_user->id)->first();
        $user_image = $user_profile_data->image;
        return view('user.my-posts',compact('logged_user','user_image'));
    }

    public function loadCreatePost()
    {
        $logged_user = Auth::user();
        return view('user.create-post',compact('logged_user'));
    }

    public function loadEditPost($id)
    {
        $logged_user = Auth::user();
        $post_data = Post::find($id);
        return view('user.edit-post',compact(['logged_user','post_data']));
    }

    public function loadPostPage($post_id)
    {
        $logged_user = Auth::user();
        $post_data = Post::join('users', 'users.id', '=', 'posts.user_id')->where('posts.id',$post_id)->first(['users.name','posts.*']);
        return view('user.view-post',compact(['logged_user','post_data']));
    }

    public function loadProfile()
    {
        $logged_user = Auth::user();
        return view('user.user-profile',compact('logged_user'));
    }
}
