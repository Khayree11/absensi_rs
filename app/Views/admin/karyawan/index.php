<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manajemen Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Karyawan</h3>
        <div>
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">Kembali ke Dashboard</a>
            <a href="<?= base_url('karyawan/create') ?>" class="btn btn-primary">+ Tambah Karyawan</a>
        </div>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Unit / Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $index => $user): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($user['nama']) ?></td>
                        <td><?= esc($user['username']) ?></td>
                        <td>
                            <small class="fw-bold text-primary"><?= esc($user['unit']) ?></small><br>
                            <small class="text-muted"><?= esc($user['jabatan']) ?></small>
                        </td>
                        <td>
                            <a href="<?= base_url('karyawan/edit/'.$user['id']) ?>" class="btn btn-sm btn-warning text-white">Edit</a>
                            
                            <a href="<?= base_url('karyawan/delete/'.$user['id']) ?>" 
                               onclick="return confirm('Yakin ingin menghapus karyawan ini? Data absensi mereka juga akan hilang.')"
                               class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>