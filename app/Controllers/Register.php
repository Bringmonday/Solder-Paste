<?php

namespace App\Controllers;

use App\Models\RegisterModel;
use App\Models\RoleTaskModel;
use CodeIgniter\Controller;

class Register extends Controller
{
    public function index()
    {
        helper(['form', 'url']);

        $roleModel = new RoleTaskModel();
        $data['roles'] = $roleModel->findAll();

        // Get flashdata for success and error messages
        $session = session();
        $data['success'] = $session->getFlashdata('success');
        $data['error'] = $session->getFlashdata('error');

        return view('register', $data);
    }

    public function registerMe()
    {
        $RegisterModel = new RegisterModel();

        // Validasi input
        $validationRules = [
            'name' => 'required',
            'email' => [
                'rules' => 'required|valid_email|is_unique[tbl_users.email]',
                'errors' => [
                    'is_unique' => '{field} Sudah berada didalam database'
                ]
            ],
            'password' => 'required|min_length[6]',
            'mobile' => 'required|numeric|min_length[10]|max_length[15]',
            'roleId' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Insert data ke database
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'), // Tidak menggunakan hash
            'mobile' => $this->request->getPost('mobile'),
            'roleId' => $this->request->getPost('roleId'),
            'isAdmin' => 0, // Set to 0 assuming regular users are not admin by default
            'isDeleted' => 0,
            'createdBy' => 1, // Example: Set the creator ID
            'createdDtm' => date('Y-m-d H:i:s')
        ];

        if ($RegisterModel->insert($data)) {
            // Clear form input
            $this->clearInputs();

            return redirect()->to(base_url('register'))->with('success', 'Registration successful. Please login.');
        } else {
            return redirect()->to(base_url('register'))->with('error', 'Registration failed. Please try again.');
        }
    }

    private function clearInputs()
    {
        // Clear all session data to reset form inputs
        $session = session();
        $session->remove('name');
        $session->remove('email');
        $session->remove('mobile');
        $session->remove('roleId');
    }
}
