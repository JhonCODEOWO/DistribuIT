<div>
  <form wire:submit="save">
    <div class="grid grid-cols-2 content-center">
      {{-- Product result --}}
      <section class="flex items-center justify-center gap-3">
        <div>
          <h2 class="text-xl text-center mb-2">Imagen del producto</h2>
          <picture class="flex justify-center flex-col items-center gap-y-3">
            <img src="{{ asset('storage/product_pictures/' . $image) }}" alt=""
              class="object-cover h-[15rem] w-[15rem] rounded">
            <input type="file" class="file-input" wire:model="productForm.url_image" accept="image/jpeg, image/png" >
            @error('productForm.url_image')
              <p class="text-sm text-error">{{ $message }}</p>
            @enderror
          </picture>
        </div>
        <div class="flex flex-col items-center justify-center">
          @if ($productForm->url_image)
            <h2 class="text-xl text-center">Imagen a utilizar</h2>
            <p class="text-sm">*Reemplazará a la anterior si es actualización.</p>
            <img src="{{ $productForm->url_image->temporaryUrl() }}" alt="" class="h-[15rem]">
          @endif
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
          <input type="text" class="input" wire:model="productForm.price">
          @error('productForm.price')
            <p class="text-sm text-error">{{ $message }}</p>
          @enderror
        </fieldset>
        <button type="submit" class="btn btn-success">Guardar</button>
      </section>
    </div>
  </form>
</div>
