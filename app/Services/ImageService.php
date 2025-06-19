<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageService {
    public function make500Size($file): ImageInterface{
        return Image::read($file)->cover(200, 200);
    }

    public function saveInto($upload, string $disk): string{
        $image = $this->make500Size($upload);
        Storage::disk($disk)->put($upload->getFileName(), $image->encodeByExtension());
        return $upload->getFileName();
    }
}