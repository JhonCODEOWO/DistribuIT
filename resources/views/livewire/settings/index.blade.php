<div>
  <h1 class="text-4xl mb-3">Configuraciones del sistema</h1>
  <form action="" wire:submit="save">
    <fieldset class="fieldset">
      <legend class="fieldset-legend">Nombre de la aplicación</legend>
      <input type="text" class="input" wire:model="APP_NAME" placeholder="El nombre de la aplicación" />
      @error('APP_NAME')
        <p class="text-xs text-primary">{{ $message }}</p>
      @enderror
      {{-- <p class="label">You can edit page title later on from settings</p> --}}
    </fieldset>
    <fieldset class="fieldset">
      <legend class="fieldset-legend">Icono de la aplicación</legend>
      @if ($APP_ICON_PREV)
        <div>
          <h3>Imagen actual</h3>
          <img src="{{ asset('storage/app_resources/' . $APP_ICON_PREV) }}">
        </div>
      @endif
      @if ($APP_ICON)
        <div>
          <h3>Imagen seleccionada</h3>
          <img src="{{ $APP_ICON->temporaryUrl() }}">
        </div>
      @endif
      <input type="file" class="file-input file-input-primary focus:outline-none" accept="image/x-icon"
        wire:model="APP_ICON" />
      @error('APP_ICON')
        <p class="text-xs text-primary">{{ $message }}</p>
      @enderror
      <label class="label">Tamaño máximo de 2mb y formato .ico</label>
    </fieldset>

    <button class="btn btn-secondary" type="submit">Aplicar cambios</button>
  </form>

  @session('status')
    <div class="toast">
      <div class="alert alert-info">
        <span>{{session('status')}}</span>
      </div>
    </div>
  @endsession
</div>
