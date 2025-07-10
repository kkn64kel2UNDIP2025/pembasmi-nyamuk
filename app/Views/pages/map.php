<?php $this->extend('layout/template') ?>
<?php $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="row shadow-sm card card-body">
                <h5 class="text-gray-900 text-2xl font-semibold mb-6">Pemantauan Potensi Perkembangan Nyamuk</h5>      
                        <!-- Statistics Panel -->
                        <div id="statistics" class="mb-6 hidden">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="card card-body bg-blue-50 border border-blue-200 p-4">
                                    <div class="flex items-center">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-blue-600">Total Laporan</p>
                                            <p class="text-2xl font-bold text-blue-900" id="total-count">0</p>
                                        </div>
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex justify-center items-center">
                                            <i class="ti ti-send text-blue-600 w-4"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-body bg-red-50 border border-red-200 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-red-600">Aktif</p>
                                            <p class="text-2xl font-bold text-red-900" id="active-count">0</p>
                                        </div>
                                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-body bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-green-600">Terselesaikan</p>
                                            <p class="text-2xl font-bold text-green-900" id="resolved-count">0</p>
                                        </div>
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-body bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-600">Laporan Palsu</p>
                                            <p class="text-2xl font-bold text-gray-900" id="false-count">0</p>
                                        </div>
                                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="map" class="h-screen rounded-lg border border-gray-300"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="<?= base_url('assets/js/leaflet.js') ?>"></script>

