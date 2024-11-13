<?php

namespace App\Services;

use App\Models\UserAkses;

class UserAksesService extends Service
{

    public function search($params = [])
    {
        $userAkses = UserAkses::whereNotNull('id');
        $this->searchResponse($params, $userAkses);
    }

    public function find($value, $column = 'id')
    {
        return UserAkses::where($column, $value)->first();
    }

    public function store($params)
    {
        return UserAkses::create($params);
    }

    public function update($params, $id)
    {
        $user_akses = UserAkses::find($id);
        if (!empty($user_akses)) $user_akses->update($params);
        return $user_akses;
    }

    public function delete($id)
    {
        $user_akses = UserAkses::find($id);
        if (!empty($user_akses)) {
            try {
                $user_akses->delete();
            } catch (\Exception $e) { return ['error' => 'Delete user failed! This user currently being used']; }
        }
        return $user_akses;
    }
}
