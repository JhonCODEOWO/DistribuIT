<div>
  <form wire:submit="save">
    <section class="flex w-full justify-between">
      <fieldset class="fieldset">
        <legend class="fieldset-legend">Persona a quien será enviado</legend>
        <div class="flex gap-4">
          <select name="" id="" class="select" wire:model="saleForm.user_id">
            <option value="">Selecciona alguno</option>
            @foreach ($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
          </select>
          @error('saleForm.user_id')
            <p class="text-error">{{ $message }}</p>
          @enderror
          <a href="{{ route('user.create') }}" class="btn btn-success"> Crear nuevo... </a>
        </div>
      </fieldset>
      <fieldset class="fieldset">
      <legend class="fieldset-legend">Fecha de entrega límite:</legend>
      <input type="datetime-local" class="input" wire:model="saleForm.due_date">
      @error('saleForm.due_date')
        <p class="text-error">{{ $message }}</p>
      @enderror
    </fieldset>
    </section>
    <div class="grid grid-cols-2 gap-x-6">
      <fieldset class="fieldset">
        <legend class="fieldset-legend">Ubicación de entrega</legend>
        <div id="map" class="w-full h-[20rem] rounded" wire:ignore></div>
        <div class="flex justify-between gap-3">
          <input type="number" name="" id="" wire:model="saleForm.lng" class=" input"
            placeholder="Longitud" step="any">
          @error('saleForm.lng')
            <p class="text-error">{{ $message }}</p>
          @enderror
          <input type="number" name="" id="" wire:model="saleForm.lat" class=" input"
            placeholder="Latitud" step="any">
          @error('saleForm.lat')
            <p class="text-error">{{ $message }}</p>
          @enderror
        </div>
      </fieldset>
      <section class="grid grid-cols-2 gap-3">
        <fieldset class="fieldset">
          <legend class="fieldset-legend">Ciudad:</legend>
          <input type="text" name="" id="" class="input"
            placeholder="Escribe la ciudad donde está el lugar de entrega" wire:model="saleForm.city">
          @error('saleForm.city')
            <p class="text-error">{{ $message }}</p>
          @enderror
        </fieldset>
        <fieldset class="fieldset">
          <legend class="fieldset-legend">Calle:</legend>
          <input type="text" name="" id="" class="input"
            placeholder="Escribe la calle del lugar de entrega" wire:model="saleForm.street">
          @error('saleForm.street')
            <p class="text-error">{{ $message }}</p>
          @enderror
        </fieldset>
        <fieldset class="fieldset flex">
          <div>
            <legend class="fieldset-legend">Número interior</legend>
            <input type="text" wire:model="saleForm.internal_number" class="input">
            @error('saleForm.internal_number')
              <p class="text-error">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <legend class="fieldset-legend">Número interior</legend>
            <input type="text" wire:model="saleForm.external_number" class="input">
            @error('saleForm.external_number')
              <p class="text-error">{{ $message }}</p>
            @enderror
          </div>
        </fieldset>
        <fieldset class="fieldset">
          <legend class="fieldset-legend">Referencias:</legend>
          <textarea name="" id="" cols="30" rows="10" placeholder="Descripciones del lugar..."
            class="textarea" wire:model="saleForm.references"></textarea>
          @error('saleForm.references')
            <p class="text-error">{{ $message }}</p>
          @enderror
        </fieldset>
      </section>
    </div>
    <button class="btn btn-success">Guardar</button>
  </form>
</div>

@script
  <script>
    const lngLat = {
      lng: 0,
      lat: 0
    }
    const markers = [];
    const map = new maplibregl.Map({
      container: 'map', // container id
      style: 'https://api.maptiler.com/maps/basic-v2/style.json?key=0EyRUsuN0ewCEvHq56fN', // style URL
      center: [lngLat.lng, lngLat.lat], // starting position [lng, lat]
      zoom: 1 // starting zoom
    });
    console.log('Hola');

    addEventListeners();

    navigator.permissions.query({
      'name': 'geolocation'
    }).then((result) => {
      console.log(result);
      switch (result.state) {
        case "granted":
          navigator.geolocation.getCurrentPosition(handleLocation);
          break;
        case "prompt":
          navigator.geolocation.getCurrentPosition(handleLocation);
          break;
        case "denied":
          alert('Es necesario activar el servicio de ubicación.');
          break;
        default:
          console.log('nada para hacer');
          break;
      }
    });

    function handleLocation(location) {
      const lng = location.coords.longitude;
      const lat = location.coords.latitude;

      map.setCenter([lng, lat]);
      map.zoomTo(15);
    }

    function addEventListeners() {
      map.on('click', (event) => {
        const lngLatClicked = event.lngLat;
        if (markers.length === 1) handleOneMarker(markers);
        const mark = new maplibregl.Marker().setLngLat(lngLatClicked);
        mark.addTo(map);
        markers.push(mark);
        $wire.saleForm.lng = lngLatClicked.lng;
        $wire.saleForm.lat = lngLatClicked.lat;
      })
    }

    function handleOneMarker(markers) {
      console.log(markers);
      if (markers.length === 1) {
        markers[0].remove();
        markers.pop();
      }
    }
  </script>
@endscript
