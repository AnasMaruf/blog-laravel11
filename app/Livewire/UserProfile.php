<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserProfile extends Component
{
    public $user_data;

    public function mount()
    {
        $this->user_data = User::join('user_profiles','user_profiles.user_id','=','users.id')
        ->where('user_profiles.user_id',Auth::user()->id)
        ->first();
    }
    public function render()
    {
        return view('livewire.user-profile');
    }
}
