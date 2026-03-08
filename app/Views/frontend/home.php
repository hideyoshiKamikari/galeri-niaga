<?= $this->extend('frontend/layouts/base') ?>

<?= $this->section('content') ?>

<!-- Hero Section - Responsif -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12 md:py-20 px-4">
    <div class="container mx-auto text-center" data-aos="fade-up">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-3 md:mb-4 px-2">
            Temukan Produk & Jasa Terbaik
        </h1>
        <p class="text-base sm:text-lg md:text-xl mb-6 md:mb-8 opacity-90 px-4">
            Platform UMKM untuk memajukan usaha Anda
        </p>
        <a href="#listings" 
           class="bg-white text-blue-600 px-6 sm:px-8 py-2.5 sm:py-3 rounded-full font-semibold hover:bg-gray-100 transition inline-flex items-center text-sm sm:text-base">
            <i class="fas fa-search mr-2"></i>
            Lihat Listings
        </a>
    </div>
</section>

<!-- Featured Listings -->
<?php if (!empty($featured)): ?>
<section class="py-12 md:py-16 bg-white px-4">
    <div class="container mx-auto">
        <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8 md:mb-12" data-aos="fade-up">
            Listing Pilihan
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            <?php foreach ($featured as $item): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition" data-aos="fade-up">
                <?php 
                $primaryImage = model('App\Models\ListingImageModel')
                              ->where('listing_id', $item['id'])
                              ->where('is_primary', true)
                              ->first();
                ?>
                <div class="relative pb-[60%] sm:pb-[65%] overflow-hidden">
                    <img src="<?= $primaryImage ? base_url('uploads/listings/' . $primaryImage['image_path']) : 'https://via.placeholder.com/400x300' ?>" 
                         class="absolute inset-0 w-full h-full object-cover hover:scale-105 transition duration-300">
                </div>
                <div class="p-3 sm:p-4">
                    <span class="text-xs text-blue-600 font-semibold uppercase block mb-1">
                        <?= esc($item['category_name']) ?>
                    </span>
                    <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-1 line-clamp-2">
                        <?= esc($item['title']) ?>
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 mb-2 flex items-center">
                        <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                        <?= esc($item['location']) ?: 'Indonesia' ?>
                    </p>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2 hidden sm:block">
                        <?= esc(substr($item['description'], 0, 80)) ?>...
                    </p>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-lg sm:text-xl font-bold text-blue-600">
                            <?= $item['price'] ? 'Rp ' . number_format($item['price'], 0, ',', '.') : 'Hubungi' ?>
                        </span>
                        <a href="<?= base_url('listing/' . $item['slug']) ?>" 
                           class="bg-blue-600 text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg hover:bg-blue-700 transition text-xs sm:text-sm">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- All Listings -->
