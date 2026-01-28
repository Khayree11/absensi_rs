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

    // Daftarkan semua kolom sesuai Migration
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
    
    // PERBAIKAN 1: Karena di Migration sudah ada kolom updated_at, 
    // maka ini kita aktifkan (jangan dikosongkan).
    protected $updatedField  = 'updated_at'; 

    // Validasi
    protected $validationRules = [
        // PERBAIKAN 2: Wajib ada aturan untuk 'id' agar placeholder {id} di bawah bekerja
        'id'       => 'permit_empty|is_natural_no_zero',

        // Aturan Username (Unik, tapi abaikan ID milik sendiri saat Edit)
        'username' => 'required|alpha_numeric_space|min_length[3]|is_unique[users.username,id,{id}]',
        
        // PERBAIKAN 3: Gunakan 'permit_empty' agar saat Edit tidak error jika password dikosongkan
        'password' => 'permit_empty|min_length[8]',
        
        'nama'     => 'required|min_length[3]',
    ];

    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Username ini sudah digunakan oleh karyawan lain.',
        ],
    ];
}