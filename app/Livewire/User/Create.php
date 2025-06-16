<?php

namespace App\Livewire\User;

use App\Http\Requests\StoreUser;
use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    public UserForm $user;

    public function save(){
        $this->user->save();
        $this->user->reset();
    }
    public function render()
    {
        return view('livewire.user.create');
    }
}
