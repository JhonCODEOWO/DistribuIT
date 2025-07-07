<div>
  <form wire:submit="save" class="p-10">
    @if ($tempImg)
    <fieldset class="fieldset items-center">
      <legend class="fieldset-legend">Imagen actual</legend>
      <img src="{{$tempImg}}" alt="" class=" max-h-[300px] max-w-[300px] rounded-full">
    </fieldset>
    @if($userForm->profile_picture)
    <fieldset class="fieldset items-center">
      <legend class="fieldset-legend">Imagen seleccionada</legend>
      <p>*La imagen se recortará a un formato de 500*500px</p>
      <img src="{{$userForm->profile_picture->temporaryUrl()}}" alt="" class=" max-h-[100px] max-w-[100px] rounded-full">
    </fieldset>
    @endif
    @endif
    <fieldset class="fieldset">
      <legend class="fieldset-legend">Imagen de perfil:</legend>
      <input type="file" name="profile_picture" id="" class="file-input" wire:model="userForm.profile_picture" >
      @error('userForm.profile_picture')
        <span class=" text-error">{{ $message }}</span>
      @enderror
    </fieldset>
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
