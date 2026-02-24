<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'name'      => 'Admin',
            'email'     => 'admin@galeri.local',
            'password'  => password_hash('admin123', PASSWORD_DEFAULT),
            'role'      => 'admin',
            'is_active' => true,
        ];

        $this->db->table('users')->insert($data);
    }
}