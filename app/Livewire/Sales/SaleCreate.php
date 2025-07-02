<?php

namespace App\Livewire\Sales;

use App\Livewire\Forms\SaleForm;
use App\Models\User;
use Livewire\Component;

class SaleCreate extends Component
{
    public SaleForm $saleForm;

    public function mount($sale = null){
        if(isset($sale)){
            $this->saleForm->setSale($sale);
            return;
        }
    }

    public function save(){
        $sale = $this->saleForm->save();
        redirect()->route('sales.view', ["sale" => $sale->id]);
    }

    public function render()
    {
        return view('livewire.sales.sale-create', ["users" => User::all()]);
    }
}
