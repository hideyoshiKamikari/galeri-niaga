<?php

namespace App\Models;

use CodeIgniter\Model;

class ListingImageModel extends Model
{
    protected $table            = 'listing_images';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['listing_id', 'image_path', 'is_primary'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $dateFormat    = 'datetime';

    // Validation
    protected $validationRules      = [
        'listing_id'  => 'required|numeric',
        'image_path'  => 'required',
        'is_primary'  => 'permit_empty|in_list[0,1]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Relationships
    public function listing()
    {
        return $this->belongsTo('App\Models\ListingModel', 'listing_id', 'id');
    }

    // Set primary image
    public function setPrimary($id, $listingId)
    {
        // Reset semua primary untuk listing ini
        $this->where('listing_id', $listingId)
             ->set(['is_primary' => false])
             ->update();
        
        // Set yang dipilih jadi primary
        return $this->update($id, ['is_primary' => true]);
    }
}