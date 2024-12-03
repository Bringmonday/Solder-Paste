<?php

namespace App\Models;

use CodeIgniter\Model;

class RegisterModel extends Model
{
    protected $table = 'tbl_users';
    protected $primaryKey = 'userId';
    protected $returnType = 'array';
    protected $allowedFields = ['name', 'email', 'password', 'mobile', 'roleId', 'isAdmin', 'isDeleted', 'createdBy', 'createdDtm', 'updatedBy', 'updatedDtm'];
}
