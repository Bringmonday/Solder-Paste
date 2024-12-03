<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleTaskModel extends Model
{
    protected $table = 'tbl_roles';
    protected $primaryKey = 'roleId';

    protected $returnType = 'array';

    protected $allowedFields = [
        'roleId', 'role', 'status', 'isDeleted', 'createdBy', 'createdDtm', 'updatedBy', 'updatedDtm'
    ];

}
