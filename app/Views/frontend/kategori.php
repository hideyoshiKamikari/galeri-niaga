<?= $this->extend('frontend/layouts/base') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<div class="bg-gray-100 py-3 px-4 text-sm border-b">
    <div class="container mx-auto">
        <a href="<?= base_url('/') ?>" class="text-blue-600 hover:underline">Home</a>
        <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
        <span class="text-gray-600 font-medium">Semua Kategori</span>
    </div>
</div>

<div class="container mx-auto px-4 py-8 md:py-12">
    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8 text-center">
        Jelajahi Kategori
    </h1>
    
    <?php if (!empty($categories)): ?>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
        <?php foreach ($categories as $cat): ?>
        <a href="<?= base_url('kategori/' . $cat['slug']) ?>" 
           class="bg-white rounded-xl shadow-md hover:shadow-xl transition p-6 text-center group">
            <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-600 transition">
                <i class="fas fa-tag text-2xl text-blue-600 group-hover:text-white transition"></i>
            </div>
            <h3 class="font-semibold text-gray-800 group-hover:text-blue-600 transition">
                <?= esc($cat['name']) ?>
            </h3>
            <p class="text-xs text-gray-500 mt-1">
                <?php 
                $count = model('App\Models\ListingModel')
                        ->where('category_id', $cat['id'])
                        ->where('status', 'active')
                        ->countAllResults();
                ?>
                <?= $count ?> listing
            </p>
        </a>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-12">
        <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
        <p class="text-xl text-gray-500">Belum ada kategori</p>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>