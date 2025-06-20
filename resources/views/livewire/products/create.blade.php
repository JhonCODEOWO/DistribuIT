<div>
  <form wire:submit="">
    <div class="grid grid-cols-2 content-center">
        {{-- Product result --}}
      <section class="flex items-center flex-col justify-center gap-3">
        <h2 class="text-xl">Imagen del producto</h2>
        <picture class="flex justify-center flex-col items-center gap-y-3">
            <img src="https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png" alt="" class="object-cover h-[15rem] w-[15rem] rounded">
            <input type="file" class="file-input">
        </picture>
      </section>
      <section>
        <fieldset class="fieldset">
          <legend class="fieldset-legend">Nombre del producto</legend>
          <input type="text" class="input" wire:model="productForm.name">
        </fieldset>
        <fieldset class="fieldset">
          <legend class="fieldset-legend">Descripción</legend>
          <textarea name="" id="" cols="30" rows="8" class=" textarea"
            wire:model="productForm.description"></textarea>
        </fieldset>
        <fieldset class="fieldset">
          <legend class="fieldset-legend">Stock</legend>
          <input type="number" class="input" wire:model="productForm.stock" min="0">
        </fieldset>
        <fieldset class="fieldset">
          <legend class="fieldset-legend">Precio del producto</legend>
          <input type="text" class="input" wire:model="productForm.price">
        </fieldset>
      </section>
    </div>
  </form>
</div>
