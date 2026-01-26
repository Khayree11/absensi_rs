<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up() 
    {
    $this->forge->addField([
        'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
        'username'      => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
        'password'      => ['type' => 'VARCHAR', 'constraint' => 255],
        'nama'          => ['type' => 'VARCHAR', 'constraint' => 100],
        'unit'          => ['type' => 'VARCHAR', 'constraint' => 50],
        'jabatan'       => ['type' => 'VARCHAR', 'constraint' => 50],
        'alamat'        => ['type' => 'TEXT', 'null' => true],
        'tgl_lahir'     => ['type' => 'DATE', 'null' => true],
        'jenis_kelamin' => ['type' => 'ENUM', 'constraint' => ['L', 'P'], 'default' => 'L'],
        'role'          => ['type' => 'ENUM', 'constraint' => ['admin', 'karyawan'], 'default' => 'karyawan'],
        'created_at'    => ['type' => 'DATETIME', 'null' => true],
        'updated_at'    => ['type' => 'DATETIME', 'null' => true], // TAMBAHKAN INI
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('users');
    }

public function down() 
    {
    // Pastikan ini ada agar 'migrate:refresh' bisa menghapus tabel sebelum membuat baru
    $this->forge->dropTable('users', true); 
    }
}
