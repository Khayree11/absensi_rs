<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Absensi RS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">Admin Absensi RS</a>
    </div>
</nav>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Rekap Presensi Karyawan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabelAbsen" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Nama</th>
                            <th>Unit/Jabatan</th>
                            <th>Jenis</th>
                            <th>Foto</th>
                            <th>Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($list_presensi as $p) : ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
                            <td><strong><?= $p['nama'] ?></strong></td>
                            <td><small><?= $p['unit'] ?> (<?= $p['jabatan'] ?>)</small></td>
                            <td>
                                <span class="badge <?= $p['jenis'] == 'masuk' ? 'bg-success' : 'bg-danger' ?>">
                                    <?= ucfirst($p['jenis']) ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" onclick="showFoto('<?= base_url('uploads/presensi/'.$p['foto']) ?>')">Lihat Foto</button>
                            </td>
                            <td>
                                <a href="https://www.google.com/maps?q=<?= $p['koordinat'] ?>" target="_blank" class="btn btn-sm btn-outline-secondary">Buka Maps</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="fotoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Foto Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="imgModal" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabelAbsen').DataTable({
            "order": [[ 0, "desc" ]] // Urutkan dari yang terbaru
        });
    });

    function showFoto(url) {
        document.getElementById('imgModal').src = url;
        new bootstrap.Modal(document.getElementById('fotoModal')).show();
    }
</script>
</body>
</html>