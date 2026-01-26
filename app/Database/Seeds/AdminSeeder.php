<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        $data = [
            'username'      => 'admin',
            'password'      => password_hash('password', PASSWORD_DEFAULT),
            'nama'          => 'Administrator Utama',
            'unit'          => 'IT Support',
            'jabatan'       => 'Kepala IT',
            'alamat'        => 'Kantor RS',
            'tgl_lahir'     => '1990-01-01',
            'jenis_kelamin' => 'L',
            'role'          => 'admin', // Role diset sebagai admin
        ];

        // Memasukkan data ke database
        $userModel->save($data);
        
        echo "Akun Admin Berhasil Dibuat!\n";
    }
}