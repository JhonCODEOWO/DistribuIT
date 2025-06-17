<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;

class UsersTable extends Component
{
    public function delete(int $id){
        $user = User::findOrFail($id);
        $user->delete();
    }
    public function render()
    {
        return view('livewire.user.users-table', ['users' => User::all()]);
    }
}
