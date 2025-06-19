<div>
  <fieldset class=" fieldset mb-3">
    <legend class="fieldset-legend">Buscar</legend>
    <input type="text" wire:model.live="search" class="input">
  </fieldset>
  <table class="table bg-base-200 overflow-x-auto">
    <!-- head -->
    <thead>
      <tr>
        <th>#</th>
        <th class="text-center">Foto de perfil</th>
        <th class="text-center">Nombre</th>
        <th class="text-center">Email</th>
        <th class="text-center">Fecha de creación</th>
        <th class="text-center">Ult. Act.</th>
        <th class="text-center">Opciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
        <tr wire:key="{{ $user->id }}" class="text-center">
          <th>{{ $loop->index + 1 }}</th>
          <th>
            <div class="mask h-12 w-12">
              <img src="{{ asset('storage/'.$user->profile_picture) }}" alt="" class="object-cover rounded-full">
            </div>
          </th>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->created_at }}</td>
          <td>{{ $user->updated_at }}</td>
          <td class="flex gap-x-3 justify-end">
            <a class="btn btn-info" href="{{ route('user.edit', $user->id) }}">Modificar</a>
            <button class="btn btn-error" wire:click="delete({{ $user->id }})"
              wire:confirm="¿Estas seguro de eliminar el registro?">Eliminar</button>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div class=" mt-auto">
    {{ $users->links() }}
  </div>
</div>
