<?php

namespace App\Repositories;

use App\Models\Permission;

class PermissionRepository
{
    public function __construct(private Permission $permission)
    {
    }
}
