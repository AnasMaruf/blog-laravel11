<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;
    public $post_title = '';
    public $content = '';
    public $photo;

    public function save(){
        $this->validate([
            'post_title' => 'required',
            'content' => 'required',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $photo_name = md5($this->photo . microtime()).'.'.$this->photo->extension();
        $this->photo->storeAs('images', $photo_name, 'public'); //then we store image in this path

        $createPost = new Post;
        $createPost->post_title = $this->post_title;
        $createPost->content = $this->content;
        $createPost->photo = $photo_name;
        $createPost->user_id = Auth::user()->id;
        $createPost->save();
        // Post::create([
        //     'post_title' => $this->post_title,
        //     'content' => $this->content,
        //     'photo' => $photo_name,
        //     'user_id' => Auth::user()->id
        // ]);

        $this->post_title = '';
        $this->content = '';

        session()->flash('message', 'The post was successfully created!');
        $this->redirect('/my/posts',navigate:true);
    }
    public function render()
    {
        return view('livewire.create-post');
    }
}
