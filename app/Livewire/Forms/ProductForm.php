<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductForm extends Form
{
    public string $name;
    public string $description;
    public float $stock;
    public float $price;

    public function rules(){

    }

    public function setData(Product $product){
        $this->name = $product->name;
        $this->description = $product->description;
        $this->stock = $product->stock;
        $this->price = $product->price;
    }
}
