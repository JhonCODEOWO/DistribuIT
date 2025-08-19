<?php

namespace App\Services;

use App\Models\Image as ModelsImage;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;
use Ramsey\Uuid\Rfc4122\UuidV4;

class ImageService
{
    private string $disk = 'global';
    /**
     * Corta una imagen a dimensiones 500x500 desde el centro, si la imagen ya tiene esas dimensiones se devuelve la misma imagen
     *
     * @var $file  Archivo proveniente de algún upload file de Laravel o livewire.
     * @return Intervention\Image\Interfaces\ImageInterface Instancia Image con los cambios aplicados.
     */
    public function make500Size($file): ImageInterface
    {
        $image = Image::read($file);
        return ($image->width() == 500 && $image->height() == 500) ? $image : $image->cover(500, 500);
    }

    /**
     * Almacena una imagen en el disco del servidor recortándola antes de subirla a un formato 500x500
     * 
     * @param mixed $upload Archivo cargado desde una petición HTTP que es un File.
     * @param string $disk Nombre del disco en donde se almacenará el archivo.
     * 
     * @return string Nombre del archivo asignado en el servidor
     */
    public function saveInto($upload, ?string $disk = null): string
    {
        try {
            $disk = $disk ?? $this->disk;
            $extension = $upload->getClientOriginalExtension();
            $image = $this->make500Size($upload);
            $fileName = UuidV4::uuid4()->toString() . '.' . $extension;
            Storage::disk($disk)->put($fileName, $image->encodeByExtension($extension));
            return $fileName;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return '';
        }
    }

    /**
     * Almacena imágenes en el disco del servidor recortando cada una a un formato 500x500
     * 
     * @param array $uploadFiles Arreglo de archivos cargados para utilizar en el servidor.
     * @param string $disk Nombre del disco en donde se almacenará el archivo.
     * 
     * @return array Arreglo con los nombres de los archivos subidos al servidor
     */
    public function saveMassInto(array $uploadFiles, ?string $disk): array
    {
        $disk = $disk ?? $this->disk;
        $names = array();

        //Recorrer cada archivo
        foreach ($uploadFiles as $file) {
            array_push($names, $this->saveInto($file, $disk)); //Almacenar cada archivo y el nombre en un arreglo
        }

        return $names;
    }

    public function deleteIfExists(?string $disk = null, string $path)
    {
        $disk = $disk ?? $this->disk;
        if (Storage::disk($disk)->exists($path)) Storage::disk($disk)->delete($path);
    }


    /**
     * Almacena imágenes en el disco del servidor recortando cada una a un formato 500x500 y las relaciona hacia el modelo especificado
     * 
     * @param array $fileNames Arreglo de strings con nombres de archivos a asignar a la relación
     * @param mixed $parent Modelo padre al que se relacionaran las imágenes
     * @return string Nombre del archivo asignado en el servidor
     * @notes No valida si $parent tiene la relación polimorfa por lo que puede crear imágenes y no generar las relaciones.
     * @notes El parámetro $disk no es tan funcional y puede que sea retirado en un futuro, dado que el disco para imágenes es global y probablemente se almacene en otro apartado.
     */
    public function assignMany(array $uploadedFiles, $parent, ?string $disk = null)
    {
        $disk = $disk ?? $this->disk;
        $fileNames = $this->saveMassInto($uploadedFiles, $disk); //Guardar archivos en el disco y obtener nombres

        //Generar registros en BD sobre los archivos subidos
        $images = array();
        foreach ($fileNames as $file) {
            array_push($images, $this->create(["url" => $file])); //Almacenar cada registro en un arreglo
        }

        $parent->images()->syncWithoutDetaching($images); //Relacionar todos los registros del arreglo.
    }

    /**
     *  Crea un registro de imagen en la base de datos.
     * @param $data Los datos a almacenar, deben ser los datos del modelo ya validados
     * @return \App\Models\Image Registro de imagen creada
     */
    public function create(array $data): ModelsImage
    {
        return ModelsImage::create($data);
    }

    /** 
     * Elimina una imagen de manera permantente en el servidor
     */
    public function delete(int $id): bool
    {
        $image = $this->findOne($id);
        $this->deleteIfExists('global', $image->url);
        $image->delete();
        return true;
    }

    public function findOne(int $id): ModelsImage
    {

        return ModelsImage::findOrFail($id);
    }

    public function update($id, array $data): ModelsImage
    {
        $image = $this->findOne($id);
        $image->update($data);
        return $image;
    }
}
