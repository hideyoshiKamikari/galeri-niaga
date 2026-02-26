<?= $this->extend('admin/layouts/base') ?>

<?= $this->section('content') ?>

<!-- Welcome Section -->
<div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 mb-6 text-white">
    <h2 class="text-2xl font-bold mb-2">Welcome back, <?= session()->get('name') ?>! 👋</h2>
    <p class="opacity-90">Ini ringkasan aktivitas Galeri Niaga hari ini.</p>
</div>

<!-- ... sisanya tetap sama ... -->

<?= $this->endSection() ?>