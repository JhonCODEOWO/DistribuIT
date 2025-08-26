<?php

namespace App\Livewire\Ui;

use Livewire\Component;

class Search extends Component
{
    public $searchQuery;
    public function search(){
        $this->dispatch('search-product', $this->searchQuery);
        $this->dispatch('reset-page');
    }

    public function render()
    {
        return view('livewire.ui.search');
    }
}
