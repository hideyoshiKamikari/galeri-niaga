<?= $this->extend('frontend/layouts/base') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<div class="bg-gray-100 py-3 px-4 text-sm border-b">
    <div class="container mx-auto">
        <a href="<?= base_url('/') ?>" class="text-blue-600 hover:underline">Home</a>
        <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
        <a href="<?= base_url('/?category=' . $listing['category_id']) ?>" class="text-blue-600 hover:underline">
            <?= esc($listing['category_name']) ?>
        </a>
        <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
        <span class="text-gray-600 font-medium"><?= esc($listing['title']) ?></span>
    </div>
</div>

<div class="container mx-auto px-4 py-6 md:py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
        <!-- Left Column - Images -->
        <div class="lg:col-span-2">
            <!-- Main Image -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-4">
                <div class="relative pb-[60%] md:pb-[56.25%] bg-gray-100">
                    <?php 
                    $primaryImage = array_filter($images, fn($img) => $img['is_primary']);
                    $primaryImage = !empty($primaryImage) ? array_shift($primaryImage) : ($images[0] ?? null);
                    $mainImage = $primaryImage ? base_url('uploads/listings/' . $primaryImage['image_path']) : 'https://via.placeholder.com/800x600?text=No+Image';
                    ?>
                    <img src="<?= $mainImage ?>" 
                         class="absolute inset-0 w-full h-full object-contain cursor-zoom-in"
                         onclick="openModal(0)"
                         id="mainImage">
                </div>
                
                <!-- Thumbnails -->
                <?php if (count($images) > 1): ?>
                <div class="p-3 border-t border-gray-200 overflow-x-auto">
                    <div class="flex space-x-2">
                        <?php foreach ($images as $index => $img): ?>
                        <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 <?= $img['is_primary'] ? 'border-blue-600' : 'border-gray-200' ?> hover:border-blue-400 cursor-pointer transition thumbnail" 
                             onclick="changeImage(<?= $index ?>)">
                            <img src="<?= base_url('uploads/listings/' . $img['image_path']) ?>" 
                                 class="w-full h-full object-cover">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Right Column - Info & CTA -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-20">
                <!-- Kategori -->
                <div class="mb-4">
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-tag mr-1"></i>
                        <?= esc($listing['category_name']) ?>
                    </span>
                </div>
                
                <!-- Title -->
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">
                    <?= esc($listing['title']) ?>
                </h1>
                
                <!-- Price -->
                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-1">Harga</p>
                    <p class="text-3xl md:text-4xl font-bold text-blue-600">
                        <?= $listing['price'] ? 'Rp ' . number_format($listing['price'], 0, ',', '.') : 'Hubungi untuk harga' ?>
                    </p>
                </div>
                
                <!-- Location -->
                <div class="flex items-start mb-4 text-gray-600">
                    <i class="fas fa-map-marker-alt text-gray-400 mt-1 mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-500">Lokasi</p>
                        <p class="font-medium"><?= esc($listing['location']) ?: 'Indonesia' ?></p>
                    </div>
                </div>
                
                <!-- Posted Date -->
                <div class="flex items-start mb-6 text-gray-600">
                    <i class="far fa-calendar-alt text-gray-400 mt-1 mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-500">Diposting</p>
                        <p class="font-medium"><?= date('d F Y', strtotime($listing['created_at'])) ?></p>
                    </div>
                </div>
                
                <!-- CTA WhatsApp -->
                <div class="border-t border-gray-200 pt-6 mt-2">
                    <?php 
                    $phone = '6281234567890'; // Ganti dengan nomor lo
                    $message = "Halo, saya tertarik dengan *" . $listing['title'] . "*\n";
                    $message .= "Link: " . current_url() . "\n\n";
                    $message .= "Apakah masih tersedia?";
                    $waLink = "https://wa.me/" . $phone . "?text=" . rawurlencode($message);
                    ?>
                    
                    <a href="<?= $waLink ?>" 
                       target="_blank"
                       class="bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-6 rounded-xl w-full flex items-center justify-center transition text-lg shadow-md hover:shadow-lg">
                        <i class="fab fa-whatsapp mr-3 text-2xl"></i>
                        Chat via WhatsApp
                    </a>
                    <p class="text-xs text-gray-500 text-center mt-3">
                        <i class="fas fa-clock mr-1"></i>
                        Respon cepat, harga nego
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Description Section -->
    <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-align-left text-blue-600 mr-2"></i>
            Deskripsi
        </h3>
        <div class="prose max-w-none text-gray-700 whitespace-pre-line">
            <?= nl2br(esc($listing['description'])) ?>
        </div>
    </div>
    
    <!-- Related Listings -->
    <?php if (!empty($related)): ?>
    <div class="mt-8">
        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-list text-blue-600 mr-2"></i>
            Listing Terkait
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
            <?php foreach ($related as $item): ?>
            <a href="<?= base_url('listing/' . $item['slug']) ?>" class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                <?php 
                $relImage = model('App\Models\ListingImageModel')
                          ->where('listing_id', $item['id'])
                          ->where('is_primary', true)
                          ->first();
                ?>
                <div class="relative pb-[60%]">
                    <img src="<?= $relImage ? base_url('uploads/listings/' . $relImage['image_path']) : 'https://via.placeholder.com/400x300' ?>" 
                         class="absolute inset-0 w-full h-full object-cover">
                </div>
                <div class="p-2">
                    <p class="text-xs text-blue-600"><?= esc($item['category_name']) ?></p>
                    <p class="text-sm font-semibold truncate"><?= esc($item['title']) ?></p>
                    <p class="text-xs font-bold text-blue-600 mt-1">
                        <?= $item['price'] ? 'Rp ' . number_format($item['price'], 0, ',', '.') : 'Hubungi' ?>
                    </p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Modal Zoom Image - FIXED VERSION -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden">
    <!-- Tombol Close (X) -->
    <div class="absolute top-4 right-4 text-white text-3xl cursor-pointer hover:text-gray-300 z-20" id="closeModalBtn">
        <i class="fas fa-times"></i>
    </div>
    
    <!-- Tombol Prev -->
    <div class="absolute top-1/2 left-4 text-white text-4xl cursor-pointer hover:text-gray-300 transform -translate-y-1/2 z-20" id="prevImageBtn">
        <i class="fas fa-chevron-left"></i>
    </div>
    
    <!-- Tombol Next -->
    <div class="absolute top-1/2 right-4 text-white text-4xl cursor-pointer hover:text-gray-300 transform -translate-y-1/2 z-20" id="nextImageBtn">
        <i class="fas fa-chevron-right"></i>
    </div>
    
    <!-- Gambar -->
    <div class="flex items-center justify-center h-full p-4" id="modalContent">
        <img id="modalImage" src="" class="max-h-full max-w-full object-contain">
    </div>
    
    <!-- Counter -->
    <div class="absolute bottom-4 left-0 right-0 text-center text-white text-sm">
        <span id="imageCounter"></span>
    </div>
