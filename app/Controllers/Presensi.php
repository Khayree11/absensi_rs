<?php

namespace App\Controllers;

use App\Models\PresensiModel;

class Presensi extends BaseController
{
    public function index()
    {
        return view('presensi/index');
    }

    public function submit()
    {
        $session = session();
        $model = new PresensiModel();

        // 1. Tangkap data dari AJAX
        $user_id   = $session->get('user_id') ?? 1; // Pastikan user sudah login
        $jenis     = $this->request->getPost('jenis');
        $lat_user  = $this->request->getPost('lat');
        $long_user = $this->request->getPost('long');
        $image     = $this->request->getPost('image');

        // 2. Koordinat RSU PKU Muhammadiyah Jatinom (Target)
        $officeLat  = -7.639856176326184; 
        $officeLong = 110.60134710359047; 
        
        // 3. Tentukan Jarak Maksimal (Radius dalam Meter)
        $maxRange = 100; 

        // 4. Hitung Jarak Real-time
        $jarak = $this->calculateDistance($lat_user, $long_user, $officeLat, $officeLong);

        if ($jarak > $maxRange) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Anda berada di luar jangkauan RS! Jarak Anda: ' . round($jarak) . ' meter.'
            ]);
        }

        // 5. Proses Foto (Base64 ke Binary)
        // Hapus header data URI agar bersih
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        
        // Decode menjadi binary data
        $imgBinary = base64_decode($image);

        // 6. Simpan ke Database
        // Pastikan kolom 'foto' di database sudah bertipe BLOB/MEDIUMBLOB
        $model->save([
            'user_id'   => $user_id,
            'jenis'     => $jenis,
            'foto'      => $imgBinary, // Simpan data biner gambar
            'koordinat' => $lat_user . ',' . $long_user
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Absensi ' . $jenis . ' berhasil!']);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
}