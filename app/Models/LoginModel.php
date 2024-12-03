<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'tbl_users';
    protected $primaryKey = 'userId';
    protected $returnType = 'array';
    protected $allowedFields = ['name', 'email', 'password', 'roleId'];

    protected $validationRules = [
        'name' => 'required',
        'password' => 'required'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Name is required'
        ],
        'password' => [
            'required' => 'Password is required'
        ]
    ];
}
