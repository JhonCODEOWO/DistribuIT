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
    public ?string $image;
    public $carrouselImages = [];
    
    public function mount($product = null){
        if(!isset($product)) return;
        $this->productForm->setData($product);
        $this->id = $product->id;
        $this->image = $product->url_image;
        if($product->images->isNotEmpty())
        $this->carrouselImages = $product->images;
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
