<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Follower;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class MyPosts extends Component
{
    public $my_posts;
    public $my_posts_count;
    public $my_comments_count;
    public $my_followers_count;
    public function mount()
    {
        $user_id = Auth::user()->id;
        $this->my_posts = Post::where('user_id', $user_id)->get();
        $this->my_posts_count = Post::where('user_id', $user_id)->count();
        $this->my_comments_count = Comment::where('user_id',$user_id)->count();
        $this->my_followers_count = Follower::where('followed_id',$user_id)->count();
    }

    public function deletePost($id)
    {
        $post = Post::find($id);
        if ($post && $post->photo) {
            Storage::disk('public')->delete('images/' . $post->photo); // hapus gambar dari storage
        }
        $post->delete();

        session()->flash('message', 'The post was successfully deleted!');
        return $this->redirect('/my/posts', navigate: true);
    }

    public function render()
    {
        return view('livewire.my-posts',[
            'posts' => $this->my_posts,
            'post_count' => $this->my_posts_count,
            'comment_count' => $this->my_comments_count,
            'follower_count' => $this->my_followers_count,
        ]);
    }
}
