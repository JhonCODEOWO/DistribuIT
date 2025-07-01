<?php

namespace App\Livewire\Sales;

use App\Livewire\Forms\SaleForm;
use App\Models\User;
use Livewire\Component;

class SaleCreate extends Component
{
    public SaleForm $saleForm;

    public function save(){
        $this->saleForm->save();
        redirect()->route('sales.index');
    }

    public function render()
    {
        return view('livewire.sales.sale-create', ["users" => User::all()]);
    }
}
