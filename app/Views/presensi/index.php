<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Digital - RSU PKU Jatinom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        .header-logo {
            padding: 30px 0;
            text-align: center;
        }

        .hospital-logo {
            max-width: 280px;
            height: auto;
        }

        .presensi-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 86, 179, 0.1);
            background: #ffffff;
            margin-bottom: 30px;
        }

        #my_camera {
            border: 4px solid #f8fafc !important;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            background: #2d3748 !important;
        }

        .form-select {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            font-weight: 500;
        }

        .btn-presensi {
            background-color: var(--primary-blue);
            border: none;
            border-radius: 10px;
            padding: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-presensi:hover {
            background-color: #004494;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 86, 179, 0.3);
        }

        #location-status {
            background: rgba(255, 255, 255, 0.6);
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-block;
            font-weight: 500;
        }

        .status-dot {
            height: 10px;
            width: 10px;
            background-color: #28a745;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.4; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="header-logo">
        <img src="<?= base_url('image/full.png') ?>" alt="Logo RSU PKU" class="hospital-logo">
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card presensi-card">
                <div class="card-body p-4 text-center">
                    <h4 class="fw-bold mb-1">E-Presensi</h4>
                    <p class="text-muted small mb-4">Pastikan wajah berada dalam frame kamera</p>
                    
                    <div id="my_camera" class="mx-auto mb-4"></div>
                    
                    <div class="presensi-controls">
                        <label class="text-start d-block small fw-bold mb-2">Jenis Kehadiran</label>
                        <select id="jenis_absen" class="form-select mb-3">
                            <option value="masuk">Presensi Masuk</option>
                            <option value="pulang">Presensi Pulang</option>
                        </select>
                        <button class="btn btn-primary btn-presensi w-100" onclick="prosesAbsen()">
                            Kirim Data Presensi
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <p id="location-status" class="text-muted small">
                    <span class="status-dot"></span> Mendeteksi lokasi GPS...
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Konfigurasi Kamera
    Webcam.set({ 
        width: 320, 
        height: 240, 
        image_format: 'jpeg', 
        jpeg_quality: 90,
        constraints: {
            facingMode: 'user'
        }
    });
    Webcam.attach('#my_camera');

    function prosesAbsen() {
        if (!navigator.geolocation) {
            return Swal.fire({
                icon: 'error',
                title: 'GPS Tidak Aktif',
                text: 'Browser Anda tidak mendukung atau memblokir akses lokasi.'
            });
        }

        Swal.fire({ 
            title: 'Memproses...', 
            text: 'Mengunci lokasi dan mengambil gambar',
            allowOutsideClick: false, 
            didOpen: () => { Swal.showLoading(); } 
        });

        navigator.geolocation.getCurrentPosition(function(position) {
            let lat = position.coords.latitude;
            let long = position.coords.longitude;

            Webcam.snap(function(data_uri) {
                $.ajax({
                    url: '<?= base_url('presensi/submit') ?>',
                    type: 'POST',
                    data: {
                        jenis: $('#jenis_absen').val(),
                        lat: lat,
                        long: long,
                        image: data_uri
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: res.status === 'success' ? 'success' : 'error',
                            title: res.status === 'success' ? 'Berhasil' : 'Gagal',
                            text: res.message,
                            confirmButtonColor: '#0056b3'
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
                    }
                });
            });
        }, function(error) {
            let msg = 'Gagal mendapatkan lokasi. Pastikan GPS aktif.';
            if(error.code == 1) msg = 'Mohon izinkan akses lokasi pada browser Anda.';
            
            Swal.fire({
                icon: 'error',
                title: 'Lokasi Gagal',
                text: msg
            });
        }, { enableHighAccuracy: true });
    }
</script>
</body>
</html>