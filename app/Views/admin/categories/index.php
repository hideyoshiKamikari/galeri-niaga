<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Daftar Kategori</h3>
        <a href="<?= base_url('admin/categories/create') ?>" 
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-plus mr-2"></i>Tambah Kategori
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Slug</th>
                    <th class="px-4 py-2 text-left">Dibuat</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr class="border-t">
                    <td class="px-4 py-2"><?= $category['id'] ?></td>
                    <td class="px-4 py-2"><?= esc($category['name']) ?></td>
                    <td class="px-4 py-2"><?= esc($category['slug']) ?></td>
                    <td class="px-4 py-2"><?= date('d/m/Y', strtotime($category['created_at'])) ?></td>
                    <td class="px-4 py-2">
                        <a href="<?= base_url('admin/categories/edit/' . $category['id']) ?>" 
                           class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= base_url('admin/categories/delete/' . $category['id']) ?>" 
                           class="text-red-500 hover:text-red-700"
                           onclick="return confirm('Yakin ingin menghapus?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $pager->links() ?>
</div>
<?= $this->endSection() ?>