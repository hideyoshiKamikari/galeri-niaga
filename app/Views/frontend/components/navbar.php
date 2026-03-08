<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-3 sm:px-4">
        <div class="flex justify-between items-center h-14 sm:h-16">
            <!-- Logo -->
            <a href="<?= base_url('/') ?>" class="text-xl sm:text-2xl font-bold text-blue-600">
                Galeri <span class="text-gray-800 hidden xs:inline">Niaga</span>
            </a>
            
            <?php 
            $currentUri = service('uri')->getPath();
            $isHome = ($currentUri == '' || $currentUri == '/');
            ?>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                <a href="<?= base_url('/') ?>" 
                   class="text-sm lg:text-base transition <?= $isHome ? 'text-blue-600 font-semibold' : 'text-gray-700 hover:text-blue-600' ?>">
                    Home
                </a>
                <a href="<?= base_url('/kategori') ?>" 
                   class="text-sm lg:text-base transition <?= strpos($currentUri, 'kategori') !== false ? 'text-blue-600 font-semibold' : 'text-gray-700 hover:text-blue-600' ?>">
                    Kategori
                </a>
                <a href="<?= base_url('/tentang') ?>" 
                   class="text-sm lg:text-base transition <?= strpos($currentUri, 'tentang') !== false ? 'text-blue-600 font-semibold' : 'text-gray-700 hover:text-blue-600' ?>">
                    Tentang
                </a>
                <a href="<?= base_url('/kontak') ?>" 
                   class="text-sm lg:text-base transition <?= strpos($currentUri, 'kontak') !== false ? 'text-blue-600 font-semibold' : 'text-gray-700 hover:text-blue-600' ?>">
                    Kontak
                </a>
            </div>
            
            <!-- Search Bar - Desktop -->
            <div class="hidden md:block">
                <form action="<?= base_url('/') ?>" method="GET" class="flex">
                    <input type="text" 
                           name="q" 
                           placeholder="Cari listing..." 
                           class="px-3 lg:px-4 py-1.5 lg:py-2 text-sm border border-gray-300 rounded-l-lg focus:outline-none focus:border-blue-500 w-40 lg:w-64"
                           value="<?= $_GET['q'] ?? '' ?>">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-3 lg:px-4 py-1.5 lg:py-2 rounded-r-lg hover:bg-blue-700 transition text-sm">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Mobile Buttons -->
            <div class="flex items-center space-x-2 md:hidden">
                <button onclick="toggleSearch()" class="text-gray-700 p-2 hover:text-blue-600 transition">
                    <i class="fas fa-search text-lg"></i>
                </button>
                <button onclick="toggleMenu()" class="text-gray-700 p-2 hover:text-blue-600 transition">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Search (hidden by default) -->
        <div id="mobileSearch" class="hidden md:hidden py-3 border-t border-gray-100">
            <form action="<?= base_url('/') ?>" method="GET" class="flex">
                <input type="text" 
                       name="q" 
                       placeholder="Cari listing..." 
                       class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-l-lg focus:outline-none focus:border-blue-500"
                       value="<?= $_GET['q'] ?? '' ?>">
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700 transition text-sm">
                    Cari
                </button>
            </form>
        </div>
        
        <!-- Mobile Menu (hidden by default) -->
        <div id="mobileMenu" class="hidden md:hidden py-3 border-t border-gray-100">
            <a href="<?= base_url('/') ?>" 
               class="block py-2 text-sm transition <?= $isHome ? 'text-blue-600 font-semibold' : 'text-gray-700 hover:text-blue-600' ?>">
                <i class="fas fa-home w-6 mr-2 text-gray-400"></i>
                Home
            </a>
            <a href="<?= base_url('/kategori') ?>" 
               class="block py-2 text-sm transition <?= strpos($currentUri, 'kategori') !== false ? 'text-blue-600 font-semibold' : 'text-gray-700 hover:text-blue-600' ?>">
                <i class="fas fa-tags w-6 mr-2 text-gray-400"></i>
                Kategori
            </a>
            <a href="<?= base_url('/tentang') ?>" 
               class="block py-2 text-sm transition <?= strpos($currentUri, 'tentang') !== false ? 'text-blue-600 font-semibold' : 'text-gray-700 hover:text-blue-600' ?>">
                <i class="fas fa-info-circle w-6 mr-2 text-gray-400"></i>
                Tentang
            </a>
            <a href="<?= base_url('/kontak') ?>" 
               class="block py-2 text-sm transition <?= strpos($currentUri, 'kontak') !== false ? 'text-blue-600 font-semibold' : 'text-gray-700 hover:text-blue-600' ?>">
                <i class="fas fa-phone-alt w-6 mr-2 text-gray-400"></i>
                Kontak
            </a>
        </div>
    </div>
</nav>

<script>
function toggleSearch() {
    const search = document.getElementById('mobileSearch');
    const menu = document.getElementById('mobileMenu');
    
    // Tutup menu kalo terbuka
    if (!menu.classList.contains('hidden')) {
        menu.classList.add('hidden');
    }
    
    // Toggle search
    search.classList.toggle('hidden');
}

function toggleMenu() {
    const menu = document.getElementById('mobileMenu');
    const search = document.getElementById('mobileSearch');
    
    // Tutup search kalo terbuka
    if (!search.classList.contains('hidden')) {
        search.classList.add('hidden');
    }
    
    // Toggle menu
    menu.classList.toggle('hidden');
}

// Tutup mobile menu saat klik di luar
document.addEventListener('click', function(event) {
    const menu = document.getElementById('mobileMenu');
    const search = document.getElementById('mobileSearch');
    const isClickInside = event.target.closest('nav');
    
    if (!isClickInside) {
        menu.classList.add('hidden');
        search.classList.add('hidden');
    }
});
</script>

<style>
/* Custom breakpoint untuk extra small devices */
@media (min-width: 400px) {
    .xs\:inline {
        display: inline;
    }
}
</style>