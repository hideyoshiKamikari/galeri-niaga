<?= $this->extend('frontend/layouts/base') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<div class="bg-gray-100 py-3 px-4 text-sm border-b">
    <div class="container mx-auto">
        <a href="<?= base_url('/') ?>" class="text-blue-600 hover:underline">Home</a>
        <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
        <a href="<?= base_url('/kategori') ?>" class="text-blue-600 hover:underline">Kategori</a>
        <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
        <span class="text-gray-600 font-medium"><?= esc($category['name']) ?></span>
    </div>
</div>

<div class="container mx-auto px-4 py-8 md:py-12">
    <!-- Header Kategori -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
            Kategori: <?= esc($category['name']) ?>
        </h1>
        <p class="text-gray-600">
            Menampilkan <?= count($listings) ?> listing dalam kategori <?= esc($category['name']) ?>
        </p>
    </div>

    <!-- Listings Grid -->
    <?php if (!empty($listings)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
        <?php foreach ($listings as $item): ?>
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition group">
            <?php 
            $primaryImage = model('App\Models\ListingImageModel')
                          ->where('listing_id', $item['id'])
                          ->where('is_primary', true)
                          ->first();
            ?>
            <div class="relative pb-[60%] overflow-hidden">
                <img src="<?= $primaryImage ? base_url('uploads/listings/' . $primaryImage['image_path']) : 'https://via.placeholder.com/400x300' ?>" 
                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-300">
            </div>
            <div class="p-4">
                <h3 class="font-bold text-gray-800 mb-1 line-clamp-2">
                    <a href="<?= base_url('listing/' . $item['slug']) ?>" class="hover:text-blue-600 transition">
                        <?= esc($item['title']) ?>
                    </a>
                </h3>
                <p class="text-sm text-gray-500 mb-2 flex items-center">
                    <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>
                    <?= esc($item['location']) ?: 'Indonesia' ?>
                </p>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-lg font-bold text-blue-600">
                        <?= $item['price'] ? 'Rp ' . number_format($item['price'], 0, ',', '.') : 'Hubungi' ?>
                    </span>
                    <a href="<?= base_url('listing/' . $item['slug']) ?>" 
                       class="bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition text-sm">
                        Detail
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Pagination -->
    <?php if ($pager && $pager->getPageCount() > 1): ?>
    <div class="mt-8 flex justify-center">
        <div class="flex flex-wrap gap-1">
            <?= $pager->links() ?>
        </div>
    </div>
    <?php endif; ?>
    
    <?php else: ?>
    <div class="text-center py-12">
        <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
        <p class="text-xl text-gray-500">Belum ada listing di kategori ini</p>
        <a href="<?= base_url('/') ?>" class="inline-block mt-4 text-blue-600 hover:underline">
            Lihat semua listing
        </a>
    </div>
    <?php endif; ?>
</div>

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