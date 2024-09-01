<?php

namespace App\Controllers;

use App\Models\RoleModel;
use CodeIgniter\Controller;

class Role extends Controller
{
    protected $RoleModel;
    protected $session;

    public function __construct()
    {
        $this->RoleModel = new RoleModel();
        helper('form');
        $this->session = \Config\Services::session();
    }

    public function profilewrhs()
    {
        $userId = $this->session->get('user_id');
        $user = $this->RoleModel->getUserById($userId);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User with ID $userId not found");
        }

        $data['user'] = $user;
        $data['pageTitle'] = 'Profile Warehouse';

        echo view('admnwarehouse/profilewrhs', $data);
    }

    public function profileprod()
    {
        $userId = $this->session->get('user_id');
        $user = $this->RoleModel->getUserById($userId);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User with ID $userId not found");
        }

        $data['user'] = $user;
        $data['pageTitle'] = 'Profile Produksi';

        echo view('admnproduksi/profileprod', $data);
    }

    public function profileoffprod()
    {
        $userId = $this->session->get('user_id');
        $user = $this->RoleModel->getUserById($userId);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User with ID $userId not found");
        }

        $data['user'] = $user;
        $data['pageTitle'] = 'Profile Office Produksi';

        echo view('admnoffprod/profileoffprod', $data);
    }

    public function updatePasswordwrhs()
    {
        $userId = $this->session->get('user_id');
        $currentPassword = $this->request->getPost('currentPassword');
        $newPassword = $this->request->getPost('newPassword');

        $user = $this->RoleModel->getUserById($userId);

        if ($user['password'] !== $currentPassword) {
            $this->session->setFlashdata('error', 'Password lama salah');
            return redirect()->back()->withInput();
        }

        $updateStatus = $this->RoleModel->update($userId, ['password' => $newPassword]);

        if ($updateStatus) {
            $this->session->setFlashdata('success', 'Password berhasil diubah');
        } else {
            $this->session->setFlashdata('error', 'Terjadi kesalahan saat mengubah password');
        }

        return redirect()->to('/admnwarehouse/profilewrhs');
    }

    public function updatePasswordprod()
    {
        $userId = $this->session->get('user_id');
        $currentPassword = $this->request->getPost('currentPassword');
        $newPassword = $this->request->getPost('newPassword');

        $user = $this->RoleModel->getUserById($userId);

        if ($user['password'] !== $currentPassword) {
            $this->session->setFlashdata('error', 'Password lama salah');
            return redirect()->back()->withInput(); 
        }

        $updateStatus = $this->RoleModel->update($userId, ['password' => $newPassword]);

        if ($updateStatus) {
            $this->session->setFlashdata('success', 'Password berhasil diubah');
        } else {
            $this->session->setFlashdata('error', 'Terjadi kesalahan saat mengubah password');
        }

        return redirect()->to('/admnproduksi/profileprod');
    }

    public function updatePasswordoffprod()
    {
        $userId = $this->session->get('user_id');
        $currentPassword = $this->request->getPost('currentPassword');
        $newPassword = $this->request->getPost('newPassword');

        $user = $this->RoleModel->getUserById($userId);

        if ($user['password'] !== $currentPassword) {
            $this->session->setFlashdata('error', 'Password lama salah');
            return redirect()->back()->withInput(); 
        }

        $updateStatus = $this->RoleModel->update($userId, ['password' => $newPassword]);

        if ($updateStatus) {
            $this->session->setFlashdata('success', 'Password berhasil diubah');
        } else {
            $this->session->setFlashdata('error', 'Terjadi kesalahan saat mengubah password');
        }

        return redirect()->to('/admnoffprod/profileoffprod');
    }

}
