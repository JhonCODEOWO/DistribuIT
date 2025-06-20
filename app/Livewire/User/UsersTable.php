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
    public $searchQuery = '';
    public function delete(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function search(){
        if ($this->searchQuery != '') {
            $this->resetPage();
            return User::where('name', 'like', '%' . $this->searchQuery . '%')->paginate(5);
        }

        return User::paginate(5);
    }

    public function resetQuery(){
        $this->searchQuery = '';
    }

    public function render()
    {
        return view('livewire.user.users-table', [
            'users' => $this->search()
        ]);
    }
}
