<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePresensiTable extends Migration
{
    public function up() 
    {
    $this->forge->addField([
        'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
        'user_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        'jenis'       => ['type' => 'ENUM', 'constraint' => ['masuk', 'pulang']],
        'foto'        => ['type' => 'VARCHAR', 'constraint' => 255],
        'koordinat'   => ['type' => 'VARCHAR', 'constraint' => 100],
        'created_at'  => ['type' => 'DATETIME', 'null' => true],
        'updated_at'  => ['type' => 'DATETIME', 'null' => true], // TAMBAHKAN INI
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    $this->forge->createTable('presensi');
    }

    public function down() 
    {
        $this->forge->dropTable('presensi', true);
    }
}
