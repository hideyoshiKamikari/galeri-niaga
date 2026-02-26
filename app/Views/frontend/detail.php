<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<h2><?= esc($listing['title']) ?></h2>

<p><?= esc($listing['description']) ?></p>

<?php if ($listing['price']) : ?>
    <p><strong>Harga:</strong> Rp <?= number_format($listing['price']) ?></p>
<?php endif; ?>

<p><strong>Lokasi:</strong> <?= esc($listing['location']) ?></p>

<a href="https://wa.me/6281234567890?text=Halo%20saya%20tertarik%20dengan%20<?= urlencode($listing['title']) ?>"
   target="_blank">
   Hubungi via WhatsApp
</a>

<?= $this->endSection() ?>