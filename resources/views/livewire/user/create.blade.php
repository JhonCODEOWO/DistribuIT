<div>
  <form wire:submit="save">
    <fieldset class="fieldset">
      <legend class="fieldset-legend">Nombre</legend>
      <input type="text" class="input" wire:model="userForm.name">
      @error('userForm.name')
        <span class=" text-error">{{ $message }}</span>
      @enderror
    </fieldset>
    <fieldset class="fieldset">
      <legend class="fieldset-legend">Correo electrónico</legend>
      <input type="text" class="input" wire:model="userForm.email">
      @error('userForm.email')
        <span class=" text-error">{{ $message }}</span>
      @enderror
    </fieldset>
    @if (!isset($user))
      <fieldset class="fieldset">
        <legend class="fieldset-legend">Contraseña</legend>
        <input type="text" class="input" wire:model="userForm.password">
        @error('userForm.password')
          <span class=" text-error">{{ $message }}</span>
        @enderror
      </fieldset>
      <fieldset class="fieldset">
        <legend class="fieldset-legend">Repetir contraseña</legend>
        <input type="text" class="input" wire:model="userForm.password_confirmation">
        @error('userForm.password_confirmation')
          <span class="text-error">{{ $message }}</span>
        @enderror
      </fieldset>
    @endif
    <button class="btn btn-success">Guardar</button>
  </form>
</div>
