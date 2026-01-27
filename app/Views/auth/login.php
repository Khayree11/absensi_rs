<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Presensi RSU PKU Jatinom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0056b3;
            --secondary-green: #28a745;
            --light-bg: #f0f4f8;
        }

        body { 
            background: linear-gradient(135deg, var(--light-bg) 0%, #dbeafe 100%);
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 86, 179, 0.1);
            overflow: hidden;
            background: #ffffff;
            max-width: 450px;
            width: 100%;
        }

        .card-header-logo {
            background: #ffffff;
            padding: 40px 20px 20px 20px;
            text-align: center;
        }

        .hospital-logo {
            max-width: 100%;
            height: auto;
            width: 300px; /* Menyesuaikan aspek rasio 762x167 */
        }

        .card-body {
            padding: 30px 40px 40px 40px;
        }

        .form-label {
            font-weight: 600;
            color: #4a5568;
            font-size: 0.9rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(0, 86, 179, 0.1);
            background-color: #ffffff;
        }

        .btn-login {
            background-color: var(--primary-blue);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: #004494;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 86, 179, 0.3);
        }

        .footer-text {
            font-size: 0.85rem;
            color: #718096;
            margin-top: 25px;
        }

        .footer-text a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }

        /* Responsive adjustment */
        @media (max-width: 480px) {
            .card-body { padding: 25px; }
            .hospital-logo { width: 220px; }
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="card login-card">
        <div class="card-header-logo">
            <img src="<?= base_url('image/full.png') ?>" alt="Logo RSU PKU Muhammadiyah Jatinom" class="hospital-logo">
        </div>
        
        <div class="card-body">
            <div class="text-center mb-4">
                <h4 class="fw-bold text-dark">E-Presensi Karyawan</h4>
                <p class="text-muted small">Silakan login untuk memulai absensi</p>
            </div>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="dismiss" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="/auth/valid_login" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-login w-100">Masuk ke Sistem</button>
            </form>

            <div class="text-center footer-text">
                Belum terdaftar sebagai karyawan? <br>
                <a href="/register">Hubungi IT Support atau Daftar di sini</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>