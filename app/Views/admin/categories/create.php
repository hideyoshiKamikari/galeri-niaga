<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-xl shadow-md p-6 max-w-2xl mx-auto">
    <div class="mb-6 pb-4 border-b border-gray-200">
        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-plus-circle text-blue-500 mr-3"></i>
            Tambah Kategori Baru
        </h3>
        <p class="text-sm text-gray-500 mt-1">Buat kategori baru untuk listing Anda</p>
    </div>
    
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-triangle text-red-500 mr-3 text-xl"></i>
                <span class="font-semibold">Mohon perbaiki error berikut:</span>
            </div>
            <ul class="list-disc list-inside ml-8">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li class="text-sm"><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form action="<?= route_to('admin.categories.store') ?>" method="POST">
        <?= csrf_field() ?>
        
        <div class="mb-5">
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-tag text-gray-400 mr-1"></i>
                Nama Kategori <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   value="<?= old('name') ?>"
                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition"
                   placeholder="Contoh: Rumah, Mobil, Elektronik"
                   required
                   autofocus>
            <p class="text-xs text-gray-500 mt-2">
                <i class="fas fa-info-circle"></i> 
                Slug akan dibuat otomatis dari nama (contoh: "Rumah Mewah" → "rumah-mewah")
            </p>
        </div>
        
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
            <a href="<?= route_to('admin.categories') ?>" 
               class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg shadow-md hover:shadow-lg transition font-medium flex items-center">
                <i class="fas fa-save mr-2"></i>Simpan Kategori
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>