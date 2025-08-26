<div>
  <livewire:ui.search/>
  <div class="overflow-x-auto">
    <table class="table">
      <!-- head -->
      <thead>
        <tr>
          <th>
            <label>
              <input type="checkbox" class="checkbox" />
            </label>
          </th>
          <th>Cliente</th>
          <th>Ubicación</th>
          <th>Fecha de pedido</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <!-- row 1 -->
        @forelse ($sales as $sale)
          <tr>
            <th>
              <label>
                <input type="checkbox" class="checkbox" />
              </label>
            </th>
            <td>
              <div class="flex items-center gap-3">
                <div class="avatar">
                  <div class="mask mask-squircle h-12 w-12">
                    <img src="{{ 'storage/user_pictures/' . $sale->user->profile_picture }}"
                      alt="Avatar Tailwind CSS Component" />
                  </div>
                </div>
                <div>
                  <a class="font-bold hover:underline hover:cursor-pointer"
                    href="{{ route('sales.view', $sale->id) }}">{{ $sale->user->name }}</a>
                  <div class="text-sm opacity-50">{{ $sale->user->email }}</div>
                </div>
              </div>
            </td>
            <td>
              {{ $sale->city }} - {{ $sale->street }}
            </td>
            <td>
              {{ $sale->created_at }}
            </td>
            <th>
              <button class="btn btn-ghost btn-xs">details</button>
            </th>
          </tr>
        @empty 
          <tr class="h-[20rem]">
            <td colspan="5" class="text-center text-warning text-xl">No se han encontrado datos</td>
          </tr>
        @endforelse
      </tbody>
      <!-- foot -->
      <tfoot>
        <tr>
          <th></th>
          <th>Cliente</th>
          <th>Ubicación</th>
          <th>Fecha de pedido</th>
          <th></th>
        </tr>
      </tfoot>
    </table>
  </div>
  {{ $sales->links() }}
</div>
