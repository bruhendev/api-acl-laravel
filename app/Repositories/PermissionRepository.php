<?php

namespace App\Repositories;

use App\DTO\Permissions\CreatePermissionDTO;
use App\DTO\Permissions\EditPermissionDTO;
use App\Models\Permission;
use Illuminate\Pagination\LengthAwarePaginator;

class PermissionRepository
{
    public function __construct(private Permission $permission)
    {
    }


    public function getPaginate(int $totalPerPage = 15, int $page = 1, string $filter = ''): LengthAwarePaginator
    {
        return $this->permission->query()->where('name', 'LIKE', "%{$filter}%")->paginate($totalPerPage, ['*'], 'page', $page);
    }

    public function createNew(CreatePermissionDTO $dto): Permission
    {
        return $this->permission->create((array) $dto);
    }

    public function findById(string $id): ?Permission
    {
        return $this->permission->query()->find($id);
    }

    public function update(EditPermissionDTO $dto): bool
    {
        if (!$permission = $this->findById($dto->id)) {
            return false;
        }

        return $permission->update((array) $dto);
    }

    public function delete(string $id): bool
    {
        if (!$permission = $this->findById($id)) {
            return false;
        }
        return $permission->delete();
    }
}
