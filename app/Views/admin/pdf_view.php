<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .kop-surat { width: 100%; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .status-masuk { color: green; font-weight: bold; }
        .status-pulang { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <?php
        // Langkah 1: Tentukan path file yang benar
        // Catatan: Berdasarkan sistem, nama file Anda adalah "KOP Surat.jfif.jpeg"
        $path = FCPATH . 'image/kop_surat.jfif';
        
        // Langkah 2: Cek apakah file ada, lalu ubah ke Base64
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } else {
            $base64 = ''; // Kosongkan jika file tidak ditemukan
        }
    ?>

    <?php if ($base64): ?>
        <img src="<?= $base64 ?>" class="kop-surat" width="100%">
    <?php else: ?>
        <p style="color: red; text-align: center;">File Gambar Tidak Ditemukan di: <?= $path ?></p>
    <?php endif; ?>

    <div class="header">
        <h2 style="margin: 0;">Laporan Absensi Karyawan</h2>
        <p style="margin: 5px 0;">RSU PKU Muhammadiyah Jatinom</p>
        <p style="margin: 0;">Periode: <?= $periode ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Nama</th>
                <th>Unit</th>
                <th>Jenis</th>
                <th>Lokasi (Lat, Long)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list_presensi as $p) : ?>
            <tr>
                <td><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
                <td><?= $p['nama'] ?></td>
                <td><?= $p['unit'] ?></td>
                <td>
                    <span class="<?= $p['jenis'] == 'masuk' ? 'status-masuk' : 'status-pulang' ?>">
                        <?= ucfirst($p['jenis']) ?>
                    </span>
                </td>
                <td><?= $p['koordinat'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>