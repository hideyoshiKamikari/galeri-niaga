<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-xl shadow-md p-6 max-w-4xl mx-auto">
    <div class="mb-6 pb-4 border-b border-gray-200">
        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-edit text-blue-500 mr-3"></i>
            Edit Listing
        </h3>
        <p class="text-sm text-gray-500 mt-1">Ubah informasi listing "<?= esc($listing['title']) ?>"</p>
    </div>
    
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
            <span><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>

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
    
    <form action="<?= route_to('admin.listings.update', $listing['id']) ?>" method="POST">
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
                           value="<?= old('title', $listing['title']) ?>"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition"
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
                            <option value="<?= $cat['id'] ?>" <?= (old('category_id', $listing['category_id']) == $cat['id']) ? 'selected' : '' ?>>
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
                            value="<?= old('price', $listing['price'] ? number_format($listing['price'], 0, ',', '.') : '') ?>"
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
                           value="<?= old('location', $listing['location']) ?>"
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
                        <option value="active" <?= old('status', $listing['status']) == 'active' ? 'selected' : '' ?>>Active (Tampil di publik)</option>
                        <option value="inactive" <?= old('status', $listing['status']) == 'inactive' ? 'selected' : '' ?>>Inactive (Tidak tampil)</option>
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
                              required><?= old('description', $listing['description']) ?></textarea>
                </div>
            </div>
        </div>
        
        <!-- Image Upload Section -->
        <div class="mt-6 pt-4 border-t border-gray-200">
            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-images text-blue-500 mr-2"></i>
                Gambar Listing
            </h4>
            
            <!-- Upload Area -->
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 mb-4 hover:border-blue-500 transition cursor-pointer" 
                id="dropzone">
                <div class="text-center">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                    <p class="text-sm text-gray-600 mb-2">
                        Drag & drop gambar di sini atau <span class="text-blue-500 font-semibold hover:text-blue-600">klik untuk memilih</span>
                    </p>
                    <p class="text-xs text-gray-500">Format: JPG, PNG (Maks 2MB per gambar)</p>
                    <input type="file" 
                        id="fileInput" 
                        name="images[]" 
                        multiple 
                        accept="image/jpeg,image/png,image/jpg"
                        class="hidden">
                </div>
            </div>
            
            <!-- Upload Progress -->
            <div id="progressContainer" class="hidden mb-4">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm text-gray-600">Uploading...</span>
                    <span class="text-sm text-gray-600" id="progressPercent">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                        id="progressBar" 
                        style="width: 0%"></div>
                </div>
            </div>
            
            <!-- Image Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4" id="imageGrid">
                <?php if (!empty($images)): ?>
                    <?php foreach ($images as $img): ?>
                    <div class="relative group image-item" data-id="<?= $img['id'] ?>">
                        <img src="<?= base_url('uploads/listings/' . $img['image_path']) ?>" 
                            class="w-full h-32 object-cover rounded-lg border-2 <?= $img['is_primary'] ? 'border-green-500 ring-2 ring-green-200' : 'border-gray-200' ?>">
                        
                        <?php if ($img['is_primary']): ?>
                            <span class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full flex items-center">
                                <i class="fas fa-star mr-1 text-xs"></i> Primary
                            </span>
                        <?php endif; ?>
                        
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition rounded-lg flex items-center justify-center space-x-2">
                            <?php if (!$img['is_primary']): ?>
                                <button type="button" 
                                        class="set-primary-btn bg-green-500 text-white p-2 rounded-full hover:bg-green-600 transition"
                                        data-id="<?= $img['id'] ?>"
                                        title="Jadikan Primary">
                                    <i class="fas fa-star text-xs"></i>
                                </button>
                            <?php endif; ?>
                            <button type="button" 
                                    class="delete-image-btn bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition"
                                    data-id="<?= $img['id'] ?>"
                                    title="Hapus">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <!-- Empty State -->
            <?php if (empty($images)): ?>
            <div class="text-center py-8 text-gray-500" id="emptyState">
                <i class="fas fa-images text-4xl mb-3"></i>
                <p>Belum ada gambar. Upload gambar untuk listing ini.</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 mt-6">
            <a href="<?= route_to('admin.listings') ?>" 
               class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg shadow-md hover:shadow-lg transition font-medium flex items-center">
                <i class="fas fa-save mr-2"></i>Update Listing
            </button>
        </div>
    </form>
