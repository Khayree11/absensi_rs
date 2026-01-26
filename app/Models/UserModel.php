<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    // Daftarkan semua kolom agar bisa diisi (Mass Assignment)
    protected $allowedFields    = [
        'username', 
        'password', 
        'nama', 
        'unit', 
        'jabatan', 
        'alamat', 
        'tgl_lahir', 
        'jenis_kelamin', 
        'role'
    ];

    // Konfigurasi Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    
    /** * PENTING: Ubah menjadi string kosong karena kolom 'updated_at' 
     * tidak ada di database kamu.
     */
    protected $updatedField  = 'updated_at'; 

    // Validasi Dasar
    protected $validationRules = [
        'username' => 'required|alpha_numeric_space|min_length[3]|is_unique[users.username,id,{id}]',
        'password' => 'required|min_length[8]',
        'nama'     => 'required|min_length[3]',
    ];

    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Username ini sudah digunakan oleh karyawan lain.',
        ],
    ];
}