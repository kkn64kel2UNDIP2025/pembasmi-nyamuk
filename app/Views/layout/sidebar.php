<aside id="application-sidebar-brand"
    class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full  transform hidden xl:block xl:translate-x-0 xl:end-auto xl:bottom-0 fixed xl:top-[20px] xl:left-auto top-0 left-0 with-vertical h-screen z-10 shrink-0  w-[270px] shadow-md xl:rounded-md rounded-none bg-white left-sidebar transition-all duration-300">
    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
    <div class="p-4 mt-5">

        <a class="text-nowrap flex justify-center gap-4 items-center">
            <img width="70" height="70"
                src="<?= base_url('Ikon-Anti-Nyamuk.png') ?>"
                alt="Logo Anti Nyamuk" />
            <div class="font-bold text-2xl">
                <span class="block">Pembasmi</span>
                <span class="text-blue-900">Nyamuk</span>
            </div>
        </a>

    </div>
    <div class="scroll-sidebar" data-simplebar="">
        <nav class=" w-full flex flex-col sidebar-nav px-4 mt-5">
            <ul id="sidebarnav" class="text-gray-600 text-sm">
                <li class="sidebar-item">
                    <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center justify-between relative rounded-md text-gray-900 w-full"
                        href="<?= base_url('') ?>">
                        <div class="flex items-center gap-2">
                            <i class="ti ti-map-route ps-2 text-2xl"></i> <span>Pemantauan</span>
                        </div>

                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link gap-3 py-2.5 my-1 text-base flex items-center justify-between relative rounded-md text-gray-900 w-full"

                        href="<?= base_url('pelaporan') ?>">
                        <div class="flex items-center gap-2">
                            <i class="ti ti-report ps-2 text-2xl"></i> <span>Pelaporan</span>
                        </div>
                    </a>
                </li>
            </ul>
        </nav>
</div>

</aside>