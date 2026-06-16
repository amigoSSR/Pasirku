/**
 * Maps.js — Logika peta Leaflet untuk MenuUtama & Fitur Toko Terdekat
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

    // Icons
    var storeIcon = L.icon({
        iconUrl: window.MAP_CONFIG ? window.MAP_CONFIG.iconUrl : '/img/rumah1.png',
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40]
    });

    var markersGroup = L.layerGroup().addTo(map);
    var userMarker = null;
    var userLat = window.MAP_CONFIG ? window.MAP_CONFIG.userLat : null;
    var userLon = window.MAP_CONFIG ? window.MAP_CONFIG.userLng : null;
    var currentRadius = window.MAP_CONFIG ? window.MAP_CONFIG.radius : '';
    var hasSetView = false;

    // UI Elements
    var shopCardList = document.getElementById('shop-card-list');
    var mapLoader = document.getElementById('map-loader');
    var btnUpdateLoc = document.getElementById('btn-update-location');
    var radiusFilters = document.querySelectorAll('.radius-filter');

    // Initial markers render
    renderStoreMarkers(window.MAP_CONFIG.stores || []);

    // Initial user marker if exists
    if (userLat && userLon) {
        updateUserMarker(userLat, userLon);
        if (!hasSetView) {
            map.setView([userLat, userLon], 14);
            hasSetView = true;
        }
    }

    // Geolocation on load
    if (navigator.geolocation && (!userLat || !userLon)) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            userLat = pos.coords.latitude;
            userLon = pos.coords.longitude;
            updateUserMarker(userLat, userLon);
            if (!hasSetView) {
                map.setView([userLat, userLon], 14);
                hasSetView = true;
            }
            fetchNearbyStores();
        }, function(err) {
            console.warn(`Geolocation error: ${err.message}`);
        });
    }

    /**
     * Fetch nearby stores via AJAX
     */
    function fetchNearbyStores() {
        if (!userLat || !userLon) return;

        mapLoader.classList.remove('hidden');
        
        var url = new URL(window.MAP_CONFIG.nearbyUrl, window.location.origin);
        url.searchParams.append('lat', userLat);
        url.searchParams.append('lng', userLon);
        if (currentRadius) url.searchParams.append('radius', currentRadius);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Update List
                shopCardList.innerHTML = data.html;
                // Update Markers
                renderStoreMarkers(data.stores);
                // Re-bind click events for new cards
                bindCardClicks();
            }
        })
        .catch(err => console.error('Error fetching stores:', err))
        .finally(() => {
            mapLoader.classList.add('hidden');
        });
    }

    /**
     * Render markers for stores
     */
    function renderStoreMarkers(stores) {
        markersGroup.clearLayers();
        stores.forEach(function (store) {
            if (store.lat && store.lng) {
                var distanceLabel = store.distance ? `<p style="font-size: 10px; color: #944a00; font-weight: 700; margin: 4px 0;">${store.distance} km dari lokasi Anda</p>` : '';
                var popupContent = `
                    <div style="font-family: 'Inter', sans-serif; min-width: 200px; padding: 4px;">
                        <h4 style="font-family: 'Manrope', sans-serif; font-weight: 800; color: #944a00; font-size: 14px; margin: 0 0 4px 0;">${store.name}</h4>
                        ${distanceLabel}
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
                var m = L.marker([store.lat, store.lng], { icon: storeIcon })
                    .bindPopup(popupContent);
                markersGroup.addLayer(m);
                
                // Add reference to marker on store object if needed for zoom
                store.marker = m;
            }
        });
    }

    /**
     * Update user marker position
     */
    function updateUserMarker(lat, lng) {
        if (userMarker) {
            userMarker.setLatLng([lat, lng]);
        } else {
            userMarker = L.marker([lat, lng]).addTo(map);
            userMarker.bindPopup("<b style='color:#944a00'>Lokasi Anda</b>").openPopup();
        }
    }

    /**
     * Bind clicks to shop cards to zoom on map
     */
    function bindCardClicks() {
        document.querySelectorAll('.shop-card').forEach(card => {
            card.addEventListener('click', function() {
                var lat = parseFloat(this.dataset.lat);
                var lng = parseFloat(this.dataset.lng);
                if (lat && lng) {
                    map.flyTo([lat, lng], 16, { animate: true, duration: 1 });
                    // Find and open popup
                    markersGroup.eachLayer(layer => {
                        if (layer.getLatLng().lat === lat && layer.getLatLng().lng === lng) {
                            layer.openPopup();
                        }
                    });
                }
            });
        });
    }

    // Radius filters
    radiusFilters.forEach(btn => {
        btn.addEventListener('click', function() {
            radiusFilters.forEach(b => b.classList.remove('bg-primary', 'text-on-primary'));
            radiusFilters.forEach(b => b.classList.add('bg-surface-container-highest', 'text-on-surface-variant'));
            
            this.classList.remove('bg-surface-container-highest', 'text-on-surface-variant');
            this.classList.add('bg-primary', 'text-on-primary');
            
            currentRadius = this.dataset.radius;
            fetchNearbyStores();
        });
    });

    // Button Locate Me & Update Location
    if (btnUpdateLoc) {
        btnUpdateLoc.addEventListener('click', function() {
            if (navigator.geolocation) {
                this.classList.add('animate-spin');
                navigator.geolocation.getCurrentPosition(pos => {
                    userLat = pos.coords.latitude;
                    userLon = pos.coords.longitude;
                    updateUserMarker(userLat, userLon);
                    map.flyTo([userLat, userLon], 15);
                    fetchNearbyStores();
                    this.classList.remove('animate-spin');
                }, () => {
                    this.classList.remove('animate-spin');
                    alert('Gagal mendapatkan lokasi. Pastikan izin lokasi diberikan.');
                });
            }
        });
    }

    var btnLocateMe = document.getElementById('btn-locate-me');
    if (btnLocateMe) {
        btnLocateMe.addEventListener('click', function() {
            if (userLat && userLon) {
                map.flyTo([userLat, userLon], 16);
                if (userMarker) userMarker.openPopup();
            } else {
                btnUpdateLoc.click();
            }
        });
    }

    // Initial binding
    bindCardClicks();

})();
