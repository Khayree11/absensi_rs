<?php

namespace App\Controllers;

use App\Models\PresensiModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Admin extends BaseController
{
    public function dashboard()
    {
        $presensiModel = new PresensiModel();
        
        // 1. Ambil Input Filter dari URL (GET request)
        $startDate = $this->request->getGet('start_date');
        $endDate   = $this->request->getGet('end_date');
        $keyword   = $this->request->getGet('keyword');

        // 2. Mulai Query Builder
        $builder = $presensiModel->select('presensi.*, users.nama, users.unit, users.jabatan')
            ->join('users', 'users.id = presensi.user_id')
            ->orderBy('presensi.created_at', 'DESC');

        // 3. Terapkan Filter jika ada input
        if ($startDate && $endDate) {
            $builder->where("DATE(presensi.created_at) >=", $startDate)
                    ->where("DATE(presensi.created_at) <=", $endDate);
        }

        if ($keyword) {
            $builder->groupStart()
                    ->like('users.nama', $keyword)
                    ->orLike('users.unit', $keyword)
                    ->groupEnd();
        }

        $data['list_presensi'] = $builder->findAll();
        
        // Kembalikan data filter ke View agar input tidak hilang
        $data['filter_start'] = $startDate;
        $data['filter_end']   = $endDate;
        $data['filter_keyword'] = $keyword;

        return view('admin/dashboard', $data);
    }

    public function exportPdf()
    {
        $presensiModel = new PresensiModel();

        // 1. Ambil filter (Sama persis dengan dashboard agar hasil PDF sesuai tampilan)
        $startDate = $this->request->getGet('start_date');
        $endDate   = $this->request->getGet('end_date');
        $keyword   = $this->request->getGet('keyword');

        $builder = $presensiModel->select('presensi.*, users.nama, users.unit, users.jabatan')
            ->join('users', 'users.id = presensi.user_id')
            ->orderBy('presensi.created_at', 'DESC');

        if ($startDate && $endDate) {
            $builder->where("DATE(presensi.created_at) >=", $startDate)
                    ->where("DATE(presensi.created_at) <=", $endDate);
        }
        if ($keyword) {
            $builder->like('users.nama', $keyword);
        }

        $data['list_presensi'] = $builder->findAll();
        $data['periode'] = ($startDate && $endDate) ? "$startDate s/d $endDate" : "Semua Periode";

        // 2. Generate HTML untuk PDF
        // Kita buat view khusus yang sederhana untuk diprint
        $html = view('admin/pdf_view', $data);

        // 3. Setup Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true); // Agar bisa load gambar/bootstrap dari CDN
        $dompdf = new Dompdf($options);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 4. Download PDF
        $dompdf->stream("Laporan_Absensi.pdf", ["Attachment" => true]);
        
        $html = view('admin/pdf_view', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true); 
        // Tambahkan baris chroot di bawah ini
        $options->set('chroot', FCPATH); 
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("Laporan_Absensi.pdf", ["Attachment" => true]);
    }
}