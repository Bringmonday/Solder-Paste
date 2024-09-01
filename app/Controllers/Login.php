<?php

namespace App\Controllers;

use App\Models\LoginModel;
use CodeIgniter\Controller;

class Login extends Controller
{
    public function index()
    {
        helper(['form', 'url']);
        $session = session();
        $validation = \Config\Services::validation();
        $error = null;

        return view('login', ['error' => $error]);
    }

    public function loginMe()
    {
        $session = session();
        $model = new LoginModel();
        $name = $this->request->getVar('name');
        $password = $this->request->getVar('password');
        $data = $model->where('name', $name)->first();

        if ($data) {
            if ($password === $data['password']) {
                $ses_data = [
                    'user_id'       => $data['userId'],
                    'user_name'     => $data['name'],
                    'user_email'    => $data['email'], 
                    'logged_in'     => TRUE,
                    'role_id'       => $data['roleId']
                ];
                $session->set($ses_data);

                switch ($data['roleId']) {
                    case 1:
                        return redirect()->to('admnwarehouse/dashboardwrhs');
                    case 2:
                        return redirect()->to('admnproduksi/dashboardprod');
                    case 3:
                        return redirect()->to('admnoffprod/dashboardoffprod');
                    default:
                        return redirect()->to('dashboard');
                }
            } else {
                $session->setFlashdata('error', 'Invalid Username or Password');
                return redirect()->to('login');
            }
        } else {
            $session->setFlashdata('error', 'Invalid Username or Password');
            return redirect()->to('login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy(); 

        return redirect()->to(base_url('login'));
    }
}
