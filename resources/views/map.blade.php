<div class="col-8">
    <div id="my-map" style="width: 100%; height: 750px"></div>
</div>
<div class="col-4">
    @livewire('create-marker')
</div>

<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    //map init
    var mapOptions = {
        center: [50.5, 30.5],
        zoom: 3
    }
    var map = new L.map("my-map", mapOptions);
    var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
    map.addLayer(layer);

    //init markers from db
    var markers = JSON.parse('{{ json_encode($markers) }}'.replace(/&quot;/ig,'"'));
    markers.forEach(function (marker) {
        L.marker([marker.lat, marker.lng]).addTo(map)
    });

    //init pusher
    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: 'eu'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('create-marker', function (data) {
        var params = JSON.parse(data.params)
        var latlng = [params.lat, params.lng]
        var marker = L.marker(latlng)
        marker.addTo(map)
        map.setView(latlng, 3)
    });

    channel.bind('remove-marker', function (data) {
        var params = JSON.parse(data.params)
        var markerIfExist = findMarkerIfExist(params)
        var latlng = [params.lat, params.lng];
        if (markerIfExist) {
            map.setView(latlng, 3)
            map.removeLayer(markerIfExist)
            L.popup({
                closeButton: true
            })
                .setLatLng(latlng)
                .setContent('<p>Marker delete</p>')
                .openOn(map);
        } else {
            L.popup({
                closeButton: true
            })
                .setLatLng(latlng)
                .setContent('<p>Marker not found</p>')
                .openOn(map);
        }
    })

    function findMarkerIfExist(params)
    {
        let marker = false;
        map.eachLayer(function (layer) {
            try {
                var layerData = layer.getLatLng()
                if (layerData.lat.toString() === params.lat.toString() && layerData.lng.toString() === params.lng.toString()) {
                    marker = layer
                }
            } catch (error) {

            }
        });
        return marker
    }
</script>
