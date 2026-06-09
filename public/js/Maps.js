/**
 * Maps.js — Logika peta Leaflet untuk MenuUtama
 * Dipanggil setelah Leaflet JS dimuat.
 * Pastikan window.MAP_CONFIG sudah di-set dari Blade sebelum file ini dimuat.
 */

(function () {
    // Inisialisasi peta
    var map = L.map('map').setView([-5.167267, 119.412866], 13);

    // Tile layer Google Streets
    var googleStreets = L.tileLayer('https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });
    googleStreets.addTo(map);

    // Icon custom (URL didapat dari window.MAP_CONFIG yang di-set via Blade)
    var icon2 = L.icon({
        iconUrl: window.MAP_CONFIG ? window.MAP_CONFIG.iconUrl : '/img/rumah1.png',
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40]
    });

    // Render dynamic store pins from window.MAP_CONFIG.stores
    if (window.MAP_CONFIG && window.MAP_CONFIG.stores) {
        window.MAP_CONFIG.stores.forEach(function (store) {
            if (store.lat && store.lng) {
                var popupContent = `
                    <div style="font-family: 'Inter', sans-serif; min-width: 200px; padding: 4px;">
                        <h4 style="font-family: 'Manrope', sans-serif; font-weight: 800; color: #944a00; font-size: 14px; margin: 0 0 6px 0;">${store.name}</h4>
                        <div style="display: flex; align-items: flex-start; gap: 6px; font-size: 11px; color: #564337; margin-bottom: 12px; line-height: 1.4;">
                            <span class="material-symbols-outlined" style="font-size: 14px; color: #897365; flex-shrink: 0; font-family: 'Material Symbols Outlined';">location_on</span>
                            <span>${store.address}</span>
                        </div>
                        <a href="${store.url}" 
                           style="display: inline-flex; align-items: center; justify-content: center; width: 100%; padding: 8px 12px; background-color: #944a00; color: #ffffff; font-size: 11px; font-weight: 700; border-radius: 8px; text-decoration: none; text-align: center; box-sizing: border-box; transition: background-color 0.2s;">
                           Lihat Toko
                        </a>
                    </div>
                `;
                L.marker([store.lat, store.lng], { icon: icon2 })
                    .addTo(map)
                    .bindPopup(popupContent);
            }
        });
    }

    // Marker posisi user
    var marker = null;
    var userLat = null;
    var userLon = null;
    var hasSetView = false;

    // Geolocation tracking
    if (!navigator.geolocation) {
        console.log('Geolocation is not supported by this browser.');
    } else {
        navigator.geolocation.getCurrentPosition(getPosition, function(err) {
            console.warn(`ERROR(${err.code}): ${err.message}`);
        }, {
            enableHighAccuracy: true
        });

        // Track position continuously
        navigator.geolocation.watchPosition(getPosition);
    }

    function getPosition(position) {
        userLat = position.coords.latitude;
        userLon = position.coords.longitude;
        var accuracy = position.coords.accuracy;

        if (marker) {
            marker.setLatLng([userLat, userLon]);
        } else {
            marker = L.marker([userLat, userLon]).addTo(map);
            marker.bindPopup("<b style='color:#944a00'>Anda di sini</b>").openPopup();
        }

        // Only auto-center once on load
        if (!hasSetView) {
            map.setView([userLat, userLon], 15);
            hasSetView = true;
        }
    }

    // Button Locate Me
    var btnLocate = document.getElementById('btn-locate-me');
    if (btnLocate) {
        btnLocate.addEventListener('click', function () {
            if (userLat && userLon) {
                map.flyTo([userLat, userLon], 16, {
                    animate: true,
                    duration: 1.5
                });
                if (marker) marker.openPopup();
            } else {
                // If position not yet acquired, try again
                navigator.geolocation.getCurrentPosition(function(pos) {
                    userLat = pos.coords.latitude;
                    userLon = pos.coords.longitude;
                    map.flyTo([userLat, userLon], 16);
                });
            }
        });
    }
})();
