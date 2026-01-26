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
$routes->group('presensi', function($routes) {
    $routes->get('/', 'Presensi::index');
    $routes->post('submit', 'Presensi::submit');
});

// 4. Routes untuk Admin (Dashboard & Rekap)
// Kita gunakan group agar rapi dan bisa dipasang filter 'admin' nantinya
$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
});