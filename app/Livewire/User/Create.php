<?php

namespace App\Livewire\User;

use App\Http\Requests\StoreUser;
use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    public UserForm $userForm;
    public int $id = -1;
    public null | User $user =  null;

    public function mount(User $user){
        $this->userForm->setUser($user);
    }

    public function save(){
        if(isset($this->user)) {
            $this->userForm->update($this->user);
            return;
        }
        $this->userForm->store();
        $this->userForm->reset();
    }
    public function render()
    {
        return view('livewire.user.create');
    }
}
