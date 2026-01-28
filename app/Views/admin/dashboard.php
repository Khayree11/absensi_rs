<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - RSU PKU Jatinom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-blue: #0056b3;
            --light-bg: #f0f4f8;
        }

        body { 
            background: linear-gradient(135deg, var(--light-bg) 0%, #dbeafe 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            color: #2d3748;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 2px 15px rgba(0, 86, 179, 0.1);
            padding: 15px 0;
        }

        .hospital-logo-nav {
            max-width: 200px;
            height: auto;
        }

        .logout-btn {
            color: #e53e3e;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            color: #c53030;
        }

        /* Card & Table Styling */
        .admin-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 86, 179, 0.08);
            background: #ffffff;
            overflow: hidden;
        }

        .card-header {
            background-color: #ffffff !important;
            border-bottom: 1px solid #edf2f7;
            padding: 20px 25px;
        }

        .table thead th {
            background-color: #f8fafc;
            color: var(--primary-blue);
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.05em;
        }

        /* Button & Badge Styling */
        .btn-view-photo {
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            border-color: var(--primary-blue);
            color: var(--primary-blue);
        }

        .btn-view-photo:hover {
            background-color: var(--primary-blue);
            color: #ffffff;
        }

        .btn-maps {
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge-masuk { background-color: #28a745; }
        .badge-pulang { background-color: #dc3545; }

        /* Modal Styling */
        .modal-content {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: 1px solid #f1f5f9;
            background: #f8fafc;
        }

        /* DataTables Customization */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-blue) !important;
            color: white !important;
            border: none !important;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="<?= base_url('image/full.png') ?>" alt="Logo RS" class="hospital-logo-nav">
        </a>
        
        <div class="d-flex align-items-center">
            <a href="<?= base_url('karyawan') ?>" class="btn btn-primary btn-sm me-3 rounded-pill px-3 fw-bold shadow-sm">
                <i class="bi bi-people-fill"></i> Kelola Karyawan
            </a>

            <span class="d-none d-md-inline fw-bold text-muted small border-start ps-3 me-3">
                Panel Administrator
            </span>

            <a href="<?= base_url('logout') ?>" class="logout-btn small text-danger text-decoration-none fw-bold">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold mb-1">Rekap Presensi Digital</h3>
            <p class="text-muted small">Monitor kehadiran karyawan secara real-time</p>
        </div>
    </div>

    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-body p-4">
            <form action="" method="get">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control" value="<?= $filter_start ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control" value="<?= $filter_end ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">Cari Nama / Unit</label>
                        <input type="text" name="keyword" class="form-control" placeholder="Nama Karyawan..." value="<?= $filter_keyword ?>">
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 fw-bold">
                                <i class="bi bi-search"></i> Filter
                            </button>
                            <a href="<?= base_url('admin/export') ?>?start_date=<?= $filter_start ?>&end_date=<?= $filter_end ?>&keyword=<?= $filter_keyword ?>" target="_blank" class="btn btn-danger w-100 fw-bold">
                                <i class="bi bi-file-earmark-pdf"></i> PDF
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card admin-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold" style="color: var(--primary-blue);">Daftar Kehadiran Hari Ini</h5>
            <span class="badge bg-light text-primary border border-primary-subtle">
                Total Data: <?= count($list_presensi) ?>
            </span>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="tabelAbsen" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Nama Karyawan</th>
                            <th>Unit / Jabatan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($list_presensi as $p) : ?>
                        
                        <?php 
                            // --- BAGIAN INI DIPERBAIKI ---
                            // 1. Convert Binary (BLOB) ke Base64 String
                            $fotoBase64 = base64_encode($p['foto']); 
                            
                            // 2. Buat Format Data URI untuk src gambar
                            $srcGambar = 'data:image/jpeg;base64,' . $fotoBase64;
                        ?>

                        <tr>
                            <td class="small fw-bold text-muted">
                                <?= date('d M Y', strtotime($p['created_at'])) ?><br>
                                <span class="text-dark"><?= date('H:i', strtotime($p['created_at'])) ?> WIB</span>
                            </td>
                            <td>
                                <div class="fw-bold"><?= esc($p['nama']) ?></div>
                                <div class="text-muted small">ID: #<?= esc($p['user_id']) ?></div>
                            </td>
                            <td>
                                <span class="d-block small fw-bold text-primary"><?= esc($p['unit']) ?></span>
                                <span class="d-block small text-muted"><?= esc($p['jabatan']) ?></span>
                            </td>
                            <td>
                                <span class="badge rounded-pill <?= $p['jenis'] == 'masuk' ? 'badge-masuk' : 'badge-pulang' ?> px-3 py-2">
                                    <i class="bi <?= $p['jenis'] == 'masuk' ? 'bi-box-arrow-in-right' : 'bi-box-arrow-right' ?>"></i> 
                                    <?= ucfirst($p['jenis']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm" role="group">
                                    <button class="btn btn-sm btn-view-photo" onclick="showFoto('<?= $srcGambar ?>')">
                                        <i class="bi bi-person-bounding-box"></i> Foto
                                    </button>
                                    
                                    <a href="https://www.google.com/maps?q=<?= $p['koordinat'] ?>" target="_blank" class="btn btn-sm btn-outline-secondary btn-maps">
                                        <i class="bi bi-geo-alt"></i> Maps
                                    </a>
                                </div>
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
            <div class="modal-header">
                <h6 class="modal-title fw-bold"><i class="bi bi-camera"></i> Bukti Foto Absensi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <img src="" id="imgModal" class="img-fluid rounded-4 shadow-sm border border-4 border-white" style="max-height: 500px;">
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
            "order": [[ 0, "desc" ]],
            "language": {
                "search": "Cari Karyawan:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Lanjut",
                    "previous": "Kembali"
                }
            }
        });
    });

    function showFoto(base64String) {
        // Fungsi JS tetap sama, karena kita mengirim string Base64 yang valid ke sini
        document.getElementById('imgModal').src = base64String;
        new bootstrap.Modal(document.getElementById('fotoModal')).show();
    }
</script>
</body>
</html>