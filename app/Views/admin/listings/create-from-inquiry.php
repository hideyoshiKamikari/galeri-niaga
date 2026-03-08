<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-xl shadow-md p-6 max-w-4xl mx-auto">
    <div class="mb-6 pb-4 border-b border-gray-200">
        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-plus-circle text-blue-500 mr-3"></i>
            Buat Listing dari Inquiry
        </h3>
        <p class="text-sm text-gray-500 mt-1">
            Data dari inquiry oleh <strong><?= esc($inquiry['name']) ?></strong>
        </p>
    </div>
    
    <form action="<?= route_to('admin.listings.store') ?>" method="POST">
        <?= csrf_field() ?>
        
        <!-- Data dari inquiry (readonly) -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h4 class="font-semibold text-blue-800 mb-3">Data dari Inquiry</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-blue-600">Nama Pengirim</p>
                    <p class="font-medium"><?= esc($inquiry['name']) ?></p>
                </div>
                <div>
                    <p class="text-xs text-blue-600">No. WhatsApp</p>
                    <p class="font-medium"><?= esc($inquiry['phone']) ?></p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs text-blue-600">Deskripsi</p>
                    <p class="text-sm"><?= nl2br(esc($inquiry['message'])) ?></p>
                </div>
            </div>
        </div>
        
        <!-- Form Listing -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Listing <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 transition"
                           placeholder="Contoh: Rumah Minimalis 2 Lantai"
                           value="<?= esc($inquiry['message'] ? substr($inquiry['message'], 0, 50) : '') ?>"
                           required>
                </div>
                
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 transition">
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $defaultCategory == $cat['id'] ? 'selected' : '' ?>>
                                <?= esc($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Harga
                    </label>
                    <input type="text" 
                           name="price" 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 transition"
                           placeholder="500000000">
                </div>
                
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Lokasi
                    </label>
                    <input type="text" 
                           name="location" 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 transition"
                           placeholder="Contoh: Jakarta Selatan">
                </div>
                
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Status
                    </label>
                    <select name="status" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 transition">
                        <option value="active">Active (Tampil di publik)</option>
                        <option value="inactive">Inactive (Tidak tampil)</option>
                    </select>
                </div>
            </div>
            
            <div>
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" 
                              rows="12"
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 transition"
                              required><?= esc($inquiry['message']) ?></textarea>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 mt-6">
            <a href="<?= base_url('admin/inquiries') ?>" 
               class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg shadow-md hover:shadow-lg transition font-medium flex items-center">
                <i class="fas fa-save mr-2"></i>Simpan Listing
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>