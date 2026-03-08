<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-xl shadow-md p-6 max-w-4xl mx-auto">
    <div class="mb-6 pb-4 border-b border-gray-200">
        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-inbox text-blue-500 mr-3"></i>
            Detail Inquiry
        </h3>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Informasi Pemesan -->
        <div>
            <h4 class="text-lg font-semibold mb-4 text-gray-700">Informasi Pemesan</h4>
            
            <table class="w-full">
                <tr>
                    <td class="py-2 text-sm text-gray-600 w-32">Nama</td>
                    <td class="py-2 text-sm font-medium"><?= esc($inquiry['name']) ?></td>
                </tr>
                <tr>
                    <td class="py-2 text-sm text-gray-600">No. WhatsApp</td>
                    <td class="py-2 text-sm font-medium">
                        <?php 
                        // Format nomor HP
                        $phone = preg_replace('/[^0-9]/', '', $inquiry['phone']);
                        if (substr($phone, 0, 1) === '0') {
                            $phone = '62' . substr($phone, 1);
                        } elseif (substr($phone, 0, 2) !== '62') {
                            $phone = '62' . $phone;
                        }
                        ?>
                        <a href="https://wa.me/<?= $phone ?>" target="_blank" class="text-green-600 hover:underline">
                            +<?= $phone ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 text-sm text-gray-600">Email</td>
                    <td class="py-2 text-sm font-medium">
                        <?php if ($inquiry['email']): ?>
                            <a href="mailto:<?= esc($inquiry['email']) ?>" class="text-blue-600 hover:underline">
                                <?= esc($inquiry['email']) ?>
                            </a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 text-sm text-gray-600">Jenis Listing</td>
                    <td class="py-2 text-sm font-medium">
                        <?php 
                        $types = [
                            'product' => '📦 Produk (Barang)',
                            'property' => '🏠 Properti (Rumah, Tanah, Ruko)',
                            'service' => '🔧 Jasa (Servis, Kursus, dll)'
                        ];
                        echo $types[$inquiry['listing_type']] ?? $inquiry['listing_type'];
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 text-sm text-gray-600">Tanggal</td>
                    <td class="py-2 text-sm font-medium"><?= date('d F Y H:i', strtotime($inquiry['created_at'])) ?></td>
                </tr>
                <tr>
                    <td class="py-2 text-sm text-gray-600">Status</td>
                    <td class="py-2">
                        <select id="statusSelect" class="border rounded-lg px-3 py-1 text-sm">
                            <option value="new" <?= $inquiry['status'] == 'new' ? 'selected' : '' ?>>Baru</option>
                            <option value="read" <?= $inquiry['status'] == 'read' ? 'selected' : '' ?>>Dibaca</option>
                            <option value="replied" <?= $inquiry['status'] == 'replied' ? 'selected' : '' ?>>Dibalas</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- Foto Produk (Multiple) -->
        <?php 
        $photos = [];
        if (!empty($inquiry['photos'])) {
            $photos = json_decode($inquiry['photos'], true);
        }
        
        if (!empty($photos)): 
        ?>
        <div>
            <h4 class="text-lg font-semibold mb-4 text-gray-700">Foto Produk</h4>
            <div class="grid grid-cols-2 gap-3">
                <?php foreach ($photos as $photo): 
                    // Cek apakah file WebP sudah ada
                    $webpPath = 'uploads/inquiries/webp/' . pathinfo($photo, PATHINFO_FILENAME) . '.webp';
                    $imageUrl = file_exists(FCPATH . $webpPath) 
                        ? base_url($webpPath) 
                        : base_url('uploads/inquiries/' . $photo);
                ?>
                <div class="relative group">
                    <img src="<?= $imageUrl ?>" 
                         class="w-full h-32 object-cover rounded-lg border border-gray-200"
                         loading="lazy"
                         onclick="openModal('<?= $imageUrl ?>')">
                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center space-x-2 rounded-lg">
                        <a href="<?= $imageUrl ?>" target="_blank" 
                           class="bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600">
                            <i class="fas fa-search-plus"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Deskripsi -->
    <div class="mt-6 pt-4 border-t border-gray-200">
        <h4 class="text-lg font-semibold mb-4 text-gray-700">Deskripsi</h4>
        <div class="bg-gray-50 p-4 rounded-lg whitespace-pre-line">
            <?= nl2br(esc($inquiry['message'])) ?>
        </div>
    </div>
    
    <!-- Tombol Aksi -->
    <div class="mt-6 flex justify-end space-x-3">
        <a href="<?= base_url('admin/inquiries') ?>" 
           class="px-6 py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
            Kembali
        </a>
        
        <!-- TOMBOL BUAT LISTING DARI INQUIRY -->
        <a href="<?= base_url('admin/listings/create-from-inquiry/' . $inquiry['id']) ?>" 
           class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition flex items-center">
            <i class="fas fa-plus-circle mr-2"></i>
            Buat Listing
        </a>
        
        <a href="https://wa.me/<?= $phone ?>?text=<?= urlencode('Halo ' . $inquiry['name'] . ', kami dari Galeri Niaga menerima permintaan titip jual Anda. Mohon menunggu informasi selanjutnya.') ?>" 
           target="_blank"
           class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition flex items-center">
            <i class="fab fa-whatsapp mr-2"></i>
            Balas via WA
        </a>
    </div>
</div>

<!-- Modal Zoom Image -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden" onclick="closeModal()">
    <div class="absolute top-4 right-4 text-white text-3xl cursor-pointer hover:text-gray-300" onclick="closeModal()">
        <i class="fas fa-times"></i>
    </div>
    <div class="flex items-center justify-center h-full p-4">
        <img id="modalImage" src="" class="max-h-full max-w-full object-contain">
    </div>
</div>

<script>
document.getElementById('statusSelect').addEventListener('change', function() {
    const status = this.value;
    const inquiryId = <?= $inquiry['id'] ?>;
    const statusText = this.options[this.selectedIndex].text;
    
    Swal.fire({
        title: 'Konfirmasi',
        text: `Ubah status menjadi ${statusText}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, ubah!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Tampilkan loading
            Swal.fire({
                title: 'Memproses...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // PAKAI FORMDATA
            const formData = new FormData();
            formData.append('status', status);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            
            fetch('<?= base_url('admin/inquiries/update-status') ?>/' + inquiryId, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                    // HAPUS Content-Type, biar FormData yang set
                }
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('HTTP error ' + res.status);
                }
                return res.json();
            })
            .then(data => {
                Swal.close();
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: `Status berhasil diubah menjadi ${statusText}`,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '<?= base_url('admin/inquiries') ?>';
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.error || 'Terjadi kesalahan',
                        icon: 'error'
                    });
                    // Kembalikan ke nilai semula
                    document.getElementById('statusSelect').value = '<?= $inquiry['status'] ?>';
                }
            })
            .catch(error => {
                Swal.close();
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan: ' + error.message,
                    icon: 'error'
                });
                document.getElementById('statusSelect').value = '<?= $inquiry['status'] ?>';
            });
        } else {
            // Kalo batal, kembalikan ke nilai semula
            this.value = '<?= $inquiry['status'] ?>';
        }
    });
});

// Modal functions
function openModal(imageUrl) {
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (!document.getElementById('imageModal').classList.contains('hidden')) {
        if (e.key === 'Escape') {
            closeModal();
        }
    }
});
</script>

<?= $this->endSection() ?>