<div id="map" class="w-full h-full rounded">
    {{-- Be like water. --}}
</div>

@script
<script>
    const lngLat = {
      lng: $wire.lng,
      lat: $wire.lat,
    }

    const map = new maplibregl.Map({
      container: 'map', // container id
      style: 'https://api.maptiler.com/maps/basic-v2/style.json?key=0EyRUsuN0ewCEvHq56fN', // style URL
      center: [lngLat.lng, lngLat.lat], // starting position [lng, lat]
      zoom: $wire.zoom // starting zoom
    });

    const marker = new maplibregl.Marker()
    marker.setLngLat(lngLat).addTo(map);
</script>
@endscript