<section id="listings" class="py-12 md:py-16 bg-gray-50 px-4">
    <div class="container mx-auto">
        <h2 class="text-2xl sm:text-3xl font-bold text-center mb-6 md:mb-8" data-aos="fade-up">
            Semua Listing
        </h2>
        
        <!-- Categories Filter - Scroll horizontal di mobile -->
        <div class="overflow-x-auto pb-2 mb-6 md:mb-8" data-aos="fade-up">
            <div class="flex flex-nowrap md:flex-wrap gap-2 min-w-max md:min-w-0 md:justify-center">
                <a href="<?= base_url('/') ?>" 
                   class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm whitespace-nowrap <?= !request()->getGet('category') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?> transition">
                    Semua
                </a>
                <?php foreach ($categories as $cat): ?>
                <a href="<?= base_url('/?category=' . $cat['id']) ?>" 
                   class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm whitespace-nowrap <?= request()->getGet('category') == $cat['id'] ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?> transition">
                    <?= esc($cat['name']) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Search Info & Sorting -->
        <?php 
        $keyword = request()->getGet('q');
        $minPrice = request()->getGet('min');
        $maxPrice = request()->getGet('max');
        $sort = request()->getGet('sort') ?: 'terbaru';
        $selectedCategory = request()->getGet('category');
        ?>

        <?php if (!empty($keyword) || !empty($minPrice) || !empty($maxPrice)): ?>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center text-blue-800">
                    <i class="fas fa-search mr-2"></i>
                    <span>
                        Hasil pencarian untuk 
                        <?php if ($keyword): ?>
                            <strong>"<?= esc($keyword) ?>"</strong>
                        <?php endif; ?>
                        
                        <?php if ($minPrice || $maxPrice): ?>
                            dengan harga 
                            <?php if ($minPrice): ?>Rp <?= number_format($minPrice, 0, ',', '.') ?><?php endif; ?>
                            <?php if ($minPrice && $maxPrice): ?> - <?php endif; ?>
                            <?php if ($maxPrice): ?>Rp <?= number_format($maxPrice, 0, ',', '.') ?><?php endif; ?>
                        <?php endif; ?>
                    </span>
                </div>
                <a href="<?= base_url('/') ?>" class="text-sm text-blue-600 hover:underline">
                    <i class="fas fa-times mr-1"></i>Reset Filter
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Sorting & Filter Tambahan -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
            <div class="text-sm text-gray-600">
                Menampilkan <?= count($listings) ?> dari <?= $pager->getTotal() ?> listing
            </div>
            
            <div class="flex flex-wrap gap-2">
                <!-- Filter Harga (Dropdown) -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-sm flex items-center gap-1 hover:bg-gray-50">
                        <i class="fas fa-filter text-gray-400"></i>
                        Filter Harga
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    
                    <div x-show="open" 
                        @click.away="open = false"
                        class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 p-4 z-30">
                        <form action="<?= base_url('/') ?>" method="GET">
                            <?php if ($keyword): ?>
                                <input type="hidden" name="q" value="<?= esc($keyword) ?>">
                            <?php endif; ?>
                            <?php if ($selectedCategory): ?>
                                <input type="hidden" name="category" value="<?= $selectedCategory ?>">
                            <?php endif; ?>
                            <?php if ($sort): ?>
                                <input type="hidden" name="sort" value="<?= $sort ?>">
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label class="block text-xs text-gray-600 mb-1">Harga Minimal</label>
                                <input type="number" 
                                    name="min" 
                                    value="<?= $minPrice ?>"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                    placeholder="0">
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-xs text-gray-600 mb-1">Harga Maksimal</label>
                                <input type="number" 
                                    name="max" 
                                    value="<?= $maxPrice ?>"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                                    placeholder="1000000000">
                            </div>
                            
                            <button type="submit" 
                                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                                Terapkan Filter
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Sorting -->
                <select name="sort" 
                        onchange="window.location.href = '<?= base_url('/') ?>?sort=' + this.value + '&q=<?= urlencode($keyword ?? '') ?>&category=<?= $selectedCategory ?? '' ?>&min=<?= $minPrice ?? '' ?>&max=<?= $maxPrice ?? '' ?>'"
                        class="px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                    <option value="terbaru" <?= $sort == 'terbaru' ? 'selected' : '' ?>>Terbaru</option>
                    <option value="termurah" <?= $sort == 'termurah' ? 'selected' : '' ?>>Termurah</option>
                    <option value="termahal" <?= $sort == 'termahal' ? 'selected' : '' ?>>Termahal</option>
                </select>
            </div>
        </div>

        <!-- Listings Grid -->
        <?php if (!empty($listings)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-4">
            <?php foreach ($listings as $item): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition" data-aos="fade-up">
                <?php 
                $primaryImage = model('App\Models\ListingImageModel')
                              ->where('listing_id', $item['id'])
                              ->where('is_primary', true)
                              ->first();
                ?>
                <div class="relative pb-[60%] overflow-hidden">
                    <img src="<?= $primaryImage ? base_url('uploads/listings/' . $primaryImage['image_path']) : 'https://via.placeholder.com/400x300' ?>" 
                         class="absolute inset-0 w-full h-full object-cover hover:scale-105 transition duration-300">
                </div>
                <div class="p-2 sm:p-3">
                    <span class="text-xs text-blue-600 font-semibold block mb-1">
                        <?= esc($item['category_name']) ?>
                    </span>
                    <h3 class="text-sm sm:text-base font-bold text-gray-800 mb-1 line-clamp-2">
                        <?= esc($item['title']) ?>
                    </h3>
                    <p class="text-xs text-gray-500 mb-2 flex items-center">
                        <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                        <?= esc($item['location']) ?: 'Indonesia' ?>
                    </p>
                    <div class="flex items-center justify-between mt-1">
                        <span class="text-sm sm:text-base font-bold text-blue-600">
                            <?= $item['price'] ? 'Rp ' . number_format($item['price'], 0, ',', '.') : 'Hubungi' ?>
                        </span>
                        <a href="<?= base_url('listing/' . $item['slug']) ?>" 
                           class="text-blue-600 hover:text-blue-800 text-xs sm:text-sm">
                            <i class="fas fa-arrow-right"></i>
                            <span class="hidden sm:inline ml-1">Detail</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($pager && $pager->getPageCount() > 1): ?>
        <div class="mt-6 md:mt-8 flex justify-center">
            <div class="flex flex-wrap gap-1">
                <?= $pager->links() ?>
            </div>
        </div>
        <?php endif; ?>
        
        <?php else: ?>
        <div class="text-center py-8 md:py-12">
            <i class="fas fa-box-open text-4xl md:text-6xl text-gray-300 mb-3 md:mb-4"></i>
            <p class="text-base md:text-xl text-gray-500">Belum ada listing</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA Section - Responsif -->
<section class="bg-blue-600 text-white py-10 md:py-16 px-4">
    <div class="container mx-auto text-center" data-aos="fade-up">
        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold mb-3 md:mb-4">
            Mau Jual Produk atau Jasa?
        </h2>
        <p class="text-sm sm:text-base md:text-xl mb-4 md:mb-8 opacity-90">
            Titip jual di Galeri Niaga, gratis!
        </p>
        <a href="<?= base_url('/titip-jual') ?>" 
           class="bg-white text-blue-600 px-6 sm:px-8 py-2.5 sm:py-3 rounded-full font-semibold hover:bg-gray-100 transition inline-flex items-center text-sm sm:text-base">
            <i class="fas fa-store mr-2"></i>
            Titip Jual Sekarang
        </a>
    </div>
</section>

<!-- Custom CSS untuk line-clamp -->
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<?= $this->endSection() ?>