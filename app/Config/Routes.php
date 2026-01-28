<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. Halaman Utama (Langsung ke Login)
$routes->get('/', 'Auth::login');

// 2. Routes untuk Autentikasi (Login & Register)
$routes->get('/login', 'Auth::login');
$routes->post('/auth/valid_login', 'Auth::valid_login');
$routes->get('/register', 'Auth::register');
$routes->post('/auth/valid_register', 'Auth::valid_register');
$routes->get('/logout', 'Auth::logout');

// 3. Routes untuk Karyawan (Presensi Kamera & GPS)
// Kita bisa menggunakan filter 'auth' jika nanti filternya sudah siap
$routes->group('presensi', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Presensi::index');
    $routes->post('submit', 'Presensi::submit');
});

// 4. Routes untuk Admin (Dashboard & Rekap)
// Kita gunakan group agar rapi dan bisa dipasang filter 'admin' nantinya
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('export', 'Admin::exportPdf'); // Route baru untuk PDF
});

$routes->group('karyawan', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Karyawan::index');           // Tampilkan List
    $routes->get('create', 'Karyawan::create');     // Form Tambah
    $routes->post('store', 'Karyawan::store');      // Proses Simpan
    $routes->get('edit/(:num)', 'Karyawan::edit/$1'); // Form Edit
    $routes->post('update/(:num)', 'Karyawan::update/$1'); // Proses Update
    $routes->get('delete/(:num)', 'Karyawan::delete/$1');  // Proses Hapus
});