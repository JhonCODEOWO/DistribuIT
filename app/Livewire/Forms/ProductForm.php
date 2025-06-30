<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use App\Services\ImageService;
use FFI;
use Illuminate\Foundation\Http\FormRequest;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class ProductForm extends Form
{
    public ?int $id = null;
    public string $name;
    public string $description;
    public float $stock;
    public float $price;
    public $url_image;
    public ?array $images; //Nullable o arreglo de imágenes cargadas
    public $product_status_id;

    public function rules()
    {
        $rulesGlobal = [
            "name" => "max:30|string|unique:products,name," . $this->id,
            "description" => "min:10",
            "stock" => "min:0",
            "price" => "min:0",
            "url_image" => "nullable|mimes:jpg,png",
            "images" => "nullable|array",
            "images.*" => "mimes:jpg",
            "product_status_id" => 'exists:product_statuses,id',
        ];

        if (!$this->id) {
            $rulesGlobal["stock"] .= '|required';
            $rulesGlobal["price"] .= '|required';
            $rulesGlobal["url_image"] .= '|required';
            $rulesGlobal["product_status_id"] .= '|required';
        }
        return $rulesGlobal;
    }

    public function save()
    {
        // dump($this->all());
        $this->validate();
        if (isset($this->id)) {
            $this->update($this->id);
            return;
        }
        $this->create();
    }

    public function update(int $id)
    {
        $imageService = new ImageService();
        $product = Product::find($id);
        $data = $this->except('url_image', 'images');

        //Si la imagen de producto no viene...
        if ($this->url_image instanceof TemporaryUploadedFile) {
            //Si la imagen de producto viene..
            $imageService->deleteIfExists('product_pictures', $product->url_image);
            $data['url_image'] = $imageService->saveInto($this->url_image, 'product_pictures');
        }
        
        //Actualizar producto
        $product->update($data);

        //Actualizar imágenes de carrito...
        if(isset($this->images)){
            $imageService->assignMany($this->images, $product);
        }
    }

    public function create()
    {
        $imageService = new ImageService();
        $this->url_image = $imageService->saveInto($this->url_image, 'product_pictures');
        $newProduct = Product::create($this->all()); //Creamos el producto.

        //Añadir imágenes del carro si es que están seleccionadas
        if (isset($this->images)) {
            $imageService->assignMany($this->images, $newProduct);
        }
    }

    public function setData(?Product $product)
    {
        $this->name = $product->name;
        $this->description = $product->description;
        $this->stock = $product->stock;
        $this->price = $product->price;
        $this->id = $product->id;
        $this->product_status_id= $product->product_status->id;
    }
}
