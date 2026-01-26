<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function valid_register()
    {
        $model = new UserModel();

        // Ambil data dari form
        $data = [
            'username'      => $this->request->getPost('username'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama'          => $this->request->getPost('nama'),
            'unit'          => $this->request->getPost('unit'),
            'jabatan'       => $this->request->getPost('jabatan'),
            'alamat'        => $this->request->getPost('alamat'),
            'tgl_lahir'     => $this->request->getPost('tgl_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'role'          => 'karyawan' // Otomatis jadi karyawan
        ];

        if ($model->save($data)) {
            return redirect()->to('/login')->with('success', 'Pendaftaran berhasil, silakan login.');
        } else {
            return redirect()->back()->with('error', 'Gagal mendaftar.');
        }
    }

    public function valid_login()
    {
        $model    = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Set Session
                session()->set([
                    'user_id'  => $user['id'],
                    'nama'     => $user['nama'],
                    'role'     => $user['role'],
                    'logged_in'=> true
                ]);

                // Redirect sesuai role
                if ($user['role'] == 'admin') {
                    return redirect()->to('/admin/dashboard');
                }
                return redirect()->to('/presensi');
            }
        }

        return redirect()->back()->with('error', 'Username atau Password salah.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}