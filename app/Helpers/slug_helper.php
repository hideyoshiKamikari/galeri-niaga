<?php

/**
 * Slug Helper - Generate unique slug untuk SEO
 * 
 * @package GaleriNiaga
 */

if (!function_exists('generate_slug')) {
    /**
     * Generate slug dari string
     * 
     * @param string $string Teks yang akan di-slug
     * @return string
     */
    function generate_slug($string)
    {
        // Pake fungsi bawaan CI4
        return url_title($string, '-', true);
    }
}

if (!function_exists('generate_unique_slug')) {
    /**
     * Generate unique slug dengan cek ke database
     * 
     * @param string $string Teks yang akan di-slug
     * @param string $table Nama tabel
     * @param string $field Nama field slug
     * @param int $ignoreId ID yang diabaikan (untuk update)
     * @return string
     */
    function generate_unique_slug($string, $table, $field = 'slug', $ignoreId = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($table);
        
        $slug = url_title($string, '-', true);
        $originalSlug = $slug;
        $counter = 1;
        
        while (true) {
            if ($ignoreId) {
                $builder->where('id !=', $ignoreId);
            }
            
            $exists = $builder->where($field, $slug)->countAllResults();
            
            if (!$exists) {
                break;
            }
            
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
}

if (!function_exists('generate_listing_slug')) {
    /**
     * Khusus untuk generate slug listing
     * 
     * @param string $title Judul listing
     * @param int $ignoreId ID yang diabaikan
     * @return string
     */
    function generate_listing_slug($title, $ignoreId = null)
    {
        return generate_unique_slug($title, 'listings', 'slug', $ignoreId);
    }
}

if (!function_exists('generate_category_slug')) {
    /**
     * Khusus untuk generate slug category
     * 
     * @param string $name Nama kategori
     * @param int $ignoreId ID yang diabaikan
     * @return string
     */
    function generate_category_slug($name, $ignoreId = null)
    {
        return generate_unique_slug($name, 'categories', 'slug', $ignoreId);
    }
}