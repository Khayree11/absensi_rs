<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .status-masuk { color: green; font-weight: bold; }
        .status-pulang { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Absensi Karyawan</h2>
        <p>RSU PKU Muhammadiyah Jatinom</p>
        <p>Periode: <?= $periode ?></p>
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