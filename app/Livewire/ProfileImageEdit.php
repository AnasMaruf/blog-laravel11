<?php

namespace App\Livewire;

use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileImageEdit extends Component
{
    use WithFileUploads;
    public $existingImage;
    public $image;



    public function uploadImage()
    {
        $this->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $photo_name = md5($this->image . microtime()).'.'.$this->image->extension();
        $this->image->storeAs('images', $photo_name, 'public');

        $add_photo = UserProfile::where('user_id',Auth::user()->id)->update([
            'image' => $photo_name
        ]);
        // this ensure image is updated
        return $this->redirect('/profile',navigate: true);

    }
    public function render()
    {
        return view('livewire.profile-image-edit');
    }
}
