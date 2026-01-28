<?php

namespace App\Controllers;

use App\Models\UserModel;

class Karyawan extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('admin/karyawan/index', $data);
    }

    public function create()
    {
        return view('admin/karyawan/create');
    }

    public function store()
    {
        // 1. Validasi Input di Controller (Cek data mentah)
        if (!$this->validate([
            'username' => 'required|alpha_numeric_space|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[8]',
            'nama'     => 'required|min_length[3]',
            'role'     => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Siapkan Data
        $data = [
            'nama'          => $this->request->getPost('nama'),
            'username'      => $this->request->getPost('username'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'unit'          => $this->request->getPost('unit'),
            'jabatan'       => $this->request->getPost('jabatan'),
            'alamat'        => $this->request->getPost('alamat'),
            'tgl_lahir'     => $this->request->getPost('tgl_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'role'          => $this->request->getPost('role'), // Pastikan ini nilainya 'admin' atau 'karyawan'
        ];

        // 3. Simpan dengan Pengecekan Error Model
        // Jika save() return false, berarti validasi Model gagal
        if ($this->userModel->save($data) === false) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        return redirect()->to('/karyawan')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data['user'] = $this->userModel->find($id);
        if (empty($data['user'])) {
            return redirect()->to('/karyawan')->with('error', 'Data tidak ditemukan');
        }
        return view('admin/karyawan/edit', $data);
    }

    public function update($id)
    {
        // Siapkan Data
        $data = [
            'id'            => $id, // ID wajib ada agar validasi is_unique (ignore ID) bekerja
            'nama'          => $this->request->getPost('nama'),
            'username'      => $this->request->getPost('username'),
            'unit'          => $this->request->getPost('unit'),
            'jabatan'       => $this->request->getPost('jabatan'),
            'alamat'        => $this->request->getPost('alamat'),
            'tgl_lahir'     => $this->request->getPost('tgl_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'role'          => $this->request->getPost('role'),
        ];

        // Cek Password (hanya update jika diisi)
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Simpan dengan Pengecekan
        if ($this->userModel->save($data) === false) {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        return redirect()->to('/karyawan')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/karyawan')->with('success', 'Data karyawan berhasil dihapus.');
    }
}