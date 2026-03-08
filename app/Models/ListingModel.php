<?php

namespace App\Models;

use CodeIgniter\Model;

class ListingModel extends Model
{
    protected $table            = 'listings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id', 'title', 'slug', 'description', 
        'price', 'location', 'featured_image', 'status'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // MATIKAN VALIDASI OTOMATIS (tapi slug tetap ke-generate)
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = true;
    protected $cleanValidationRules = true;

    // Relationships
    public function category()
    {
        return $this->belongsTo('App\Models\CategoryModel', 'category_id', 'id');
    }

    public function images()
    {
        return $this->hasMany('App\Models\ListingImageModel', 'listing_id', 'id');
    }

    // Generate slug UNIQUE
    protected function generateSlug($title)
    {
        $slug = url_title($title, '-', true);
        $originalSlug = $slug;
        $count = 1;
        
        while ($this->where('slug', $slug)->withDeleted()->first()) {
            $slug = $originalSlug . '-' . $count++;
        }
        
        return $slug;
    }

    // Before insert/update - INI TETAP JALAN!
    protected $beforeInsert = ['createSlug'];
    protected $beforeUpdate = ['updateSlug'];

    protected function createSlug(array $data)
    {
        if (!isset($data['data']['slug']) || empty($data['data']['slug'])) {
            $data['data']['slug'] = $this->generateSlug($data['data']['title']);
        }
        return $data;
    }

    protected function updateSlug(array $data)
    {
        if (isset($data['data']['title']) && (!isset($data['data']['slug']) || empty($data['data']['slug']))) {
            $data['data']['slug'] = $this->generateSlug($data['data']['title']);
        }
        return $data;
    }

    // Scope untuk aktif
    public function active()
    {
        return $this->where('status', 'active');
    }

    // Search scope
    public function search($keyword)
    {
        if ($keyword) {
            $this->groupStart()
                 ->like('title', $keyword)
                 ->orLike('description', $keyword)
                 ->orLike('location', $keyword)
                 ->groupEnd();
        }
        return $this;
    }
}