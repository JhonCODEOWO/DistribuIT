<div>
  <section class="grid grid-cols-2 rounded-lg bg-base-200 my-3 p-2 gap-x-5">
    <div>
      <h2 class="text-2xl">Domicilio</h2>
      <p>{{ $sale->street }}, {{ $sale->city }}</p>
      <div class="divider"></div>
      <h2 class="text-2xl">Referencias</h2>
      <p class=" text-justify">{{ $sale->references }}</p>
      <div class="divider"></div>
      <div>
        <button class="btn btn-success">Cobrar</button>
        <button class="btn btn-error">Cancelar pedido</button>
      </div>
    </div>
    <div>
      <livewire:shared.map-viewer :lng="$sale->lng" :lat="$sale->lat" :zoom="15"/>
    </div>
  </section>

  <h2 class="text-center text-2xl mb-4">Pedido</h2>
  <section class="grid grid-cols-2 gap-x-3">
    <ul class="list rounded-box shadow-md bg-base-200">

      <li class="p-4 pb-2 text-xs opacity-60 tracking-wide">Pedido</li>
      {{-- <h2 class="text-2xl">Pedido</h2> --}}
      @foreach ($sale->products as $product)
        <li class="list-row" wire:key="{{ $product->id }}">
          <div>
            <img class="size-10 rounded-box" src="{{ asset('storage/product_pictures/' . $product->url_image) }}" />
          </div>
          <div>
            <div>{{ $product->name }}</div>
            <p><span>{{ $product->pivot->quantity }}</span> | <span
                class="text-success">${{ $product->pivot->subtotal }}</span>
          </div>
          <button class="btn btn-square btn-ghost" wire:click="delete({{ $product->id }})">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
              <path fill="currentColor"
                d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
            </svg>
          </button>
        </li>
      @endforeach
    </ul>

    <ul class="list rounded-box shadow-md max-h-[20rem] overflow-y-auto bg-base-200">
      <li class="p-4 pb-2 text-xs tracking-wide flex items-center justify-between sticky top-0 bg-base-200 z-20">
        Productos disponibles
        <button class="btn btn-success" wire:click="addProduct()">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
          <path fill="currentColor" d="M11 13H5v-2h6V5h2v6h6v2h-6v6h-2z" />
        </svg>
      </button>
      </li>
      @foreach ($products as $product)
        <li class="list-row" wire:key="{{ $product->id }}">
          <div>
            <img class="size-10 rounded-box" src="{{ asset('storage/product_pictures/' . $product->url_image) }}" />
          </div>
          <div>
            {{ $product->name }}
          </div>
          <div>
            <input type="number" class="input" wire:model="quantities.{{$product->id}}">
          </div>
        </li>
      @endforeach
    </ul>
  </section>
</div>
