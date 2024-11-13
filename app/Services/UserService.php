<?php

namespace App\Services;

use App\Models\User;

class UserService extends Service
{
    public function search($params = [])
    {
        $user = User::whereNotNull('id');

        $name = $params['nama'] ?? '';
        if ($name !== '') $user = $user->where('nama', 'like', "%$name%");

        $akses = $params['akses'] ?? '';
        if ($akses !== '') $user = $user->whereHas('list_akses', fn($list_akses) => $list_akses->where('akses', $akses));
        return $this->searchResponse($params, $user);
    }

    public function find($value, $column = 'id')
    {
        return User::where($column, $value)->first();
    }

    public function store($params)
    {
        $params = $this->clean_password($params);
        return User::create($params);
    }

    public function update($params, $id)
    {
        $params = $this->clean_password($params);
        $user = User::find($id);
        if (!empty($user)) $user->update($params);
        return $user;
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!empty($user)) {
            try {
                $user->delete();
            } catch (\Exception $e) { return ['error' => 'Delete user failed! This user currently being used']; }
        }
        return $user;
    }

    public function clean_password($params)
    {
        $password = $params['password'] ?? '';
        if ($password === '') unset($params['password']);
        else $params['password'] = bcrypt($password);
        return $params;
    }

    public function users($combine = true): array
    {
        $users = $this->search();
        if ($combine === true) return array_combine($users->pluck('id')->toArray(), $users->pluck('name')->toArray());
        return $users;
    }

    public function list_akses()
    {
        return array_combine(User::LIST_AKSES, User::LIST_AKSES);
    }

    public function base_routes()
    {
        return User::BASE_ROUTES;
    }
}
