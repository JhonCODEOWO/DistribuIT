<?php

namespace App\Livewire\Sales;

use Livewire\Component;

class SaleCreate extends Component
{
    public $lng;
    public $lat;

    public function save(){
        return 'Done';
    }

    public function render()
    {
        return view('livewire.sales.sale-create');
    }
}
