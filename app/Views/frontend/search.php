<?= $this->extend('frontend/layouts/base') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<div class="bg-gray-100 py-3 px-4 text-sm border-b">
    <div class="container mx-auto">
        <a href="<?= base_url('/') ?>" class="text-blue-600 hover:underline">Home</a>
        <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
        <span class="text-gray-600 font-medium">Hasil Pencarian</span>
    </div>
</div>

<div class="container mx-auto px-4 py-6 md:py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
            <i class="fas fa-search text-blue-600 mr-2"></i>
            Hasil Pencarian
        </h1>
        <p class="text-gray-600">
            Menampilkan hasil untuk keyword: 
            <span class="font-semibold text-blue-600">"<?= esc($keyword) ?>"</span>
        </p>
    </div>
    
    <!-- Search Form -->
    <div class="bg-white rounded-xl shadow-md p-4 md:p-6 mb-8">
        <form action="<?= base_url('/search') ?>" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1">
                <input type="text" 
                       name="q" 
                       value="<?= esc($keyword) ?>"
                       placeholder="Cari judul, deskripsi, atau lokasi..."
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition">
            </div>
            <button type="submit" 
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition font-medium flex items-center justify-center">
                <i class="fas fa-search mr-2"></i>
                Cari
            </button>
        </form>
        
        <!-- Filter Pills (optional) -->
        <div class="flex flex-wrap gap-2 mt-4">
            <a href="<?= base_url('/search?q=' . urlencode($keyword)) ?>" 
               class="px-3 py-1.5 rounded-full text-xs sm:text-sm <?= !request()->getGet('category') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?> transition">
                Semua
            </a>
            <?php foreach ($categories as $cat): ?>
            <a href="<?= base_url('/search?q=' . urlencode($keyword) . '&category=' . $cat['id']) ?>" 
               class="px-3 py-1.5 rounded-full text-xs sm:text-sm <?= request()->getGet('category') == $cat['id'] ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?> transition">
                <?= esc($cat['name']) ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Results -->
    <?php if (!empty($listings)): ?>
        <p class="text-sm text-gray-500 mb-4">
            Ditemukan <span class="font-semibold text-blue-600"><?= $pager->getTotal() ?></span> listing
        </p>
        
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
        <div class="text-center py-12 bg-white rounded-xl shadow-md">
            <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
            <p class="text-xl text-gray-500 mb-2">Tidak ada hasil ditemukan</p>
            <p class="text-gray-400">Coba gunakan kata kunci lain atau filter yang berbeda</p>
            <a href="<?= base_url('/') ?>" 
               class="inline-block mt-6 bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition">
                Kembali ke Home
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>