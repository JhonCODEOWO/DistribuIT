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
            <td>{{$product->image}}</td>
            <td>{{$product->name}}</td>
            <td>{{$product->stock}}</td>
            <td>${{$product->price}}</td>
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
