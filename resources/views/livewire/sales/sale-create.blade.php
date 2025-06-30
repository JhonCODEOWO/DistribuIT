<div>
  <form wire:submit="save">
    <fieldset class="fieldset">
      <legend class="fieldset-legend">Persona a quien será enviado</legend>
      <div class="flex gap-4">
        <select name="" id="" class="select">
          <option value="">Selecciona alguno</option>
          @foreach (\App\Models\User::all() as $user)
            <option value="">{{ $user->name }}</option>
          @endforeach
        </select>
        <a href="{{ route('user.create') }}" class="btn btn-success"> Crear nuevo... </a>
      </div>
    </fieldset>
    <div class="grid grid-cols-2 gap-x-6">
      <fieldset class="fieldset">
        <legend class="fieldset-legend">Ubicación de entrega</legend>
        <div id="map" class="w-full h-[20rem]"></div>
        <div class="flex justify-between gap-3">
          <input type="number" name="" id="" wire:model="lng" class=" input" placeholder="Longitud">
          <input type="number" name="" id="" wire:model="lat" class=" input" placeholder="Latitud">
        </div>
      </fieldset>
      <section>
        <fieldset class="fieldset">
          <legend class="fieldset-legend">Ciudad:</legend>
          <input type="text" name="" id="" class="input" placeholder="Escribe la ciudad donde está el lugar de entrega">
        </fieldset>
        <fieldset class="fieldset">
          <legend class="fieldset-legend">Calle:</legend>
          <input type="text" name="" id="" class="input" placeholder="Escribe la calle del lugar de entrega">
        </fieldset>
        <fieldset class="fieldset">
          <legend class="fieldset-legend">Fecha de entrega límite:</legend>
          <input type="datetime-local" class="input">
        </fieldset>
        <button class="btn btn-success">Guardar</button>
      </section>
    </div>
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
        const lngLatClckd = event.lngLat;
        if (markers.length === 1) handleOneMarker(markers);
        const mark = new maplibregl.Marker().setLngLat(lngLatClckd);
        mark.addTo(map);
        markers.push(mark);
        $wire.lng = lngLatClckd.lng;
        $wire.lat = lngLatClckd.lat;
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
