<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInquiriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'listing_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'message' => [
                'type' => 'TEXT',
            ],
            'listing_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'new',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addKey('listing_id');
        $this->forge->addForeignKey('listing_id', 'listings', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('inquiries');
        
        // Check constraint untuk status
        $this->db->query("ALTER TABLE inquiries ADD CONSTRAINT inquiries_status_check CHECK (status IN ('new', 'read', 'replied'))");
    }

    public function down()
    {
        $this->forge->dropTable('inquiries');
    }
}