<?php

namespace App\Livewire\Forms;

use App\Models\User;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use Livewire\Form;

class UserForm extends Form
{
    public $name;
    public $password;
    public $password_confirmation;
    public $email;
    public $profile_picture;
    public bool $isEditing = false;

    protected function rules(){
        $generalRules = [
            'name' => 'required|',
            'password' => '',
            'password_confirmation' => '',
            'email' => 'required|email',
            'profile_picture' => ''
        ];

        if(!$this->isEditing){
            $generalRules['name'] .= '';
            $generalRules['password'] .= 'required|confirmed|min:8';
            $generalRules['password_confirmation'] .= 'required|min:8';
            $generalRules['email'] .= '|required';
            $generalRules['profile_picture'] .= '|required|mimes:jpg';
        }

        return $generalRules;
    }

    public function save(?string $imgTemp, ?User $user){
        $this->validate();

        if($this->isEditing && isset($imgTemp)){
            $this->update($imgTemp, $user);
            return;
        }
        $this->store();
    }

    private function store(){
        $imageService = new ImageService();
        $this->profile_picture = $imageService->saveInto($this->profile_picture, 'user_pictures');
        User::create($this->all());
        return redirect()->route('user.index');
    }

    private function update(string $imgName, User $user){
        $imageService = new ImageService();
        //Validate if filename exists and submit the new file
        if(!Storage::disk('user_pictures')->exists($this->profile_picture)){
            Storage::disk('user_pictures')->delete($imgName);
            $this->profile_picture = $this->profile_picture = $imageService->saveInto($this->profile_picture, 'user_pictures');
        }
        $user->update($this->except('password', 'password_confirmation'));
        return redirect()->route('user.index');
    }
    
    public function setUser(User $user, bool $editing){
        $this->name = $user->name;
        $this->email = $user->email;
        $this->profile_picture = $user->profile_picture;
        $this->isEditing = $editing;
    }
}
