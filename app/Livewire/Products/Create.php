<?php

namespace App\Livewire\Products;

use App\Livewire\Forms\ProductForm;
use App\Models\Product;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public ProductForm $productForm;
    public ?int $id = null;
    public string $image;
    
    public function mount(?Product $product){
        $this->productForm->setData($product);
        $this->id = $product->id;
        $this->image = $product->url_image;
    }
    public function save(){
        $this->productForm->save();
        return redirect()->route('products.index');
    }
    public function render()
    {
        return view('livewire.products.create');
    }
}
