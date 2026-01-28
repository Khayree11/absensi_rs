<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-person-plus-fill"></i> Registrasi Karyawan Baru</h4>
                    <p class="mb-0 small text-white-50">Isi formulir berikut dengan data lengkap</p>
                </div>
                <div class="card-body p-5">
                    
                    <?php if(session()->has('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0 ps-3">
                                <?php foreach(session('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('karyawan/store') ?>" method="post">
                        
                        <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">Informasi Pribadi</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama sesuai KTP" value="<?= old('nama') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control" value="<?= old('tgl_lahir') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="L" <?= old('jenis_kelamin') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="P" <?= old('jenis_kelamin') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Alamat Domisili</label>
                                <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap..."><?= old('alamat') ?></textarea>
                            </div>
                        </div>

                        <h6 class="text-primary fw-bold mb-3 mt-4 border-bottom pb-2">Posisi & Jabatan</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Unit Kerja</label>
                                <input type="text" name="unit" class="form-control" placeholder="Contoh: IGD, Radiologi" value="<?= old('unit') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Perawat Pelaksana" value="<?= old('jabatan') ?>" required>
                            </div>
                        </div>

                        <h6 class="text-primary fw-bold mb-3 mt-4 border-bottom pb-2">Pengaturan Akun</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Username unik" value="<?= old('username') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Role Akses</label>
                                <select name="role" class="form-select" required>
                                    <option value="karyawan" <?= old('role') == 'karyawan' ? 'selected' : '' ?>>Karyawan (Staff)</option>
                                    <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Administrator</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between pt-3">
                            <a href="<?= base_url('karyawan') ?>" class="btn btn-light border px-4 fw-semibold">Batal</a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow">
                                <i class="bi bi-save"></i> Simpan Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>