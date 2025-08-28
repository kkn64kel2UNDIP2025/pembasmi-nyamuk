<?php $this->extend('layout/template') ?>
<?php $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="row shadow-md card card-body">
                <h2 class="text-gray-900 text-2xl font-semibold mb-6">Tentang Aplikasi</h2>
                <p class="">
                    Aplikasi SI JEMPANG
                    berfungsi untuk memudahkan dalam mencatat dan
                    mengelola data perkembangan jentik nyamuk secara digital
                    dan sistematis. Aplikasi ini membantu mengelola data
                    aktivitas jentik nyamuk sehingga dapat menghasilkan
                    laporan yang mendukung pengambilan keputusan dalam
                    upaya pemberantasan sarang nyamuk dan pencegahan
                    penyakit seperti Demam Berdarah Dengue (DBD). Aplikasi
                    ini juga mendukung partisipasi masyarakat dalam
                    pengendalian sarang nyamuk sehingga dapat menurunkan
                    risiko penyebaran DBD secara lebih efisien.
                </p>

                <h5 class="text-gray-900 text-xl font-semibold mb-3 mt-6">Cara Penggunaan</h5>
                <p class="mb-2">Ketika Anda ingin melaporkan tempat atau lokasi yang menjadi potensi jentik nyamuk, ikuti langkah-langkah berikut</p>
                <ol class="list-decimal list-inside">
                    <li>Buka halaman pelaporan dengan menekan pelaporan di bagian samping (sidebar)</li>
                    <li>Isi semua data yang diperlukan terutama lokasi pelaporan dan bukti gambar</li>
                    <li>Untuk mengisi lokasi pelaporan, pelapor dapat menggeser atau menekan lokasi yang akan dilaporkan</li>
                    <li>Bukti gambar dapat diunggah, baik dengan upload file atau memfoto secara langsung</li>
                    <li>Jika sudah, kirim laporan dengan menekan tombol kirim laporan di halaman paling bawah</li>
                    <li>Setelah itu, lokasi pelaporan akan dapat dilihat oleh seluruh pengguna</li>
                    <li>Untuk melihat keterangan dari lokasi, dapat dengan langsung menekan ikonnya</li>
                    <li>Kemudian, jika ingin mengetahui detail secara lebih lanjut dapat menekan tombol lihat detail</li>
                    <li>Setelah itu, keseluruhan detail akan tampil</li>
                </ol>

                <h5 class="text-gray-900 text-xl font-semibold mb-3 mt-6">Link Aplikasi</h5>
                <img class="w-60" src="<?= base_url('link-aplikasi-si-jempang.png') ?>" alt="Link Aplikasi SI JEMPANG">
            </div>
        </div>
    </div>
    </div>
    <?= $this->include('layout/footer') ?>
    </div>
</main>

<?php $this->endSection() ?>