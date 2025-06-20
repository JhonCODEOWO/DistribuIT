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
            'profile_picture' => (($this->isEditing)? 'nullable': '').'|mimes:jpg'
        ];

        if(!$this->isEditing){
            $generalRules['name'] .= '';
            $generalRules['password'] .= 'required|confirmed|min:8';
            $generalRules['password_confirmation'] .= 'required|min:8';
            $generalRules['email'] .= '|required';
            $generalRules['profile_picture'] .= '|required';
        }

        return $generalRules;
    }

    public function save(?User $user){
        $this->validate();

        if($this->isEditing){
            $this->update($user);
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

    private function update(User $user){
        $imageService = new ImageService();
        $lastImage = $user->profile_picture;
        //Validate if filename exists and submit the new file
        if(isset($this->profile_picture)){
            if(Storage::disk('user_pictures')->exists($user->profile_picture)) Storage::disk('user_pictures')->delete($user->profile_picture);
            $this->profile_picture = $imageService->saveInto($this->profile_picture, 'user_pictures');
        }else{
            $this->profile_picture = $lastImage;
        }
        $user->update($this->except('password', 'password_confirmation'));
        return redirect()->route('user.index');
    }
    
    public function setUser(User $user, bool $editing){
        $this->name = $user->name;
        $this->email = $user->email;
        $this->isEditing = $editing;
    }
}
