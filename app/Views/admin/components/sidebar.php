<aside class="w-64 bg-white shadow-lg h-screen sticky top-0">
    <div class="p-4 border-b">
        <h1 class="text-2xl font-bold text-gray-800">Galeri Niaga</h1>
        <p class="text-sm text-gray-600">Admin Panel</p>
    </div>
    
    <nav class="mt-4 px-2">
        <?php 
        $currentURL = current_url();
        $segment = service('uri')->getSegment(2); // admin/categories -> ambil 'categories'
        ?>
        
        <a href="<?= base_url('admin/dashboard') ?>" 
           class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors <?= $segment == '' || $segment == 'dashboard' ? 'bg-blue-50 text-blue-700' : '' ?>">
            <i class="fas fa-dashboard w-5 mr-3"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="<?= base_url('admin/categories') ?>" 
           class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors <?= $segment == 'categories' ? 'bg-blue-50 text-blue-700' : '' ?>">
            <i class="fas fa-tags w-5 mr-3"></i>
            <span>Kategori</span>
            <span class="ml-auto bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">3</span>
        </a>
        
        <a href="<?= base_url('admin/listings') ?>" 
           class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors <?= $segment == 'listings' ? 'bg-blue-50 text-blue-700' : '' ?>">
            <i class="fas fa-list w-5 mr-3"></i>
            <span>Listings</span>
            <span class="ml-auto bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">12</span>
        </a>
        
        <a href="<?= base_url('admin/inquiries') ?>" 
           class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors <?= $segment == 'inquiries' ? 'bg-blue-50 text-blue-700' : '' ?>">
            <i class="fas fa-inbox w-5 mr-3"></i>
            <span>Inquiries</span>
            <span class="ml-auto bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">5</span>
        </a>
        
        <hr class="my-2 border-gray-200">
        
        <!-- Settings (optional) -->
        <a href="<?= base_url('admin/settings') ?>" 
           class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors <?= $segment == 'settings' ? 'bg-blue-50 text-blue-700' : '' ?>">
            <i class="fas fa-cog w-5 mr-3"></i>
            <span>Pengaturan</span>
        </a>
        
        <!-- Logout with POST form -->
        <form action="<?= base_url('logout') ?>" method="POST" class="mt-2">
            <?= csrf_field() ?>
            <button type="submit" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-700 transition-colors w-full text-left">
                <i class="fas fa-sign-out w-5 mr-3"></i>
                <span>Logout</span>
            </button>
        </form>
    </nav>
    
    <!-- User info di bottom (optional) -->
    <div class="absolute bottom-0 w-64 p-4 border-t bg-gray-50">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                <?= substr(session()->get('name') ?? 'A', 0, 1) ?>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700"><?= session()->get('name') ?? 'Admin' ?></p>
                <p class="text-xs text-gray-500"><?= session()->get('role') ?? 'admin' ?></p>
            </div>
        </div>
    </div>
</aside>
