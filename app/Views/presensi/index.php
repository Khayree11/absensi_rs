<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi RS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h3 class="mb-4">Absensi Karyawan RS</h3>
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div id="my_camera" class="rounded border bg-dark mx-auto" style="width:320px; height:240px;"></div>
                    <div class="mt-3">
                        <select id="jenis_absen" class="form-select mb-2">
                            <option value="masuk">Presensi Masuk</option>
                            <option value="pulang">Presensi Pulang</option>
                        </select>
                        <button class="btn btn-primary w-100" onclick="prosesAbsen()">Kirim Absensi</button>
                    </div>
                </div>
            </div>
            <p id="location-status" class="text-muted small">Mendeteksi lokasi...</p>
        </div>
    </div>
</div>

<script>
    // Konfigurasi Kamera
    Webcam.set({ width: 320, height: 240, image_format: 'jpeg', jpeg_quality: 90 });
    Webcam.attach('#my_camera');

    function prosesAbsen() {
        if (!navigator.geolocation) {
            return Swal.fire('Error', 'Browser tidak mendukung GPS', 'error');
        }

        Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });

        navigator.geolocation.getCurrentPosition(function(position) {
            let lat = position.coords.latitude;
            let long = position.coords.longitude;

            Webcam.snap(function(data_uri) {
                $.ajax({
                    url: '/presensi/submit',
                    type: 'POST',
                    data: {
                        jenis: $('#jenis_absen').val(),
                        lat: lat,
                        long: long,
                        image: data_uri
                    },
                    success: function(res) {
                        Swal.fire(res.status === 'success' ? 'Berhasil' : 'Gagal', res.message, res.status);
                    }
                });
            });
        }, function() {
            Swal.fire('Error', 'Gagal mendapatkan lokasi. Pastikan GPS aktif.', 'error');
        });
    }
</script>
</body>
</html>