<?php

namespace App\Livewire\User;

use App\Http\Requests\StoreUser;
use App\Livewire\Forms\UserForm;
use App\Models\User;
use App\Services\ImageService;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public UserForm $userForm;
    public null | string $tempImg = null;
    public bool $isEditing = false;
    public ?User $user = null;

    public function mount($user = null){
        if(isset($user) && $user->exists){
            $this->isEditing = true;
            $this->userForm->setUser($user, $this->isEditing);
            $this->tempImg = $user->profile_picture;
        }
    }

    public function save(){
        $this->userForm->save($this->user);
        $this->userForm->reset();
    }
    public function render()
    {
        return view('livewire.user.create');
    }
}
