<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserSaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route()->parameter('user') ?? '';
        return [
            'nama' => 'required',
            'akses' => 'required',
            'email' => 'required|unique:users,email' . ($id != '' ? (',' . $id) : ''),
            'password' => 'confirmed'
        ];
    }
}
