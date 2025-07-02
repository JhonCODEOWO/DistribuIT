<?php

namespace App\Livewire\Sales;

use App\Models\Product;
use App\Services\SaleService;
use Livewire\Component;

class View extends Component
{
    public $sale;
    /** @var array<int, float>*/
    public array $quantities = [];
    public function delete($id){
        $this->sale->products()->detach($id);
    }
    public function addProduct(SaleService $saleService){
        //Añadir los productos a la venta
        $saleService->addProductsToSale($this->quantities, $this->sale->id);
        $this->reset('quantities');
    }
    public function render()
    {
        $products = Product::all();
        return view('livewire.sales.view', compact('products'));
    }
}
