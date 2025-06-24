<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use App\Services\ImageService;
use Livewire\Form;

class ProductForm extends Form
{
    public ?int $id = null;
    public string $name;
    public string $description;
    public float $stock;
    public float $price;
    public $url_image;
    public $images;

    public function rules(){
        $rulesGlobal = [
            "name" => "max:30|string|unique:products,name,".$this->id,
            "description" => "min:10",
            "stock" => "min:0",
            "price" => "min:0|decimal:2",
            "url_image" => "nullable|mimes:jpg,png",
            "images" => "required|array",
            "images.*" => "mimes:jpg",
        ];

        if(!$this->id){
            $rulesGlobal["stock"] .= '|required';
            $rulesGlobal["price"] .= '|required';
            $rulesGlobal["url_image"] .= '|required';
        }
        return $rulesGlobal;
    }

    public function save(){
        $this->validate();
        return;
        if(isset($this->id)) {
            $this->update($this->id);
            return;
        }
        $this->create();
    }

    public function update(int $id){
        $imageService = new ImageService();
        $product = Product::find($id);
        if(isset($this->url_image)){
            $imageService->deleteIfExists('product_pictures', $product->url_image);
            $this->url_image = $imageService->saveInto($this->url_image, 'product_pictures');
            $product->update($this->all());
        }

        $product->update($this->except('url_image'));
    }

    public function create(){
        $imageService = new ImageService();
        $this->url_image = $imageService->saveInto($this->url_image, 'product_pictures');
        Product::create($this->all());
    }

    public function setData(?Product $product){
        $this->name = $product->name;
        $this->description = $product->description;
        $this->stock = $product->stock;
        $this->price = $product->price;
        $this->id = $product->id;
    }
}