<script>
    const locations = <?= json_encode($locations) ?>;
    
    // Map Initialization
    var map = L.map('map');
    map.setView([-6.962060, 110.44539], 19);

    // Cycl Map Layer
    var CyclOSM = L.tileLayer('https://{s}.tile-cyclosm.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png', {
        maxZoom: 20,
        minZoom: 19,
        attribution: '<a href="https://github.com/cyclosm/cyclosm-cartocss-style/releases" title="CyclOSM - Open Bicycle render">CyclOSM</a> | Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    CyclOSM.addTo(map);

    // Create icons for different levels and status
    let icons = {};
    const statuses = ['aktif', 'terselesaikan', 'laporan palsu'];
    
    // Function to create colored marker using CSS filters
    function createColoredIcon(level, status) {
        let filter = '';
        switch(status) {
            case 'aktif':
                filter = 'hue-rotate(0deg) saturate(1.5) brightness(1.2)'; // Red-ish
                break;
            case 'terselesaikan':
                filter = 'hue-rotate(120deg) saturate(1.5) brightness(1.2)'; // Green-ish
                break;
            case 'laporan palsu':
                filter = 'grayscale(1) brightness(0.7)'; // Gray
                break;
        }
        
        return L.divIcon({
            html: `<div style="
                background-image: url('<?= base_url('assets/icons/marker/level-') ?>${level}-marker.png');
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center;
                width: 30px;
                height: 30px;
                filter: ${filter};
            "></div>`,
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            popupAnchor: [0, -15],
            className: 'custom-marker-icon'
        });
    }

    [1,2,3,4,5].forEach(level => {
        icons[level] = {};
        statuses.forEach(status => {
            icons[level][status] = createColoredIcon(level, status);
        });
    });

    // Create layer groups for different combinations
    let layerGroups = {};
    
    // Initialize layer groups for each level and status combination
    [1,2,3,4,5].forEach(level => {
        layerGroups[level] = {};
        statuses.forEach(status => {
            layerGroups[level][status] = L.layerGroup();
        });
    });

    // Add markers to appropriate layer groups
    locations.forEach(location => {
        const level = parseInt(location.level);
        const status = location.status;
        const lat = parseFloat(location.latitude);
        const lng = parseFloat(location.longitude);
        
        if (lat && lng && level >= 1 && level <= 5) {
            const marker = L.marker([lat, lng], {
                icon: icons[level][status]
            });
            
            // Create popup content with Tailwind CSS classes
            const statusClasses = {
                'aktif': 'text-red-700 bg-red-100 border-red-200',
                'terselesaikan': 'text-green-700 bg-green-100 border-green-200',
                'laporan palsu': 'text-gray-700 bg-gray-100 border-gray-200'
            };
            
            const statusClass = statusClasses[status] || statusClasses['aktif'];
            
            const popupContent = `
                <div class="p-4 min-w-[280px] font-sans">
                    <div class="flex gap-1 mb-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ${statusClass}">
                            ${status.toUpperCase()}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 border border-blue-200">
                            Level ${level}
                        </span>
                    </div>
                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex">
                            <span class="font-semibold w-20 flex-shrink-0">Name:</span>
                            <span>${location.name}</span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold w-20 flex-shrink-0">Kategori:</span>
                            <span>${location.category_name}</span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold w-20 flex-shrink-0">Deskripsi:</span>
                            <span class="flex-1">${location.description}</span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold w-20 flex-shrink-0">Dilaporkan:</span>
                            <span>${new Date(location.reported_at).toLocaleString('id-ID')}</span>
                        </div>
                        ${location.resolve_at ? `
                        <div class="flex">
                            <span class="font-semibold w-20 flex-shrink-0">Diselesaikan:</span>
                            <span>${new Date(location.resolve_at).toLocaleString('id-ID')}</span>
                        </div>` : ''}
                        ${location.phone ? `
                        <div class="flex">
                            <span class="font-semibold w-20 flex-shrink-0">Telepon:</span>
                            <span>${location.phone}</span>
                        </div>` : ''}
                    </div>
                    ${location.evidence_image ? `
                        <div class="mt-4">
                            <img src="https://nbqxohqnlurhpzlqybmg.supabase.co/storage/v1/object/public/pelaporan//${location.evidence_image}" 
                                 class="w-full h-auto max-h-48 object-cover rounded-lg border border-gray-200 shadow-sm" 
                                 alt="Evidence">
                        </div>
                    ` : ''}
                </div>
            `;
            
            marker.bindPopup(popupContent);
            layerGroups[level][status].addLayer(marker);
        }
    });

    // Create layer control
    let baseMaps = {
        "CyclOSM": CyclOSM
    };

    let overlayMaps = {};
    
    // Add overlay controls for each level and status with count
    [1,2,3,4,5].forEach(level => {
        statuses.forEach(status => {
            const count = layerGroups[level][status].getLayers().length;
            const layerName = `Level ${level} - ${status.charAt(0).toUpperCase() + status.slice(1)} (${count})`;
            if (count > 0) { // Only show layers that have markers
                overlayMaps[layerName] = layerGroups[level][status];
            }
        });
    });

    // Add all active and resolved layers to map by default
    [1,2,3,4,5].forEach(level => {
        if (layerGroups[level]['aktif'].getLayers().length > 0) {
            layerGroups[level]['aktif'].addTo(map);
        }
        if (layerGroups[level]['terselesaikan'].getLayers().length > 0) {
            layerGroups[level]['terselesaikan'].addTo(map);
        }
    });

    // Add layer control to map
    L.control.layers(baseMaps, overlayMaps, {
        collapsed: false
    }).addTo(map);
    
    // Add statistics summary
    const totalMarkers = locations.length;
    const activeCount = locations.filter(loc => loc.status === 'aktif').length;
    const resolvedCount = locations.filter(loc => loc.status === 'terselesaikan').length;
    const falseReportCount = locations.filter(loc => loc.status === 'laporan palsu').length;
    
    // Update UI with statistics
    document.getElementById('total-count').textContent = totalMarkers;
    document.getElementById('active-count').textContent = activeCount;
    document.getElementById('resolved-count').textContent = resolvedCount;
    document.getElementById('false-count').textContent = falseReportCount;
    
    // Show statistics panel if there are any locations
    if (totalMarkers > 0) {
        document.getElementById('statistics').classList.remove('hidden');
    }
    
    // Auto-fit map to show all markers if there are any
    if (locations.length > 0) {
        const group = new L.featureGroup();
        
        // Add all visible markers to the group
        [1,2,3,4,5].forEach(level => {
            statuses.forEach(status => {
                layerGroups[level][status].eachLayer(function(layer) {
                    group.addLayer(layer);
                });
            });
        });
        
        // Fit map to show all markers with some padding
        if (group.getLayers().length > 0) {
            map.fitBounds(group.getBounds(), {
                padding: [20, 20],
                maxZoom: 18
            });
        }
    }


</script>

<?php $this->endSection() ?>