<?php

namespace App\Controllers;

use App\Models\PresensiModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        $presensiModel = new PresensiModel();
        
        // Mengambil data presensi gabung dengan data user
        $data['list_presensi'] = $presensiModel->select('presensi.*, users.nama, users.unit, users.jabatan')
            ->join('users', 'users.id = presensi.user_id')
            ->orderBy('presensi.created_at', 'DESC')
            ->findAll();

        return view('admin/dashboard', $data);
    }
}