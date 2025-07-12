<?php $this->extend('layout/template') ?>
<?php $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="row shadow-md card card-body">
                <h5 class="text-gray-900 text-2xl font-semibold mb-6">Pemantauan Potensi Perkembangan Nyamuk</h5>
                <!-- Statistics Panel -->
                <div id="statistics" class="mb-6">
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

                <div id="map" class="h-[96vh] z-1 rounded-lg border border-gray-300"></div>
            </div>
        </div>
    </div>
    </div>
    <?= $this->include('layout/footer') ?>
    </div>
</main>

<!-- Main modal -->
<div id="detail-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full" onclick="closeDetailModal(event)">
    <div class="relative p-4 w-full max-w-2xl max-h-[96vh]" onclick="event.stopPropagation()">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    Detail Laporan
                </h3>
                <button type="button" onclick="closeDetailModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="px-4 pb-4" id="detail-form" method="POST" action="<?= base_url('peta/update') ?>">
                <div class="text-center text-gray-500">
                    <p>Loading...</p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const locations = <?= json_encode($locations) ?>;

    // Map Initialization
    var map = L.map('map');
    map.setView([-6.962060, 110.44539], 18);

    // Cycl Map Layer
    var CyclOSM = L.tileLayer('https://{s}.tile-cyclosm.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png', {
        maxZoom: 20,
        minZoom: 18,
        attribution: '<a href="https://github.com/cyclosm/cyclosm-cartocss-style/releases" title="CyclOSM - Open Bicycle render">CyclOSM</a> | Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    CyclOSM.addTo(map);

    // Locate user 
    // map.locate({
    //   setView: false,
    //   maxZoom: 18,
    //   enableHighAccuracy: true,
    //   timeout: 10000
    // });

    // // User Location
    // map.on('locationfound', function (e) {
    //   const accuracy = e.accuracy;
    //   const latlng = e.latlng;

    //   if (accuracy <= 25) {
    //     // Tambahkan lingkaran biru
    //     L.circle(latlng, {
    //       radius: accuracy,
    //       color: 'blue',
    //       fillColor: 'blue',
    //       fillOpacity: 0.3
    //     }).addTo(map);

    //   }
    // });

    // Create icons for different levels and status
    let icons = {};
    const statuses = ['aktif', 'terselesaikan', 'laporan palsu'];

    // Function to create colored marker using CSS filters
    function createColoredIcon(level, status) {
        let filter = '';
        switch (status) {
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

    [1, 2, 3, 4, 5].forEach(level => {
        icons[level] = {};
        statuses.forEach(status => {
            icons[level][status] = createColoredIcon(level, status);
        });
    });

    // Create layer groups for different combinations
    let layerGroups = {};

    // Initialize layer groups for each level and status combination
    [1, 2, 3, 4, 5].forEach(level => {
        layerGroups[level] = {};
        statuses.forEach(status => {
            layerGroups[level][status] = L.layerGroup();
        });
    });

    // Add markers to appropriate layer groups
    locations.forEach(location => {
        const status = location.status;
        const level = location.level;
        const lat = parseFloat(location.latitude);
        const lng = parseFloat(location.longitude);

        const marker = L.marker([lat, lng], {
            icon: icons[level][status]
        });

        // Create popup content with Tailwind CSS classes
        const statusClasses = {
            'aktif': 'text-red-700 bg-red-100 border-red-200',
            'terselesaikan': 'text-green-700 bg-green-100 border-green-200',
            'laporan palsu': 'text-gray-700 bg-gray-100 border-gray-200'
        };

        const statusClass = statusClasses[status];

        const popupContent = `
                <div class="p-4 min-w-60 font-sans">
                    <div class="flex gap-1 mb-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ${statusClass}">
                            ${status.toUpperCase()}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 border border-blue-200">
                            Level ${level}
                        </span>
                    </div>
                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex gap-1">
                            <span class="font-semibold w-20 flex-shrink-0">Name:</span>
                            <span>${location.name}</span>
                        </div>
                        <div class="flex gap-1">
                            <span class="font-semibold w-20 flex-shrink-0">Kategori:</span>
                            <span>${location.category_name}</span>
                        </div>
                        <div class="flex gap-1">
                            <span class="font-semibold w-20 flex-shrink-0">Dilaporkan:</span>
                            <span>${new Date(location.reported_at).toLocaleString('id-ID')}</span>
                        </div>
                        ${location.resolve_at ? `
                        <div class="flex gap-1">
                            <span class="font-semibold w-20 flex-shrink-0">Diselesaikan:</span>
                            <span>${new Date(location.resolve_at).toLocaleString('id-ID')}</span>
                        </div>` : ''}
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-200 flex justify-center">
                    <button onclick="openDetailModal('${location.id}')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center" type="button">
                        Lihat Detail
                    </button>
                    </div>
                </div>
            `;

        marker.bindPopup(popupContent);
        layerGroups[level][status].addLayer(marker);

    });

    let overlayMaps = {};

    // Add overlay controls for each level and status with count
    [1, 2, 3, 4, 5].forEach(level => {
        statuses.forEach(status => {
            const count = layerGroups[level][status].getLayers().length;
            const layerName = `Level ${level} - ${status.charAt(0).toUpperCase() + status.slice(1)} (${count})`;
            if (count > 0) { // Only show layers that have markers
                overlayMaps[layerName] = layerGroups[level][status];
            }
        });
    });

    // Add all active layers to map by default
    [1, 2, 3, 4, 5].forEach(level => {
        if (layerGroups[level]['aktif'].getLayers().length > 0) {
            layerGroups[level]['aktif'].addTo(map);
        }
    });

    // Add layer control to map
    L.control.layers(null, overlayMaps).addTo(map);

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

    // Auto-fit map to show all markers if there are any
    if (locations.length > 0) {
        const group = new L.featureGroup();

        // Add all visible markers to the group
        [1, 2, 3, 4, 5].forEach(level => {
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

    // Function to open modal with location details
    function openDetailModal(locationId) {
        const location = locations.find(loc => loc.id == locationId);
        if (!location) return;

        // Update modal content
        const modal = document.getElementById('detail-modal');
        const modalHeader = modal.querySelector('h3');
        const modalForm = modal.querySelector('form');

        modalHeader.textContent = 'Detail Laporan';

        // Create detailed content for the modal
        const statusClasses = {
            'aktif': 'text-red-700 bg-red-100 border-red-200',
            'terselesaikan': 'text-green-700 bg-green-100 border-green-200',
            'laporan palsu': 'text-gray-700 bg-gray-100 border-gray-200'
        };

        const statusClass = statusClasses[location.status];

        modalForm.innerHTML = `
            <input type="hidden" id="location_id" name="location_id" value="${location.id}">
            <input type="hidden" id="status" name="status" value="">
            <div class="p-4 md:p-5">
                <div class="flex gap-2 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border ${statusClass}">
                        ${location.status.toUpperCase()}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700 border border-blue-200">
                        Level ${location.level}
                    </span>
                </div>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Nama Pelapor</label>
                        <p class="text-gray-700">${location.name}</p>
                    </div>
                    ${location.phone ? `
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Nomor Telepon</label>
                        <p class="text-gray-700">${location.phone}</p>
                    </div>` : ''}
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Kategori</label>
                        <p class="text-gray-700">${location.category_name}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Deskripsi</label>
                        <p class="text-gray-700">${location.description}</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-900 mb-1">Dilaporkan pada</label>
                            <p class="text-gray-700">${new Date(location.reported_at).toLocaleString('id-ID')}</p>
                        </div>
                        
                        ${location.resolve_at ? `
                        <div>
                            <label class="block text-sm font-medium text-gray-900 mb-1">Diselesaikan pada</label>
                            <p class="text-gray-700">${new Date(location.resolve_at).toLocaleString('id-ID')}</p>
                        </div>` : ''}
                    </div>
                    ${location.evidence_image ? `
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-1">Bukti Foto</label>
                        <img src="https://nbqxohqnlurhpzlqybmg.supabase.co/storage/v1/object/public/pelaporan//${location.evidence_image}" 
                             class="w-full object-cover border border-gray-200 shadow-sm" 
                             alt="Evidence">
                    </div>` : ''}
                </div>
                <div class="mt-3 pt-3 border-t border-gray-200 flex justify-end gap-4">
                    <button onclick="closeDetailModal()" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 text-center" type="button">
                        Tutup
                    </button>
                    ${location.status === 'aktif' ? `
                    <button onclick="handleSubmit('laporan palsu')" class="text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center" type="submit">
                        Laporan Palsu
                    </button>
                    <button onclick="handleSubmit('terselesaikan')" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 text-center" type="submit">
                        Terselesaikan
                    </button>` : ''}
            </div>
        `;

        // Show the modal using Flowbite's modal API or fallback to manual toggle
        if (window.FlowbiteInstances && window.FlowbiteInstances.getInstance) {
            const modalInstance = window.FlowbiteInstances.getInstance('Modal', 'detail-modal');
            if (modalInstance) {
                modalInstance.show();
            } else {
                // Fallback: manually show modal
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        } else {
            // Fallback: manually show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    const handleSubmit = (value) => {
        document.getElementById('status').value = value;
    }

    // Function to close modal
    function closeDetailModal(event) {
        // If event is provided and it's not a backdrop click, return
        if (event && event.target !== event.currentTarget) return;

        const modal = document.getElementById('detail-modal');

        // Try to use Flowbite's modal API first
        if (window.FlowbiteInstances && window.FlowbiteInstances.getInstance) {
            const modalInstance = window.FlowbiteInstances.getInstance('Modal', 'detail-modal');
            if (modalInstance) {
                modalInstance.hide();
                return;
            }
        }

        // Fallback: manually hide modal
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modal = document.getElementById('detail-modal');
            if (!modal.classList.contains('hidden')) {
                closeDetailModal();
            }
        }
    });
</script>

<?php $this->endSection() ?>