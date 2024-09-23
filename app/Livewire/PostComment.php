<?php

namespace App\Livewire;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PostComment extends Component
{
    public $post_id;
    public $comment = '';
    public $postComments;

    public function mount($postId)
    {
        $this->post_id = $postId;
        $this->postComments = Comment::join('users','users.id','=','comments.user_id')->where('post_id', $this->post_id)->get(['users.name', 'comments.*']);
    }

    public function leaveComment()
    {
        $this->validate(['comment' => 'required']);
        $createComment = new Comment;
        $createComment->user_id = Auth::user()->id;
        $createComment->post_id = $this->post_id;
        $createComment->comment = $this->comment;
        $createComment->save();

        $this->postComments = Comment::join('users','users.id','=','comments.user_id')->where('post_id', $this->post_id)->get(['users.name', 'comments.*']);
    }
    public function render()
    {
        return view('livewire.post-comment', [
            'postComments' => $this->postComments
        ]);
    }
}
