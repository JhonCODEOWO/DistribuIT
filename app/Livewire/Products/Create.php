<?php

namespace App\Livewire\Products;

use App\Livewire\Forms\ProductForm;
use App\Models\Product;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Create extends Component
{
    public ProductForm $productForm;
    
    public function mount(?Product $product){
        $this->productForm->setData($product);
    }
    public function render()
    {
        return view('livewire.products.create');
    }
}
