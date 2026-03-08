<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-xl shadow-md p-6 max-w-4xl mx-auto">
    <div class="mb-6 pb-4 border-b border-gray-200">
        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-plus-circle text-blue-500 mr-3"></i>
            Tambah Listing Baru
        </h3>
        <p class="text-sm text-gray-500 mt-1">Isi informasi produk/properti/jasa Anda</p>
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
    
    <form action="<?= route_to('admin.listings.store') ?>" method="POST">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div>
                <div class="mb-5">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-heading text-gray-400 mr-1"></i>
                        Judul Listing <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="<?= old('title') ?>"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition"
                           placeholder="Contoh: Rumah Minimalis 2 Lantai"
                           required>
                </div>
                
                <div class="mb-5">
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tags text-gray-400 mr-1"></i>
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" 
                            id="category_id" 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition"
                            required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= old('category_id') == $cat['id'] ? 'selected' : '' ?>>
                                <?= esc($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-5">
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-money-bill text-gray-400 mr-1"></i>
                        Harga
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500 font-medium">Rp</span>
                        <input type="text" 
                            name="price" 
                            id="price" 
                            value="<?= old('price') ?>"
                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition"
                            placeholder="0"
                            onkeyup="formatRupiah(this)">
                    </div>
                    <p class="text-xs text-gray-500 mt-1 flex items-center">
                        <i class="fas fa-info-circle mr-1"></i>
                        Kosongkan jika gratis / hubungi untuk harga
                    </p>
                </div>
                
                <div class="mb-5">
                    <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                        Lokasi
                    </label>
                    <input type="text" 
                           name="location" 
                           id="location" 
                           value="<?= old('location') ?>"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition"
                           placeholder="Contoh: Jakarta Selatan">
                </div>
                
                <div class="mb-5">
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-toggle-on text-gray-400 mr-1"></i>
                        Status
                    </label>
                    <select name="status" 
                            id="status" 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition">
                        <option value="active" selected>Active (Tampil di publik)</option>
                        <option value="inactive">Inactive (Tidak tampil)</option>
                    </select>
                </div>
            </div>
            
            <!-- Right Column -->
            <div>
                <div class="mb-5">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-align-left text-gray-400 mr-1"></i>
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="12"
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition"
                              placeholder="Jelaskan detail produk/properti/jasa Anda..."
                              required><?= old('description') ?></textarea>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
            <a href="<?= route_to('admin.listings') ?>" 
               class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg shadow-md hover:shadow-lg transition font-medium flex items-center">
                <i class="fas fa-save mr-2"></i>Simpan & Lanjut Upload Gambar
            </button>
        </div>
    </form>
</div>

<script>
function formatRupiah(angka) {
    // Hapus karakter selain angka
    let value = angka.value.replace(/[^\d]/g, '');
    
    // Format dengan titik sebagai pemisah ribuan
    if (value) {
        value = parseInt(value).toLocaleString('id-ID');
        angka.value = value;
    } else {
        angka.value = '';
    }
}

// Biar pas submit, value yang dikirim tanpa titik
document.querySelector('form').addEventListener('submit', function(e) {
    let priceInput = document.getElementById('price');
    if (priceInput.value) {
        // Hapus titik sebelum dikirim ke server
        priceInput.value = priceInput.value.replace(/\./g, '');
    }
});
</script>

<?= $this->endSection() ?>