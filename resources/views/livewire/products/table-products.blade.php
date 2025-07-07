<div>
    <livewire:ui.search />
    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200">
    <table class="table text-center">
      <!-- head -->
      <thead>
        <tr>
          <th>#</th>
          <th>Imagen</th>
          <th>Nombre</th>
          <th>Stock</th>
          <th>Price</th>
          <th>Operaciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- row 1 -->
        @foreach ($products as $product)
          <tr wire:key="{{$product->id}}">
            <th>{{$loop->index + 1}}</th>
            <td class="flex justify-center">
              <img src="{{$product->url_image_resource}}" alt="" class=" object-cover rounded h-24">
            </td>
            <td class="uppercase font-medium text-lg">
              {{$product->name}}
            </td>
            <td @class([
              'text-success' => $product->stock > 20,
              'text-warning' => $product->stock > 10,
              'text-error' => $product->stock <= 10,
            ])>{{$product->stock}}</td>
            <td class="text-success font-bold">${{$product->price}}</td>
            <td>
                <a href="{{route('products.edit', $product->id)}}" class="btn btn-info">Modificar</a>
                <button class="btn btn-error" wire:click="delete({{$product->id}})" wire:confirm="Eliminar este producto borrará todo sus registros relacionados ¿Esta seguro?">Eliminar</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="divider"></div>
  {{ $products->links() }}
</div>
