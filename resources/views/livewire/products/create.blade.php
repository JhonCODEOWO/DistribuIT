<div>
  <form wire:submit="save">
    <div class="grid grid-cols-2 content-center">
      {{-- Product result --}}
      <section class="flex flex-col items-center justify-center gap-3">
        {{-- Show principal images --}}
        <div class="flex">
          <div>
            <h2 class="text-xl text-center mb-2">Imagen del producto</h2>
            @if($image)
              <picture class="flex justify-center flex-col items-center gap-y-3">
                <img src="{{ asset('storage/product_pictures/' . $image) }}" alt=""
                  class="object-cover h-[15rem] w-[15rem] rounded">
              </picture>
            @else
              <p class="alert alert-error alert-soft my-2">No hay imágenes cargadas previamente.</p>
            @endif
            <input type="file" class="file-input" wire:model="productForm.url_image" accept="image/jpeg, image/png">
                @error('productForm.url_image')
                  <p class="text-sm text-error">{{ $message }}</p>
                @enderror
          </div>
          <div class="flex flex-col items-center justify-center">
            @isset ($productForm->url_image)
              <h2 class="text-xl text-center">Imagen a utilizar</h2>
              <p class="text-sm">*Reemplazará a la anterior si es actualización.</p>
              <img src="{{ $productForm->url_image->temporaryUrl() }}" alt="" class="h-[10rem]">
            @endisset
          </div>
        </div>

        @isset ($id)
          <div>
          <h2 class="text-xl text-center">Imágenes del carrusel</h2>
          {{-- Show images if carrouselImages has values --}}
          @isset($carrouselImages)
            <div class="flex max-w-full overflow-y-auto gap-x-3">
              @foreach ($carrouselImages as $itemImage)
                <div wire:key="{{$itemImage->id}}">
                  <img src="{{ asset('storage/global'.'/'.$itemImage->url) }}" alt="{{ $itemImage->url }}" class="max-h-20">
                  <button type="button" wire:click="deleteCarouselImage({{$itemImage->id}})" class=" text-error text-center">Quitar imagen</button>
                </div>
              @endforeach
            </div>
          @endisset

          {{-- Mostrar alerta de que no hay imágenes previas. --}}
          @empty($carrouselImages)
            <p class="alert alert-error alert-soft my-2">No hay imágenes cargadas previamente.</p>
          @endempty
          <fieldset class="fieldset">
            <legend class="fieldset-legend">Selecciona imagen nueva...</legend>
            <input type="file" class="file-input" multiple wire:model="productForm.images">
            @error('productForm.images')
              <p class="text-error">{{ $message }}</p>
            @enderror
            @error('productForm.images.*')
              <p class="text-error">{{ $message }}</p>
            @enderror
          </fieldset>

          <div class="grid grid-cols-3 gap-4">
            @foreach ($images as $image)
                <div wire:key="{{$image->id}}">
                  <img src="{{asset('storage/global/'.$image->url)}}" alt="" class="w-full object-cover">
                  <button type="button" wire:click="addImageGlobal({{$image->id}})" class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 13H5v-2h6V5h2v6h6v2h-6v6h-2z"/></svg> Usar imagen</button>
                </div>
            @endforeach
          </div>
        </div>
        @endisset
        <div>

        </div>
      </section>
      <section>
        <fieldset class="fieldset">
          <legend class="fieldset-legend">Nombre del producto</legend>
          <input type="text" class="input" wire:model="productForm.name">
          @error('productForm.name')
            <p class="text-sm text-error">{{ $message }}</p>
          @enderror
        </fieldset>
        <fieldset class="fieldset">
          <legend class="fieldset-legend">Descripción</legend>
          <textarea name="" id="" cols="30" rows="8" class=" textarea"
            wire:model="productForm.description"></textarea>
          @error('productForm.description')
            <p class="text-sm text-error">{{ $message }}</p>
          @enderror
        </fieldset>
        <fieldset class="fieldset">
          <legend class="fieldset-legend">Stock</legend>
          <input type="number" class="input" wire:model="productForm.stock" min="0">
          @error('productForm.stock')
            <p class="text-sm text-error">{{ $message }}</p>
          @enderror
        </fieldset>
        <fieldset class="fieldset">
          <legend class="fieldset-legend">Precio del producto</legend>
          <input type="number" class="input" wire:model="productForm.price" min="0" step="0.01">
          @error('productForm.price')
            <p class="text-sm text-error">{{ $message }}</p>
          @enderror
        </fieldset>
        <button type="submit" class="btn btn-success">Guardar</button>
      </section>
    </div>
  </form>
</div>
