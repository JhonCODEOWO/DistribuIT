<?php

namespace App\Livewire\Files;

use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ImageList extends Component
{
    public array | Collection $files;
    public string $route = 'storage/';
    public bool $is_crud = false;
    public ?string $disk = null;
    public ?Model $parent = null;

    public function deleteImage(int | string $id, ImageService $imageService){
        $imageService->delete($id);
        switch($this->files instanceof Collection){
            case true:
                $this->files = $this->files->except($id);
                break;
            case false:
                dump('Es un arreglo normal, aún no hay operaciones');
                break;
        }
    }

    public function assignData(Collection | array $data){
        $this->files = $data;
    }

    public function render()
    {
        return view('livewire.files.image-list');
    }
}