</div>

<script>
// Data gambar
const images = <?= json_encode(array_column($images, 'image_path')) ?>;
let currentIndex = 0;

function changeImage(index) {
    currentIndex = index;
    document.getElementById('mainImage').src = '<?= base_url('uploads/listings/') ?>' + images[index];
    
    // Update thumbnail border
    document.querySelectorAll('.thumbnail').forEach((thumb, i) => {
        if (i === index) {
            thumb.classList.add('border-blue-600');
            thumb.classList.remove('border-gray-200');
        } else {
            thumb.classList.remove('border-blue-600');
            thumb.classList.add('border-gray-200');
        }
    });
}

function openModal(index) {
    if (!images.length) return;
    currentIndex = index;
    document.getElementById('modalImage').src = '<?= base_url('uploads/listings/') ?>' + images[currentIndex];
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('imageCounter').textContent = (currentIndex + 1) + ' / ' + images.length;
}

function closeModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

function prevImage() {
    if (images.length === 0) return;
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    document.getElementById('modalImage').src = '<?= base_url('uploads/listings/') ?>' + images[currentIndex];
    document.getElementById('imageCounter').textContent = (currentIndex + 1) + ' / ' + images.length;
}

function nextImage() {
    if (images.length === 0) return;
    currentIndex = (currentIndex + 1) % images.length;
    document.getElementById('modalImage').src = '<?= base_url('uploads/listings/') ?>' + images[currentIndex];
    document.getElementById('imageCounter').textContent = (currentIndex + 1) + ' / ' + images.length;
}

// Event listeners setelah DOM loaded
document.addEventListener('DOMContentLoaded', function() {
    // Close modal button
    const closeBtn = document.getElementById('closeModalBtn');
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }
    
    // Prev button
    const prevBtn = document.getElementById('prevImageBtn');
    if (prevBtn) {
        prevBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            prevImage();
        });
    }
    
    // Next button
    const nextBtn = document.getElementById('nextImageBtn');
    if (nextBtn) {
        nextBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            nextImage();
        });
    }
    
    // Click on modal content (background) to close
    const modalContent = document.getElementById('modalContent');
    if (modalContent) {
        modalContent.addEventListener('click', function(e) {
            // Cuma close kalo yang diklik adalah background (bukan gambar)
            if (e.target === this) {
                closeModal();
            }
        });
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('imageModal');
        if (modal && !modal.classList.contains('hidden')) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                prevImage();
            }
            if (e.key === 'ArrowRight') {
                e.preventDefault();
                nextImage();
            }
            if (e.key === 'Escape') {
                closeModal();
            }
        }
    });
});
</script>

<?= $this->endSection() ?>