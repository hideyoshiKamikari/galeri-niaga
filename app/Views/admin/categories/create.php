<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-semibold mb-4">Tambah Kategori</h3>
    
    <form action="<?= base_url('admin/categories/store') ?>" method="POST">
        <?= csrf_field() ?>
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   value="<?= old('name') ?>"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Masukkan nama kategori"
                   required>
        </div>
        
        <div class="flex justify-end">
            <a href="<?= base_url('admin/categories') ?>" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg mr-2">
                Batal
            </a>
            <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Simpan
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>