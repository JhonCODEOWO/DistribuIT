<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    #[Validate('required')]
    public $name;
    #[Validate('required|confirmed|min:8')]
    public $password;
    #[Validate('required|min:8')]
    public $password_confirmation;
    #[Validate('required')]
    public $email;

    public function save(){
        
        $errors = $this->validate();
        User::create($this->all());
        return redirect()->route('index');
    }
}
