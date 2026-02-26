<?php

/**
 * WA Helper - Generate WhatsApp link dengan pesan otomatis
 * 
 * @package GaleriNiaga
 * @author Kamikari
 */

if (!function_exists('generate_wa_link')) {
    /**
     * Generate WhatsApp link dengan pesan otomatis
     * 
     * @param string $phone Nomor telepon (format internasional, tanpa +)
     * @param string $title Judul listing/produk
     * @param string $additional Pesan tambahan (opsional)
     * @return string URL WhatsApp yang sudah diencode
     */
    function generate_wa_link($phone, $title, $additional = '')
    {
        // Bersihin nomor telepon (ambil angka aja)
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Format pesan
        $message = "Halo, saya tertarik dengan *{$title}*";
        
        if (!empty($additional)) {
            $message .= "\n\n" . $additional;
        }
        
        $message .= "\n\nApakah masih tersedia?";
        
        // Encode pesan untuk URL
        $encoded_message = rawurlencode($message);
        
        // Generate link
        $link = "https://wa.me/{$phone}?text={$encoded_message}";
        
        return $link;
    }
}

if (!function_exists('format_phone')) {
    /**
     * Format nomor telepon ke format internasional
     * 
     * @param string $phone Nomor telepon
     * @param string $countryCode Kode negara (default: 62 untuk Indonesia)
     * @return string
     */
    function format_phone($phone, $countryCode = '62')
    {
        // Hapus semua karakter non-digit
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Handle nomor lokal Indonesia
        if (substr($phone, 0, 1) === '0') {
            $phone = $countryCode . substr($phone, 1);
        }
        
        // Handle nomor yang sudah pake 62 tapi ada +-nya
        if (substr($phone, 0, 2) !== $countryCode && substr($phone, 0, 1) !== '0') {
            $phone = $countryCode . $phone;
        }
        
        return $phone;
    }
}