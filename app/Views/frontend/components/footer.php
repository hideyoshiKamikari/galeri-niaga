<footer class="bg-gray-800 text-white pt-8 md:pt-12 pb-4 md:pb-6">
    <div class="container mx-auto px-4">
        <!-- Grid Footer -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 mb-6 md:mb-8">
            <!-- About -->
            <div data-aos="fade-up">
                <h4 class="text-base md:text-lg font-bold mb-3 md:mb-4 flex items-center">
                    <i class="fas fa-store text-blue-400 mr-2"></i>
                    Galeri Niaga
                </h4>
                <p class="text-xs md:text-sm text-gray-400 leading-relaxed">
                    Platform UMKM untuk memasarkan produk, properti, dan jasa. 
                    Bantu usaha lokal naik kelas.
                </p>
                <div class="flex space-x-3 mt-3 md:mt-4">
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-facebook-f text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-whatsapp text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-tiktok text-lg"></i>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div data-aos="fade-up" data-aos-delay="100">
                <h4 class="text-base md:text-lg font-bold mb-3 md:mb-4 flex items-center">
                    <i class="fas fa-link text-blue-400 mr-2"></i>
                    Tautan Cepat
                </h4>
                <ul class="space-y-1.5 md:space-y-2 text-xs md:text-sm">
                    <li>
                        <a href="<?= base_url('/') ?>" class="text-gray-400 hover:text-white transition flex items-center">
                            <i class="fas fa-chevron-right mr-2 text-xs"></i>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('/kategori') ?>" class="text-gray-400 hover:text-white transition flex items-center">
                            <i class="fas fa-chevron-right mr-2 text-xs"></i>
                            Kategori
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('/tentang') ?>" class="text-gray-400 hover:text-white transition flex items-center">
                            <i class="fas fa-chevron-right mr-2 text-xs"></i>
                            Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('/kontak') ?>" class="text-gray-400 hover:text-white transition flex items-center">
                            <i class="fas fa-chevron-right mr-2 text-xs"></i>
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Categories -->
            <div data-aos="fade-up" data-aos-delay="200">
                <h4 class="text-base md:text-lg font-bold mb-3 md:mb-4 flex items-center">
                    <i class="fas fa-tags text-blue-400 mr-2"></i>
                    Kategori Populer
                </h4>
                <ul class="space-y-1.5 md:space-y-2 text-xs md:text-sm">
                    <?php 
                    $footerCategories = model('App\Models\CategoryModel')
                                      ->orderBy('id', 'DESC')
                                      ->limit(4)
                                      ->find();
                    ?>
                    <?php foreach ($footerCategories as $cat): ?>
                    <li>
                        <a href="<?= base_url('kategori/' . $cat['slug']) ?>" class="text-gray-400 hover:text-white transition flex items-center">
                            <i class="fas fa-chevron-right mr-2 text-xs"></i>
                            <?= esc($cat['name']) ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <!-- Contact -->
            <div data-aos="fade-up" data-aos-delay="300">
                <h4 class="text-base md:text-lg font-bold mb-3 md:mb-4 flex items-center">
                    <i class="fas fa-phone-alt text-blue-400 mr-2"></i>
                    Hubungi Kami
                </h4>
                <ul class="space-y-2 md:space-y-3 text-xs md:text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt text-blue-400 mt-1 mr-3"></i>
                        <span class="text-gray-400">Jakarta, Indonesia</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope text-blue-400 mr-3"></i>
                        <a href="mailto:info@galeriniaga.com" class="text-gray-400 hover:text-white transition">
                            info@galeriniaga.com
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone text-blue-400 mr-3"></i>
                        <a href="tel:+6281234567890" class="text-gray-400 hover:text-white transition">
                            +62 812-3456-7890
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-t border-gray-700 pt-4 mt-4 md:pt-6 md:mt-6">
            <div class="flex flex-col sm:flex-row justify-between items-center text-xs md:text-sm text-gray-400">
                <p>&copy; <?= date('Y') ?> Galeri Niaga. All rights reserved.</p>
                <p class="mt-2 sm:mt-0">
                    Dibuat dengan <i class="fas fa-heart text-red-500 mx-1"></i> untuk UMKM Indonesia
                </p>
            </div>
        </div>
    </div>
</footer>