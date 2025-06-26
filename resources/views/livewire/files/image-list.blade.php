<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3">
    @foreach ($files as $file)
        <div>
            <picture wire:key="{{$file->id}}">
            <img src="{{asset($route.$file->url)}}" alt="" class="object-cover rounded">
            </picture>
            @if ($is_crud)
                <div class="mt-2">
                    <button class="btn btn-error" wire:click="deleteImage({{$file->id}})" wire:confirm.prompt="Eliminar este recurso lo borrará de todos los registros en donde esté asignado \n¿Continuar? \nEscribe ELIMINAR para continuar |ELIMINAR">Eliminar imagen</button>
                </div>
            @endif
        </div>
    @endforeach
</div>
