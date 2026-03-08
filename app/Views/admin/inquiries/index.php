<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-xl shadow-md p-6">
    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
        <div>
            <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-inbox text-blue-500 mr-3"></i>
                Daftar Inquiries
            </h3>
            <p class="text-sm text-gray-500 mt-1">Kelola permintaan titip jual dari pengunjung</p>
        </div>
    </div>
    
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
            <span><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>
    
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="w-full">
            <thead class="bg-gray-50 border-b-2 border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. HP</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (!empty($inquiries)): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($inquiries as $inq): ?>
                    <tr class="hover:bg-gray-50 transition <?= $inq['status'] == 'new' ? 'bg-yellow-50' : '' ?>">
                        <td class="px-6 py-4 text-sm text-gray-800"><?= $no++ ?></td>
                        <td class="px-6 py-4 font-medium text-gray-900"><?= esc($inq['name']) ?></td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <?php 
                            $phone = preg_replace('/[^0-9]/', '', $inq['phone']);
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
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <?php 
                            $types = [
                                'product' => '📦 Produk',
                                'property' => '🏠 Properti',
                                'service' => '🔧 Jasa'
                            ];
                            echo $types[$inq['listing_type']] ?? $inq['listing_type'];
                            ?>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php if ($inq['status'] == 'new'): ?>
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-medium">Baru</span>
                            <?php elseif ($inq['status'] == 'read'): ?>
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-medium">Dibaca</span>
                            <?php elseif ($inq['status'] == 'replied'): ?>
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-medium">Dibalas</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <?= date('d M Y H:i', strtotime($inq['created_at'])) ?>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex space-x-2">
                                <a href="<?= base_url('admin/inquiries/view/' . $inq['id']) ?>" 
                                   class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1.5 rounded-lg transition flex items-center">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                                <button type="button" 
                                        class="delete-btn bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded-lg transition flex items-center"
                                        data-id="<?= $inq['id'] ?>"
                                        data-name="<?= esc($inq['name']) ?>">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                            <p class="text-lg">Belum ada inquiry</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Total Count & Pagination -->
    <div class="mt-6">
        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
            <div class="flex items-center">
                <i class="fas fa-database mr-2 text-gray-400"></i>
                <span>Total: <span class="font-semibold text-gray-700"><?= count($inquiries) ?></span> inquiry</span>
            </div>
            <?php if (!empty($inquiries) && $pager->getPageCount() > 1): ?>
                <div>
                    <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                        Halaman <?= $pager->getCurrentPage() ?> dari <?= $pager->getPageCount() ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($inquiries) && $pager->getPageCount() > 1): ?>
            <div class="flex justify-center">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- SweetAlert2 Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation with SweetAlert
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const inquiryId = this.dataset.id;
            const inquiryName = this.dataset.name;
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Yakin ingin menghapus inquiry dari ${inquiryName}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('admin/inquiries/delete') ?>/' + inquiryId;
                }
            });
        });
    });
});
</script>

<?= $this->endSection() ?>