<?php $this->extend('layout/template') ?>
<?php $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-gray-900 text-lg font-semibold inline-block">Pemantauan Potensi Perkembangan Nyamuk</h5>
                        <div id="map" class="h-screen"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="<?= base_url('assets/js/leaflet.js') ?>"></script>
<script>
    // Map Initialization
    var map = L.map('map');

    // OSN Layer
    var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    osm.addTo(map);

    // Marker
    const icon = L.icon({
        iconUrl: '<?= base_url('assets/leaflet/icons/green-marker.png') ?>',
        iconSize: [30, 30],
        iconAnchor: [15, 15],

    });
    const Marker1 = L.marker([-6.96448528, 110.44894667]);
    const Marker2 = L.marker([-6.96448528, 110.44894667], {
        icon: icon,
        draggable: true
    });
    const Marker3 = L.marker([-6.96448, 110.4489]);
    const Marker4 = L.marker([-6.9644, 110.4489]);

    const popUp1 = Marker1.bindPopup('<h1>This is Kaligawe</h1><img src="./icons/green-marker.png">').openPopup();
    const popUp2 = Marker2.bindPopup("This is marker 2 Kaligawe\n" + Marker2.getLatLng()).openPopup();
    const popUp3 = Marker3.bindPopup("This is marker 3 besides Kaligawe\n" + Marker3.getLatLng()).openPopup();
    const popUp4 = Marker4.bindPopup("This is marker 4 Kaligawe\n" + Marker4.getLatLng()).openPopup();

    // Layer Controller
    const baseMaps = {
        "OpenStreetMap": osm
    };

    var cities = L.layerGroup([popUp2, popUp3, popUp4]);
    let overlayMaps = {
        "Marker1": cities,
        "Marker2": popUp1
    };

    cities.addTo(map);
    popUp1.addTo(map);
    L.control.layers(baseMaps, overlayMaps).addTo(map);

    // Minta lokasi pengguna
    map.locate({
    setView: true,
    maxZoom: 20,
    enableHighAccuracy: true
    });

    // Jika lokasi berhasil didapat
    function onLocationFound(e) {
        var radius = e.accuracy;

        // Tambahkan marker di lokasi
        L.marker(e.latlng).addTo(map)
            .bindPopup("Kamu berada di sekitar " + radius.toFixed(0) + " meter dari sini").openPopup();

        // Tambahkan lingkaran akurasi
        L.circle(e.latlng, radius).addTo(map);
    }

    // Jika gagal mendapatkan lokasi
    function onLocationError(e) {
        alert("Gagal mendapatkan lokasi: " + e.message);
    }

    // Event listener
    map.on('locationfound', onLocationFound);
    map.on('locationerror', onLocationError);
</script>

<?php $this->endSection() ?>