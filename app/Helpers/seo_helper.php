<?php

/**
 * SEO Helper - Meta tags, Open Graph, dll
 * 
 * @package GaleriNiaga
 */

if (!function_exists('meta_title')) {
    /**
     * Generate meta title
     * 
     * @param string $title Judul halaman
     * @param string $siteName Nama site
     * @return string
     */
    function meta_title($title, $siteName = 'Galeri Niaga')
    {
        return esc($title) . ' | ' . esc($siteName);
    }
}

if (!function_exists('meta_description')) {
    /**
     * Generate meta description (max 150-160 karakter)
     * 
     * @param string $description Deskripsi
     * @param int $maxLength Maksimal panjang
     * @return string
     */
    function meta_description($description, $maxLength = 150)
    {
        $description = strip_tags($description);
        $description = trim($description);
        
        if (strlen($description) > $maxLength) {
            $description = substr($description, 0, $maxLength - 3) . '...';
        }
        
        return esc($description);
    }
}

if (!function_exists('og_tags')) {
    /**
     * Generate Open Graph tags
     * 
     * @param array $data Data untuk OG
     * @return string HTML meta tags
     */
    function og_tags($data = [])
    {
        $defaults = [
            'title'       => 'Galeri Niaga',
            'description' => 'Platform UMKM untuk produk, properti, dan jasa',
            'image'       => base_url('assets/images/og-default.jpg'),
            'url'         => current_url(),
            'type'        => 'website'
        ];
        
        $data = array_merge($defaults, $data);
        
        $html = '';
        $html .= '<meta property="og:title" content="' . esc($data['title']) . '">' . "\n";
        $html .= '<meta property="og:description" content="' . esc($data['description']) . '">' . "\n";
        $html .= '<meta property="og:image" content="' . esc($data['image']) . '">' . "\n";
        $html .= '<meta property="og:url" content="' . esc($data['url']) . '">' . "\n";
        $html .= '<meta property="og:type" content="' . esc($data['type']) . '">' . "\n";
        
        return $html;
    }
}