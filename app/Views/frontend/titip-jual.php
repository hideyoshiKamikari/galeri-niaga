<?= $this->extend('frontend/layouts/base') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<div class="bg-gray-100 py-3 px-4 text-sm border-b">
    <div class="container mx-auto">
        <a href="<?= base_url('/') ?>" class="text-blue-600 hover:underline">Home</a>
        <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
        <span class="text-gray-600 font-medium">Titip Jual</span>
    </div>
</div>

<div class="container mx-auto px-4 py-8 md:py-12">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">
                Titip Jual di Galeri Niaga
            </h1>
            <p class="text-gray-600">
                Isi form di bawah untuk menitipkan produk/properti/jasa Anda. Gratis!
            </p>
        </div>
        
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
                <ul class="list-disc list-inside">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <!-- Form -->
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
            <form action="<?= base_url('titip-jual/store') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <!-- Nama -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           value="<?= old('name') ?>"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-400 transition"
                           placeholder="Masukkan nama lengkap"
                           required>
                </div>
                
                <!-- No WhatsApp -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        No. WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 bg-gray-100 border-2 border-r-0 border-gray-200 rounded-l-lg text-gray-600">
                            +62
                        </span>
                        <input type="tel" 
                               name="phone" 
                               value="<?= old('phone') ?>"
                               class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-r-lg focus:outline-none focus:border-blue-400 transition"
                               placeholder="81234567890"
                               required>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Contoh: 81234567890 (tanpa 0 di depan)</p>
                </div>
                
                <!-- Email (Opsional) -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email <span class="text-gray-400 text-xs">(opsional)</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           value="<?= old('email') ?>"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-400 transition"
                           placeholder="contoh@email.com">
                </div>
                
                <!-- Jenis Listing -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Jenis Listing <span class="text-red-500">*</span>
                    </label>
                    <select name="listing_type" 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-400 transition"
                            required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="product" <?= old('listing_type') == 'product' ? 'selected' : '' ?>>Produk (Barang)</option>
                        <option value="property" <?= old('listing_type') == 'property' ? 'selected' : '' ?>>Properti (Rumah, Tanah, Ruko)</option>
                        <option value="service" <?= old('listing_type') == 'service' ? 'selected' : '' ?>>Jasa (Servis, Kursus, dll)</option>
                    </select>
                </div>
                
                <!-- Deskripsi -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi Barang/Jasa <span class="text-red-500">*</span>
                    </label>
                    <textarea name="message" 
                              id="message"
                              rows="6"
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-400 transition"
                              placeholder="Jelaskan detail produk/properti/jasa Anda (merk, kondisi, tahun, lokasi, harga, dll)"
                              required><?= old('message') ?></textarea>
                </div>
                
                <!-- Upload Foto (Multiple, Opsional) -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Foto Produk <span class="text-gray-400 text-xs">(opsional, maks 5 foto, masing-masing 2MB)</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center" 
                        id="dropzone"
                        ondragover="event.preventDefault()"
                        ondrop="handleDrop(event)">
                        
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-600 mb-2">
                            Drag & drop foto di sini atau <span class="text-blue-600 font-semibold cursor-pointer hover:text-blue-700" onclick="document.getElementById('photos').click()">klik untuk memilih</span>
                        </p>
                        <p class="text-xs text-gray-500">Format: JPG, PNG (Maks 5 foto, 2MB per foto)</p>
                        
                        <input type="file" 
                            name="photos[]" 
                            id="photos" 
                            multiple 
                            accept="image/jpeg,image/png,image/jpg"
                            class="hidden"
                            onchange="handleFiles(this.files)">
                    </div>
                    
                    <!-- Preview Foto -->
                    <div id="previewContainer" class="grid grid-cols-2 md:grid-cols-5 gap-2 mt-3"></div>
                </div>
                
                <!-- Tombol Submit -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" 
                            class="flex-1 bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Permintaan
                    </button>
                    <a href="<?= base_url('/') ?>" 
                       class="flex-1 bg-gray-200 text-gray-700 font-bold py-3 px-6 rounded-lg hover:bg-gray-300 transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Info Tambahan -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="font-semibold text-blue-800 mb-2 flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                Informasi
            </h3>
            <ul class="text-sm text-blue-700 space-y-2">
                <li><i class="fas fa-check-circle mr-2"></i> Gratis, tidak dipungut biaya</li>
                <li><i class="fas fa-check-circle mr-2"></i> Admin akan menghubungi via WhatsApp maksimal 2x24 jam</li>
                <li><i class="fas fa-check-circle mr-2"></i> Foto produk membantu mempercepat proses</li>
            </ul>
        </div>
    </div>
</div>

<script>
let selectedFiles = [];

function handleFiles(files) {
    for (let i = 0; i < files.length; i++) {
        if (selectedFiles.length >= 5) {
            alert('Maksimal 5 foto');
            break;
        }
        
        const file = files[i];
        
        // Validasi type
        if (!file.type.match('image.*')) {
            alert('File ' + file.name + ' bukan gambar');
            continue;
        }
        
        // Validasi size
        if (file.size > 2 * 1024 * 1024) {
            alert('File ' + file.name + ' terlalu besar (maks 2MB)');
            continue;
        }
        
        selectedFiles.push(file);
        previewFile(file);
    }
    
    // Update input files
    updateFileInput();
}

function previewFile(file) {
    const reader = new FileReader();
    const previewContainer = document.getElementById('previewContainer');
    
    reader.onload = function(e) {
        const previewDiv = document.createElement('div');
        previewDiv.className = 'relative group';
        previewDiv.setAttribute('data-filename', file.name);
        
        previewDiv.innerHTML = `
            <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-200">
            <button type="button" 
                    onclick="removeFile('${file.name}')"
                    class="absolute top-1 right-1 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition hover:bg-red-600">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        previewContainer.appendChild(previewDiv);
    };
    
    reader.readAsDataURL(file);
}

function removeFile(filename) {
    selectedFiles = selectedFiles.filter(f => f.name !== filename);
    document.querySelector(`[data-filename="${filename}"]`).remove();
    updateFileInput();
}

function updateFileInput() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    document.getElementById('photos').files = dt.files;
}

function handleDrop(event) {
    event.preventDefault();
    const files = event.dataTransfer.files;
    handleFiles(files);
    document.getElementById('dropzone').classList.remove('border-blue-500', 'bg-blue-50');
}

// Drag & drop highlight
document.getElementById('dropzone').addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('border-blue-500', 'bg-blue-50');
});

document.getElementById('dropzone').addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('border-blue-500', 'bg-blue-50');
});

</script>

<?= $this->endSection() ?>