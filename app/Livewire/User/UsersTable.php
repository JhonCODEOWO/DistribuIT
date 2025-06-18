<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;
    public function delete(int $id){
        $user = User::findOrFail($id);
        $user->delete();
    }
    public function render()
    {
        return view('livewire.user.users-table', ['users' => User::paginate(5)]);
    }
}
