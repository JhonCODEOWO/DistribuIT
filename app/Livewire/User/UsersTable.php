<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;
    #[Url()]
    public $search = '';
    public function delete(int $id){
        $user = User::findOrFail($id);
        $user->delete();
    }
    public function render()
    {
        return view('livewire.user.users-table', ['users' => User::where('name', 'like', '%'.$this->search.'%')->paginate(5)]);
    }
}
