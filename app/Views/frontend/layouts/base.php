<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= meta_title($title ?? 'Galeri Niaga') ?></title>
    <meta name="description" content="<?= meta_description($description ?? 'Platform UMKM untuk produk, properti, dan jasa') ?>">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= meta_title($title ?? 'Galeri Niaga') ?>">
    <meta property="og:description" content="<?= meta_description($description ?? 'Platform UMKM untuk produk, properti, dan jasa') ?>">
    <meta property="og:image" content="<?= base_url('assets/images/og-image.jpg') ?>">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:type" content="website">
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Alpine.js untuk dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">
    
    <!-- Navbar -->
    <?= $this->include('frontend/components/navbar') ?>
    
    <!-- Main Content -->
    <main class="min-h-screen">
        <?= $this->renderSection('content') ?>
    </main>
    
    <!-- Footer -->
    <?= $this->include('frontend/components/footer') ?>
    
    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>
</html>