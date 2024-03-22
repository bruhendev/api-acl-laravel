<?php

namespace App\Repositories;

use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\EditUserDTO;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class UserRepository
{
    public function __construct(private User $user)
    {
    }

    public function getPaginate(int $totalPerPage = 15, int $page = 1, string $filter = ''): LengthAwarePaginator
    {
        return $this->user->query()
            ->where('name', 'LIKE', "%{$filter}%")
            // ->with(['permissions'])
            ->paginate($totalPerPage, ['*'], 'page', $page);
    }

    public function createNew(CreateUserDTO $dto): User
    {
        $data = (array) $dto;
        $data['password'] = bcrypt($data['password']);
        return $this->user->create($data);
    }

    public function findById(string $id): ?User
    {
        return $this->user->query()->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->user->query()->where('email', $email)->first();
    }

    public function update(EditUserDTO $dto): bool
    {
        if (!$user = $this->findById($dto->id)) {
            return false;
        }

        $data = (array) $dto;
        unset($data['password']);

        if ($dto->password !== null) {
            $data['password'] = bcrypt($dto->password);
        }

        return $user->update($data);
    }

    public function delete(string $id): bool
    {
        if (!$user = $this->findById($id)) {
            return false;
        }
        return $user->delete();
    }

    public function syncPermisions(string $id, array $permissions): ?bool
    {
        if (!$user = $this->findById($id)) {
            return null;
        }

        $user->permissions()->sync($permissions);
        return true;
    }

    public function getPermissionsByUserId(string $user)
    {
        return $this->findById($user)->permissions()->get();
    }
}
