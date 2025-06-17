<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public $name;
    public $password;
    public $password_confirmation;
    public $email;
    public bool $isEditing = false;

    protected function rules(){
        $generalRules = [
            'name' => '',
            'password' => '',
            'password_confirmation' => '',
            'email' => 'email'
        ];

        if(!$this->isEditing){
            $generalRules['name'] .= '|required';
            $generalRules['password'] .= '|required|confirmed|min:8';
            $generalRules['password_confirmation'] .= '|required|min:8';
            $generalRules['email'] .= '|required';
        }

        return $generalRules;
    }

    public function store(){
        $errors = $this->validate();
        User::create($this->all());
        return redirect()->route('user.index');
    }

    public function update(User $user){
        $errors = $this->validate();
        $user->update($this->except('password', 'password_confirmation'));
        return redirect()->route('user.index');
    }
    
    public function setUser(User $user){
        $this->name = $user->name;
        $this->email = $user->email;
        $this->isEditing = true;
    }
}
