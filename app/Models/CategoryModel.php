<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;  // Pake soft delete
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'slug'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'name' => 'required|min_length[3]|max_length[100]',
        'slug' => 'required|is_unique[categories.slug,id,{id}]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Relationships
    public function listings()
    {
        return $this->hasMany('App\Models\ListingModel', 'category_id', 'id');
    }

    // Generate slug otomatis
    protected function generateSlug($name)
    {
        $slug = url_title($name, '-', true);
        $originalSlug = $slug;
        $count = 1;
        
        while ($this->where('slug', $slug)->withDeleted()->first()) {
            $slug = $originalSlug . '-' . $count++;
        }
        
        return $slug;
    }

    // Before insert
    protected $beforeInsert = ['createSlug'];
    protected $beforeUpdate = ['updateSlug'];

    protected function createSlug(array $data)
    {
        if (!isset($data['data']['slug']) || empty($data['data']['slug'])) {
            $data['data']['slug'] = $this->generateSlug($data['data']['name']);
        }
        return $data;
    }

    protected function updateSlug(array $data)
    {
        if (isset($data['data']['name']) && (!isset($data['data']['slug']) || empty($data['data']['slug']))) {
            $data['data']['slug'] = $this->generateSlug($data['data']['name']);
        }
        return $data;
    }

        // Cek apakah kategori punya listing
    public function hasListings($id)
    {
        return $this->db->table('listings')
            ->where('category_id', $id)
            ->countAllResults() > 0;
    }
}