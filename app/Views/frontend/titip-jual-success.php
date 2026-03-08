<?= $this->extend('frontend/layouts/base') ?>

<?= $this->section('content') ?>

<div class="container mx-auto px-4 py-16 md:py-20">
    <div class="max-w-md mx-auto text-center">
        <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-check-circle text-4xl text-green-600"></i>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-800 mb-3">
            Berhasil Terkirim!
        </h1>
        
        <p class="text-gray-600 mb-6">
            Terima kasih telah menitipkan barang/jasa Anda di Galeri Niaga.<br>
            Admin akan menghubungi Anda via WhatsApp dalam 2x24 jam.
        </p>
        
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-left">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-2"></i>
                Pastikan nomor WhatsApp Anda aktif dan menerima pesan.
            </p>
        </div>
        
        <a href="<?= base_url('/') ?>" 
           class="inline-block bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-home mr-2"></i>
            Kembali ke Home
        </a>
    </div>
</div>

<?= $this->endSection() ?>