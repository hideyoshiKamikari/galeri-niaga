<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-xl shadow-md p-6">
    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
        <div>
            <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-list text-blue-500 mr-3"></i>
                Daftar Listings
            </h3>
            <p class="text-sm text-gray-500 mt-1">Kelola semua produk/properti/jasa Anda</p>
        </div>
        <a href="<?= route_to('admin.listings.create') ?>" 
           class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-5 py-2.5 rounded-lg shadow-md hover:shadow-lg transition duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Tambah Listing
        </a>
    </div>
    
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
            <span><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-3 text-xl"></i>
            <span><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>
    
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="w-full">
            <thead class="bg-gray-50 border-b-2 border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lokasi</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (!empty($listings)): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($listings as $listing): ?>
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 text-sm text-gray-800"><?= $no++ ?></td>
                        <td class="px-6 py-4 font-medium text-gray-900"><?= esc($listing['title']) ?></td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                                <?= esc($listing['category_name']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <?= $listing['price'] ? 'Rp ' . number_format($listing['price'], 0, ',', '.') : '-' ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                            <?= esc($listing['location']) ?: '-' ?>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php if ($listing['status'] == 'active'): ?>
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Active</span>
                            <?php else: ?>
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex space-x-2">
                                <a href="<?= route_to('admin.listings.edit', $listing['id']) ?>" 
                                   class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1.5 rounded-lg transition flex items-center">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <a href="<?= route_to('admin.listings.delete', $listing['id']) ?>" 
                                   class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded-lg transition flex items-center"
                                   onclick="return confirm('Yakin ingin menghapus listing <?= esc($listing['title']) ?>?')">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-list text-5xl text-gray-300 mb-3"></i>
                            <p class="text-lg">Belum ada listing</p>
                            <p class="text-sm">Klik tombol "Tambah Listing" untuk mulai</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Total Count & Pagination -->
    <div class="mt-6">
        <!-- Total Count -->
        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
            <div class="flex items-center">
                <i class="fas fa-database mr-2 text-gray-400"></i>
                <span>Total: <span class="font-semibold text-gray-700"><?= count($listings) ?></span> listing</span>
            </div>
            <?php if (!empty($listings) && $pager->getPageCount() > 1): ?>
                <div>
                    <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                        Halaman <?= $pager->getCurrentPage() ?> dari <?= $pager->getPageCount() ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Pagination -->
        <?php if (!empty($listings) && $pager->getPageCount() > 1): ?>
            <div class="flex justify-center">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>