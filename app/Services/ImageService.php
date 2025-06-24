<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageService {
    /**
     * Corta una imagen a dimensiones 500x500 desde el centro, si la imagen ya tiene esas dimensiones se devuelve la misma imagen
     *
     * @var $file  Archivo proveniente de algún upload file de Laravel o livewire.
     * @return Intervention\Image\Interfaces\ImageInterface Instancia Image con los cambios aplicados.
     */
    public function make500Size($file): ImageInterface{
        $image = Image::read($file);
        return ($image->width() == 500 && $image->width(500))? $image: $image->cover(500, 500);
    }

    /**
     * Almacena una imagen en el disco del servidor recortándola antes de subirla a un formato 500x500
     * 
     * @param mixed $upload Archivo cargado desde una petición HTTP que es un File.
     * @param string $disk Nombre del disco en donde se almacenará el archivo.
     * 
     * @return string Nombre del archivo asignado en el servidor
     */
    public function saveInto($upload, string $disk): string{
        $image = $this->make500Size($upload);
        Storage::disk($disk)->put($upload->getFileName(), $image->encodeByExtension());
        return $upload->getFileName();
    }

    public function deleteIfExists(string $disk, string $path){
        if(Storage::disk($disk)->exists($path)) Storage::disk($disk)->delete($path);
    }
}