<?php $this->extend('layout/template') ?>
<?php $this->section('content') ?>


<main class="content">
    <div class="container-fluid p-0">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-gray-900 text-2xl font-semibold inline-block mb-6">Pelaporan Lokasi</h5>
                        <form class="mt-6" id="report-form" enctype="multipart/form-data" action="<?= base_url('pelaporan/laporan-baru') ?>" method="POST">
                            <div class="grid gap-6 mb-6 md:grid-cols-2">
                                <div>
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Pelapor</label>
                                    <input name="name" type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Masukkan nama" />
                                    <p id="name_error" class="hidden mt-2 text-xs text-red-600 dark:text-red-400">Nama pelapor harus diisi</p>
                                </div>
                                <div>
                                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Telepon</label>
                                    <input type="tel" id="phone" name="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="08xxxxxxxxxx" />
                                    <p id="phone_error" class="hidden mt-2 text-xs text-red-600 dark:text-red-400"></p>
                                </div>
                                <div>
                                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                                    <select id="category" name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?= $category['id'] ?>"><?= $category['category_name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <p id="category_error" class="hidden mt-2 text-xs text-red-600 dark:text-red-400">Kategori harus dipilih</p>
                                </div>
                                <div>
                                    <label for="level" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Level</label>
                                    <select id="level" name="level" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:text-white cursor-not-allowed" disabled>
                                        <option value="">Pilih kategori terlebih dahulu</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <p id="level_error" class="hidden mt-2 text-xs text-red-600 dark:text-red-400">Level harus dipilih</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                                    <textarea id="description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Keterangan tambahan"></textarea>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lokasi Pelaporan</label>
                                    <div id="map" class="h-96 z-5"></div>
                                    <!-- Hidden inputs untuk menyimpan koordinat -->
                                    <input type="hidden" id="latitude" name="latitude" value="-6.962060" />
                                    <input type="hidden" id="longitude" name="longitude" value="110.44539" />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Bukti Gambar</label>
                                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                        aria-describedby="file_input_help"
                                        id="file_input"
                                        name="evidence_image"
                                        type="file"
                                        accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                        >
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Hanya file gambar (PNG, JPG, JPEG, GIF, WebP). Maksimal 5MB.</p>
                                    <p id="file_input_error" class="hidden mt-2 text-xs text-red-600 dark:text-red-500"></p>
                                </div>
                            </div>
                            <button type="submit" class="w-full mt-5 text-md text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Kirim Laporan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    let categories = [];

    // Helper functions for validation
    function showError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const errorElement = document.getElementById(fieldId + '_error');
        
        field.classList.remove('border-gray-300', 'focus:border-blue-500', 'border-green-500');
        field.classList.add('border-red-500', 'focus:border-red-500');
        errorElement.classList.remove('hidden');
        errorElement.textContent = message;
    }

    function hideError(fieldId) {
        const field = document.getElementById(fieldId);
        const errorElement = document.getElementById(fieldId + '_error');
        
        field.classList.remove('border-red-500', 'focus:border-red-500');
        field.classList.add('border-gray-300', 'focus:border-blue-500');
        errorElement.classList.add('hidden');
    }

    function showSuccess(fieldId) {
        const field = document.getElementById(fieldId);
        field.classList.remove('border-gray-300', 'border-red-500', 'focus:border-red-500');
        field.classList.add('border-green-500', 'focus:border-blue-500');
        hideError(fieldId);
    }

    // Load categories from JSON file
    fetch('<?= base_url('assets/js/categories.json') ?>')
        .then(response => response.json())
        .then(data => {
            categories = data;
        })
        .catch(error => {
            console.error('Error loading categories:', error);
        });

    // Real-time validation for name
    document.getElementById('name').addEventListener('blur', function() {
        const name = this.value.trim();
        if (!name) {
            showError('name', 'Nama pelapor harus diisi');
        } else {
            showSuccess('name');
        }
    });

    // Real-time validation for phone
    document.getElementById('phone').addEventListener('blur', function() {
        const phone = this.value.trim();
        const phoneRegex = /^[0-9]{10,13}$/;
        if (phone && !phoneRegex.test(phone)) {
            showError('phone', 'Format nomor telepon tidak valid (10-13 digit)');
        } else if (phone) {
            showSuccess('phone');
        } else {
            hideError('phone');
        }
    });

    // Real-time validation for category
    document.getElementById('category').addEventListener('change', function() {
        if (this.value) {
            showSuccess('category');
        } else {
            showError('category', 'Kategori harus dipilih');
        }
        
        // ...existing category logic...
        const selectedCategoryId = this.value;
        const levelSelect = document.getElementById('level');

        // Find the selected category
        const selectedCategory = categories.find(cat => cat.id === selectedCategoryId);

        if (selectedCategory) {
            if (selectedCategory.level === null) {
                // Enable select for "Lainnya" category
                levelSelect.value = '';
                levelSelect.classList.remove('bg-gray-100', 'cursor-not-allowed');
                levelSelect.classList.add('bg-gray-50', 'focus:ring-blue-500', 'focus:border-blue-500');
                levelSelect.removeAttribute('disabled');
                levelSelect.options[0].text = 'Pilih level';
                hideError('level');
            } else {
                // Set the level value and make it disabled for other categories
                levelSelect.value = selectedCategory.level;
                levelSelect.classList.remove('bg-gray-50', 'focus:ring-blue-500', 'focus:border-blue-500');
                levelSelect.classList.add('bg-gray-100', 'cursor-not-allowed');
                levelSelect.setAttribute('disabled', true);
                showSuccess('level');
            }
        } else {
            // Reset if no category selected
            levelSelect.value = '';
            levelSelect.options[0].text = 'Pilih kategori terlebih dahulu';
            levelSelect.classList.remove('bg-gray-50', 'focus:ring-blue-500', 'focus:border-blue-500');
            levelSelect.classList.add('bg-gray-100', 'cursor-not-allowed');
            levelSelect.setAttribute('disabled', true);
            hideError('level');
        }
    });

    // Real-time validation for level
    document.getElementById('level').addEventListener('change', function() {
        if (this.value) {
            showSuccess('level');
        } else {
            showError('level', 'Level harus dipilih');
        }
    });

    // File upload validation
    document.getElementById('file_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileInput = e.target;

        if (file) {
            // Check file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            const fileType = file.type;

            // Check file size (5MB = 5 * 1024 * 1024 bytes)
            const maxSize = 5 * 1024 * 1024;
            const fileSize = file.size;

            // Validate file type
            if (!allowedTypes.includes(fileType)) {
                showError('file_input', 'Tipe file tidak diizinkan, hanya file gambar (PNG, JPG, JPEG, GIF, WebP) yang diperbolehkan.');
                fileInput.value = '';
                return;
            }

            // Validate file size
            if (fileSize > maxSize) {
                showError('file_input', 'Ukuran file terlalu besar. Maksimal 5MB.');
                fileInput.value = '';
                return;
            }

            // File is valid
            showSuccess('file_input');
        }
    });

    // Map Initialization
    var map = L.map('map')

    // OSN Layer
    var CyclOSM = L.tileLayer('https://{s}.tile-cyclosm.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png', {
        maxZoom: 20,
        minZoom: 19,
        attribution: '<a href="https://github.com/cyclosm/cyclosm-cartocss-style/releases" title="CyclOSM - Open Bicycle render">CyclOSM</a> | Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    CyclOSM.addTo(map);
    map.setView([-6.962060, 110.44539], 19);

    // Marker
    const icon = L.icon({
        iconUrl: '<?= base_url('assets/icons/green-marker.png') ?>',
        iconSize: [30, 30],
        iconAnchor: [15, 30],
    });

    let setLocation = L.marker([-6.962060, 110.44539], {
        icon: icon,
        draggable: true
    });

    setLocation.addTo(map);
    setLocation.bindPopup("Geser / klik untuk memindahkan lokasi", {
        offset: L.point(0, -15)
    }).openPopup();

    // Function to update coordinates
    function updateCoordinates(lat, lng) {
        // Update hidden inputs
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        latInput.value = lat;
        lngInput.value = lng;
    }

    // Event listener when marker is dragged
    setLocation.on('dragend', function(e) {
        const marker = e.target;
        const position = marker.getLatLng();

        updateCoordinates(position.lat, position.lng);
    });

    // Event listener when map is clicked
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        // Move marker to clicked position
        setLocation.setLatLng([lat, lng]);

        updateCoordinates(lat, lng);
    });

    // Form submission validation
    document.getElementById('report-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        let isValid = true;

        // Get form data
        const name = document.getElementById('name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const category = document.getElementById('category').value;
        const level = document.getElementById('level').value;
        const latitude = document.getElementById('latitude').value;
        const longitude = document.getElementById('longitude').value;
        const fileInput = document.getElementById('file_input');

        // Validate name
        if (!name) {
            showError('name', 'Nama pelapor harus diisi');
            isValid = false;
        } else {
            showSuccess('name');
        }
        
        // Validate phone (optional but if filled must be valid)
        if (phone) {
            const phoneRegex = /^[0-9]{10,13}$/;
            if (!phoneRegex.test(phone)) {
                showError('phone', 'Format nomor telepon tidak valid (10-13 digit)');
                isValid = false;
            } else {
                showSuccess('phone');
            }
        }
        
        // Validate category
        if (!category) {
            showError('category', 'Kategori harus dipilih');
            isValid = false;
        } else {
            showSuccess('category');
        }
        
        // Validate level
        if (!level) {
            showError('level', 'Level harus dipilih');
            isValid = false;
        } else {
            showSuccess('level');
        }
        
        // Validate file
        if (!fileInput.files[0]) {
            showError('file_input', 'Bukti gambar harus diupload');
            isValid = false;
        } else {
            // Check if there's any file error
            const fileError = document.getElementById('file_input_error');
            if (!fileError.classList.contains('hidden')) {
                isValid = false;
            } else {
                showSuccess('file_input');
            }
        }
        
        // If all validations pass, submit the form
        if (isValid) {
            this.submit();
        }
    
    });
</script>

<?php $this->endSection() ?>