</div>

<script>
function formatRupiah(angka) {
    let value = angka.value.replace(/[^\d]/g, '');
    if (value) {
        value = parseInt(value).toLocaleString('id-ID');
        angka.value = value;
    } else {
        angka.value = '';
    }
}

document.querySelector('form').addEventListener('submit', function(e) {
    let priceInput = document.getElementById('price');
    if (priceInput.value) {
        priceInput.value = priceInput.value.replace(/\./g, '');
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('fileInput');
    const progressContainer = document.getElementById('progressContainer');
    const progressBar = document.getElementById('progressBar');
    const progressPercent = document.getElementById('progressPercent');
    const listingId = <?= $listing['id'] ?>;
    
    console.log('Dropzone:', dropzone);
    console.log('FileInput:', fileInput);
    
    if (!dropzone || !fileInput) {
        console.error('Element tidak ditemukan!');
        return;
    }
    
    // Trigger file input - klik area manapun di dropzone
    dropzone.addEventListener('click', function(e) {
        console.log('Dropzone clicked');
        fileInput.click();
    });
    
    // Drag & drop handlers
    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('border-blue-500', 'bg-blue-50');
    });
    
    dropzone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropzone.classList.remove('border-blue-500', 'bg-blue-50');
    });
    
    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('border-blue-500', 'bg-blue-50');
        
        const files = e.dataTransfer.files;
        console.log('Files dropped:', files);
        
        if (files.length > 0) {
            uploadFiles(files);
        }
    });
    
    // File input change
    fileInput.addEventListener('change', function() {
        console.log('File input changed:', this.files);
        if (this.files.length > 0) {
            uploadFiles(this.files);
        }
    });
    
    // Upload function
   function uploadFiles(files) {
    const formData = new FormData();
    
    // AMBIL CSRF TOKEN DARI FORM
    const csrfToken = document.querySelector('input[name="<?= csrf_token() ?>"]').value;
    formData.append('<?= csrf_token() ?>', csrfToken);
    
    for (let i = 0; i < files.length; i++) {
        formData.append('images[]', files[i]);
    }
        
        // Show progress
        progressContainer.classList.remove('hidden');
        
        const xhr = new XMLHttpRequest();
        
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percent = (e.loaded / e.total) * 100;
                progressBar.style.width = percent + '%';
                progressPercent.textContent = Math.round(percent) + '%';
            }
        });
        
        xhr.addEventListener('load', function() {
            console.log('XHR Status:', xhr.status);
            console.log('XHR Response:', xhr.responseText);
            
            progressContainer.classList.add('hidden');
            progressBar.style.width = '0%';
            progressPercent.textContent = '0%';
            
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + (response.error || 'Gagal upload'));
                        if (response.errors) {
                            console.log('Errors:', response.errors);
                        }
                    }
                } catch (e) {
                    alert('Error parsing response: ' + e.message);
                }
            } else {
                alert('HTTP Error: ' + xhr.status);
            }
        });
        
        xhr.addEventListener('error', function() {
            alert('Network error - koneksi terputus');
            progressContainer.classList.add('hidden');
        });
        
        xhr.open('POST', '<?= base_url('admin/listings/upload') ?>/' + listingId);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send(formData);
    }
    
    // Set primary image
    document.querySelectorAll('.set-primary-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const imageId = this.dataset.id;
            
            fetch('<?= base_url('admin/listings/set-primary') ?>/' + imageId, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });
    });
    
    // Delete image
    // Delete image - PAKE POST
document.querySelectorAll('.delete-image-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        if (!confirm('Yakin ingin menghapus gambar ini?')) return;
        
        const imageId = this.dataset.id;
        
        const formData = new FormData();
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
        
        fetch('<?= base_url('admin/listings/delete-image') ?>/' + imageId, {
            method: 'POST', // GANTI JADI POST
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(err => {
            alert('Error: ' + err.message);
        });
    });
});
});
</script>

<?= $this->endSection() ?>