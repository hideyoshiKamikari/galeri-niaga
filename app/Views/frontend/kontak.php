<?= $this->extend('frontend/layouts/base') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<div class="bg-gray-100 py-3 px-4 text-sm border-b">
    <div class="container mx-auto">
        <a href="<?= base_url('/') ?>" class="text-blue-600 hover:underline">Home</a>
        <i class="fas fa-chevron-right mx-2 text-xs text-gray-400"></i>
        <span class="text-gray-600 font-medium">Kontak Kami</span>
    </div>
</div>

<div class="container mx-auto px-4 py-6 md:py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8 md:mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                Hubungi Kami
            </h1>
            <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
            <!-- Left Column - Contact Info -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    Informasi Kontak
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mr-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <p class="font-semibold">Alamat</p>
                            <p class="text-gray-600">Jl. Sudirman No. 123<br>Jakarta Pusat 12345</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mr-3">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <p class="font-semibold">Telepon</p>
                            <p class="text-gray-600">(021) 1234-5678</p>
                            <p class="text-gray-600">+62 812-3456-7890</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mr-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <p class="font-semibold">Email</p>
                            <p class="text-gray-600">info@galeriniaga.com</p>
                            <p class="text-gray-600">support@galeriniaga.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mr-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <p class="font-semibold">Jam Operasional</p>
                            <p class="text-gray-600">Senin - Jumat: 09.00 - 17.00</p>
                            <p class="text-gray-600">Sabtu: 09.00 - 13.00</p>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <p class="font-semibold mb-3">Ikuti Kami</p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-pink-600 text-white rounded-full flex items-center justify-center hover:bg-pink-700 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center hover:bg-green-700 transition">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center hover:bg-gray-800 transition">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Contact Form -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-paper-plane text-blue-600 mr-2"></i>
                    Kirim Pesan
                </h3>
                
                <form>
                    <?= csrf_field() ?>
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                               required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                               required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Pesan</label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                  required></textarea>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Pesan
                    </button>
                </form>
                
                <p class="text-xs text-gray-500 text-center mt-4">
                    * Form ini masih placeholder, nanti kita bikin fungsional
                </p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>