/**
 * Maps.js — Logika peta Leaflet untuk MenuUtama
 * Dipanggil setelah Leaflet JS dimuat.
 * Pastikan window.MAP_CONFIG sudah di-set dari Blade sebelum file ini dimuat.
 */

(function () {
    // Inisialisasi peta
    var map = L.map('map').setView([-5.167267, 119.412866], 13);

    // Tile layer Google Streets
    var googleStreets = L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });
    googleStreets.addTo(map);

    // Icon custom (URL didapat dari window.MAP_CONFIG yang di-set via Blade)
    var icon2 = L.icon({
        iconUrl: window.MAP_CONFIG ? window.MAP_CONFIG.iconUrl : '/img/rumah1.png',
        iconSize: [40, 40],
    });

    // Marker tetap (kampus/lokasi referensi)
    var kampus = L.marker([-5.166912, 119.412656], { icon: icon2 })
        .bindPopup('This is kampus, CO.');
    L.layerGroup([kampus]).addTo(map);

    // Marker posisi user
    var marker = null;
    var hasSetView = false;

    // Geolocation tracking
    if (!navigator.geolocation) {
        console.log('Geolocation is not supported by this browser.');
    } else {
        setInterval(function () {
            navigator.geolocation.getCurrentPosition(getPosition);
        }, 1000);
    }

    function getPosition(position) {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
        var accuracy = position.coords.accuracy;
        console.log(lat, lon, accuracy);

        if (marker) {
            // Pindahkan marker yang sudah ada, jangan buat baru
            marker.setLatLng([lat, lon]);
        } else {
            // Buat marker hanya sekali
            marker = L.marker([lat, lon]).addTo(map);
        }

        // Hanya sekali pindahkan view ke posisi user
        if (!hasSetView) {
            map.setView([lat, lon], 16);
            hasSetView = true;
        }
    }
})();
