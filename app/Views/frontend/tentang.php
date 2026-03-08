<?= $this->extend('frontend/layouts/base') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<div class="bg-gray-100 py-3 px-4 text-sm border-b">
    <div class="container mx-auto">
        <a href="<?= base_url('/') ?>" class="text-blue-600 hover:underline">Home</a>
        <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
        <span class="text-gray-600 font-medium">Tentang Kami</span>
    </div>
</div>

<div class="container mx-auto px-4 py-6 md:py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                Tentang Galeri Niaga
            </h1>
            <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
        </div>
        
        <!-- Content -->
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
            <div class="prose max-w-none text-gray-700">
                <p class="text-lg mb-4">
                    <strong>Galeri Niaga</strong> adalah platform digital yang didedikasikan untuk memajukan 
                    Usaha Mikro, Kecil, dan Menengah (UMKM) di Indonesia.
                </p>
                
                <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">Visi</h3>
                <p class="mb-4">
                    Menjadi platform terdepan dalam pemberdayaan UMKM melalui teknologi digital yang 
                    mudah diakses dan bermanfaat bagi seluruh lapisan masyarakat.
                </p>
                
                <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">Misi</h3>
                <ul class="list-disc list-inside mb-4 space-y-2">
                    <li>Menyediakan wadah promosi gratis bagi pelaku UMKM</li>
                    <li>Mempermudah transaksi antara penjual dan pembeli</li>
                    <li>Meningkatkan daya saing produk lokal</li>
                    <li>Mendukung pertumbuhan ekonomi kreatif di Indonesia</li>
                </ul>
                
                <h3 class="text-xl font-bold text-gray-800 mt-6 mb-3">Nilai-Nilai Kami</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <i class="fas fa-handshake text-blue-600 text-2xl mb-2"></i>
                        <h4 class="font-bold">Integritas</h4>
                        <p class="text-sm">Menjaga kepercayaan antara penjual dan pembeli</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <i class="fas fa-users text-blue-600 text-2xl mb-2"></i>
                        <h4 class="font-bold">Kolaborasi</h4>
                        <p class="text-sm">Bersama membangun ekosistem UMKM yang kuat</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <i class="fas fa-lightbulb text-blue-600 text-2xl mb-2"></i>
                        <h4 class="font-bold">Inovasi</h4>
                        <p class="text-sm">Terus beradaptasi dengan perkembangan zaman</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <i class="fas fa-heart text-blue-600 text-2xl mb-2"></i>
                        <h4 class="font-bold">Kepedulian</h4>
                        <p class="text-sm">Memberi dampak positif bagi masyarakat</p>
                    </div>
                </div>
                
                <h3 class="text-xl font-bold text-gray-800 mt-8 mb-3">Tim Kami</h3>
                <p>
                    Kami adalah sekelompok individu yang peduli terhadap perkembangan UMKM di Indonesia. 
                    Dengan latar belakang teknologi dan bisnis, kami berkomitmen untuk menciptakan platform 
                    yang bermanfaat dan mudah digunakan.
                </p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>