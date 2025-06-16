<div>
  <form wire:submit="save">
    <fieldset class="fieldset">
      <legend class="fieldset-legend">Nombre</legend>
      <input type="text" class="input" wire:model="user.name">
      @error('user.name')
        <span class=" text-error">{{ $message }}</span>
      @enderror
    </fieldset>
    <fieldset class="fieldset">
      <legend class="fieldset-legend">Correo electrónico</legend>
      <input type="text" class="input" wire:model="user.email">
      @error('user.email')
        <span class=" text-error">{{ $message }}</span>
      @enderror
    </fieldset>
    <fieldset class="fieldset">
      <legend class="fieldset-legend">Contraseña</legend>
      <input type="text" class="input" wire:model="user.password">
      @error('user.password')
        <span class=" text-error">{{ $message }}</span>
      @enderror
    </fieldset>
    <fieldset class="fieldset">
      <legend class="fieldset-legend">Repetir contraseña</legend>
      <input type="text" class="input" wire:model="user.password_confirmation">
      @error('user.password_confirmation')
        <span class="text-error">{{ $message }}</span>
      @enderror
    </fieldset>
    <button class="btn btn-success">Guardar</button>
  </form>
</div>
