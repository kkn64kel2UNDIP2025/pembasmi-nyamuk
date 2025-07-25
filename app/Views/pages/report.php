<?php $this->extend('layout/template') ?>
<?php $this->section('content') ?>

<?php if(session('val_errors')): ?>
    <button data-modal-target="val-errors-modal" data-modal-toggle="val-errors-modal" class="hidden"></button>

    <div id="val-errors-modal" class="fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black/50">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-300">
                <h3 class="text-xl font-semibold text-gray-900">
                    Kesalahan Validasi
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-300 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="val-errors-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-2">
                <?php $i = 1 ?>
                <?php foreach(session('val_errors') as $error): ?>
                    <p class="text-base leading-relaxed text-gray-600">
                        <?= $i++ . '. ' . $error ?>
                    </p>
                <?php endforeach; ?>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-300 rounded-b">
                <button data-modal-hide="val-errors-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Oke, Saya setuju!</button>
            </div>
        </div>
    </div>
    </div>
<?php endif ?>

<main class="content">
    <div class="container-fluid p-0">
        <div class="row shadow-sm">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-gray-900 text-2xl font-semibold inline-block mb-6">Pelaporan Lokasi</h5>
                        <form class="mt-6" id="report-form" enctype="multipart/form-data" action="<?= base_url('pelaporan/laporan-baru') ?>" method="POST">
                            <div class="grid gap-6 mb-6 md:grid-cols-2">
                                <div>
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Pelapor</label>
                                    <input name="name" type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan nama" />
                                    <p id="name_error" class="hidden mt-2 text-xs text-red-600">Nama pelapor harus diisi</p>
                                </div>
                                <div>
                                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Nomor Telepon</label>
                                    <input type="tel" id="phone" name="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="08xxxxxxxxxx" />
                                    <p id="phone_error" class="hidden mt-2 text-xs text-red-600"></p>
                                </div>
                                <div>
                                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                                    <select id="category" name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?= $category['id'] ?>"><?= $category['category_name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <p id="category_error" class="hidden mt-2 text-xs text-red-600">Kategori harus dipilih</p>
                                </div>
                                <div>
                                    <label for="level" class="block mb-2 text-sm font-medium text-gray-900">Level</label>
                                    <select id="level" name="level" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                                        <option value="">Pilih kategori terlebih dahulu</option>
                                        <option value="1">1 - Sanget Rendah</option>
                                        <option value="2">2 - Rendah</option>
                                        <option value="3">3 - Sedang</option>
                                        <option value="4">4 - Tinggi</option>
                                        <option value="5">5 - Sangat Tinggi</option>
                                    </select>
                                    <p id="level_error" class="hidden mt-2 text-xs text-red-600">Level harus dipilih</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                                    <textarea id="description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Keterangan tambahan"></textarea>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-900">Lokasi Pelaporan</label>
                                    <div id="map" class="h-96 z-5"></div>
                                    <!-- Hidden inputs untuk menyimpan koordinat -->
                                    <input type="hidden" id="latitude" name="latitude" value="-6.962060" />
                                    <input type="hidden" id="longitude" name="longitude" value="110.44539" />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Bukti Gambar</label>
                                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
                                        aria-describedby="file_input_help"
                                        id="file_input"
                                        name="evidence_image"
                                        type="file"
                                        accept="image/jpeg,image/jpg,image/png,image/gif,image/webp">
                                    <p class="mt-1 text-sm text-gray-500" id="file_input_help">Hanya file gambar (PNG, JPG, JPEG, GIF, WebP). File di atas 1MB akan dikompress otomatis.</p>
                                    <p id="file_input_error" class="hidden mt-2 text-xs text-red-600"></p>
                                </div>
                            </div>
                            <button type="submit" class="w-full mt-5 text-md text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg py-2 text-center">
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

    // Image compression function with dynamic quality
    function compressImage(file, maxWidth = 1920, quality = 0.8) {
        return new Promise((resolve) => {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();
            
            img.onload = function() {
                // Calculate new dimensions
                let { width, height } = img;
                
                // More aggressive resize for very large files
                if (file.size > 10 * 1024 * 1024) { // > 10MB
                    maxWidth = 1280;
                } else if (file.size > 5 * 1024 * 1024) { // > 5MB
                    maxWidth = 1600;
                }
                
                if (width > maxWidth) {
                    height = (height * maxWidth) / width;
                    width = maxWidth;
                }
                
                canvas.width = width;
                canvas.height = height;
                
                // Draw and compress
                ctx.drawImage(img, 0, 0, width, height);
                
                canvas.toBlob(resolve, 'image/jpeg', quality);
            };
            
            img.src = URL.createObjectURL(file);
        });
    }

    // File upload validation and compression
    document.getElementById('file_input').addEventListener('change', async function(e) {
        const file = e.target.files[0];
        const fileInput = e.target;

        // Reset error message styling
        const errorElement = document.getElementById('file_input_error');
        errorElement.classList.add('hidden');
        errorElement.classList.remove('text-blue-600');
        errorElement.classList.add('text-red-600');

        if (file) {
            // Check file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            const fileType = file.type;
            const fileSize = file.size;

            // Validate file type
            if (!allowedTypes.includes(fileType)) {
                showError('file_input', 'Tipe file tidak diizinkan, hanya file gambar (PNG, JPG, JPEG, GIF, WebP) yang diperbolehkan.');
                fileInput.value = '';
                return;
            }

            // Compress if file size is over 1MB
            const compressThreshold = 1 * 1024 * 1024; // 1MB
            if (fileSize > compressThreshold) {
                try {
                    // Show compression message
                    const errorElement = document.getElementById('file_input_error');
                    errorElement.classList.remove('hidden', 'text-red-600');
                    errorElement.classList.add('text-blue-600');
                    errorElement.textContent = 'Mengkompress gambar...';
                    
                    // Determine compression quality based on file size
                    let quality = 0.8;
                    if (fileSize > 10 * 1024 * 1024) { // > 10MB
                        quality = 0.5;
                    } else if (fileSize > 5 * 1024 * 1024) { // > 5MB
                        quality = 0.6;
                    } else if (fileSize > 3 * 1024 * 1024) { // > 3MB
                        quality = 0.7;
                    }
                    
                    const compressedFile = await compressImage(file, undefined, quality);
                    
                    // Create a new File object with compressed data
                    const compressedFileObj = new File([compressedFile], file.name, {
                        type: 'image/jpeg',
                        lastModified: Date.now()
                    });
                    
                    // Replace the file in the input
                    const dt = new DataTransfer();
                    dt.items.add(compressedFileObj);
                    fileInput.files = dt.files;
                    
                    // Check if compressed file is still > 2MB and show warning
                    const compressedSize = compressedFile.size;
                    const warningThreshold = 2 * 1024 * 1024; // 2MB
                    
                    if (compressedSize > warningThreshold) {
                        // Show warning but allow upload
                        errorElement.classList.remove('text-blue-600');
                        errorElement.classList.add('text-yellow-600');
                        errorElement.textContent = `⚠️ Gambar dikompress dari ${(fileSize/1024/1024).toFixed(2)}MB menjadi ${(compressedSize/1024/1024).toFixed(2)}MB. File masih cukup besar, upload mungkin memerlukan waktu lebih lama.`;
                    } else {
                        // Show success message
                        errorElement.textContent = `✅ Gambar berhasil dikompress dari ${(fileSize/1024/1024).toFixed(2)}MB menjadi ${(compressedSize/1024/1024).toFixed(2)}MB`;
                    }
                    
                    showSuccess('file_input');
                } catch (error) {
                    console.error('Compression error:', error);
                    showError('file_input', 'Gagal mengkompress gambar. Silakan coba file lain.');
                    fileInput.value = '';
                    return;
                }
            } else {
                // File is valid and doesn't need compression
                showSuccess('file_input');
            }
        }
    });

    // Map Initialization
    var map = L.map('map')

    // CyclOSM Map Layer
    // var CyclOSM = L.tileLayer('https://{s}.tile-cyclosm.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png', {
    //     maxZoom: 20,
    //     minZoom: 18,
    //     attribution: '<a href="https://github.com/cyclosm/cyclosm-cartocss-style/releases" title="CyclOSM - Open Bicycle render">CyclOSM</a> | Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    // });

    var osmDefault = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            minZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

    osmDefault.addTo(map);

    // CyclOSM.on('tileerror', function(error) {
    //     console.warn('CyclOSM tile gagal dimuat, fallback ke OSM Default', error);
    //     // OSM Default Layer
        
        
    //     map.removeLayer(CyclOSM);
    //     osmDefault.addTo(map);
    // });

    map.setView([-6.962060, 110.44539], 18);

    // Marker
    const icon = L.icon({
        iconUrl: '<?= base_url('assets/icons/blue-marker.png') ?>',
        iconSize: [30, 30],
        iconAnchor: [15, 30],
    });

    let setLocation = L.marker([-6.962060, 110.44539], {
        icon: icon,
        draggable: true
    });

    setLocation.addTo(map);
    setLocation.bindPopup("Geser ikon / klik lokasi untuk memindahkan", {
        offset: L.point(0, -15)
    }).openPopup();

    // Locate user
    // map.locate({
    //   setView: false,
    //   maxZoom: 18,
    //   enableHighAccuracy: true,
    //   timeout: 10000
    // });

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
            // Check if there's any file error (but ignore compression success message and warnings)
            const fileError = document.getElementById('file_input_error');
            if (!fileError.classList.contains('hidden') && 
                fileError.classList.contains('text-red-600') && 
                !fileError.classList.contains('text-blue-600') &&
                !fileError.classList.contains('text-yellow-600')) {
                isValid = false;
            } else {
                showSuccess('file_input');
            }
        }
        
        // If all validations pass, submit the form
        if (isValid) {
            document.getElementById('level').removeAttribute('disabled');
            this.submit();
        }
    
    });
</script>

<?php $this->endSection() ?>