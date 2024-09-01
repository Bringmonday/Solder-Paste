<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'tbl_users';
    protected $primaryKey = 'userId';

    protected $returnType = 'array';

    protected $allowedFields = [
        'userId', 'email', 'password', 'name', 'mobile', 'roleId', 
        'isAdmin', 'isDeleted', 'createdBy', 'createdDtm', 'updatedBy', 'updatedDtm'
    ];

    public function getUserById($userId)
    {
        return $this->where('userId', $userId)->first();
    }
}
