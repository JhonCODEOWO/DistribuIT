<?php

namespace App\Livewire\Products;

use App\Livewire\Forms\ProductForm;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductStatus;
use App\Services\ImageService;
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

    public function mount($product = null)
    {
        if (!isset($product)) return;
        $this->productForm->setData($product);
        $this->id = $product->id;
        $this->image = $product->url_image;
        if ($product->images->isNotEmpty())
            $this->carrouselImages = $product->images;
    }
    public function save()
    {
        $this->productForm->save();
        return redirect()->route('products.index', ["searchQuery"=>$this->productForm->name]);
    }
    public function deleteCarouselImage(int $id)
    {
        $product = Product::findOrFail($this->id);
        $product->images()->detach($id);

        // Vuelve a obtener las imágenes actualizadas
        $images = $product->images()->get();
        (!$images->isEmpty())? $this->carrouselImages = $images: $this->carrouselImages = [];
    }

    public function addImageGlobal(Image $image, ImageService $imageService){
        $product = Product::findOrFail($this->id);
        $product->images()->syncWithoutDetaching($image);
        $this->carrouselImages = $product->images()->get();
    }
    public function render()
    {
        $statuses = ProductStatus::all();
        return view('livewire.products.create', ["images"=>Image::all(), "statuses"=>$statuses]);
    }
}
