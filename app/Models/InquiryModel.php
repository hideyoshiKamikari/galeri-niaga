<?php

namespace App\Models;

use CodeIgniter\Model;

class InquiryModel extends Model
{
    protected $table            = 'inquiries';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'phone', 'email', 'listing_type', 
        'message', 'listing_id', 'status'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'name'         => 'required|min_length[3]',
        'phone'        => 'required',
        'listing_type' => 'required|in_list[product,property,service]',
        'message'      => 'required',
        'status'       => 'in_list[new,read,replied]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Relationships
    public function listing()
    {
        return $this->belongsTo('App\Models\ListingModel', 'listing_id', 'id');
    }

    // Scope untuk status baru
    public function new()
    {
        return $this->where('status', 'new');
    }
}