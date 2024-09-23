<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPost extends Component
{
    use WithFileUploads;
    public Post $post;
    public $post_title;
    public $content;
    public $photo;
    public function mount($post_data)
    {
        $this->post = $post_data;
        $this->post_title = $post_data->post_title;
        $this->content = $post_data->content;
    }

    public function update(){
        // update data to database
        $this->validate([
            'post_title' => 'required',
            'content' => 'required',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        if ($this->photo == null) {
            Post::where('id',$this->post->id)->update([
                'post_title' => $this->post_title,
                'content' => $this->content,
            ]);
        }else{
            // Hapus gambar lama jika ada
            if ($this->post->photo) {
                Storage::disk('public')->delete('images/' . $this->post->photo);
            }

            $photo_name = md5($this->photo . microtime()) . '.' . $this->photo->extension();
            $this->photo->storeAs('images', $photo_name, 'public');

            // Update dengan gambar baru
            $this->post->update([
            'post_title' => $this->post_title,
            'content' => $this->content,
            'photo' => $photo_name,
            ]);

            
        }
        session()->flash('message', 'The post was successfully updated!');
        return $this->redirect('/my/posts',navigate: true);
    }
    public function render()
    {
        return view('livewire.edit-post');
    }
}
