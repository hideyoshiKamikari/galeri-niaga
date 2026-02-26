<header class="bg-white shadow-sm">
    <div class="flex justify-between items-center px-6 py-3">
        <h2 class="text-xl font-semibold text-gray-800">
            <?= $title ?? 'Dashboard' ?>
        </h2>
        
        <div class="flex items-center">
            <span class="text-sm text-gray-600 mr-2">
                <?= session()->get('name') ?>
            </span>
            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white">
                <?= substr(session()->get('name'), 0, 1) ?>
            </div>
        </div>
    </div>
</header>