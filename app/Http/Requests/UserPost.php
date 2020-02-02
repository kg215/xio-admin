<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPost extends FormRequest
{


    public function messages()
    {
        return [
            'title.required' => '请输入用户名',
            'password.required'  => '请输入密码',
            'name.max'  => '用户名过长',
            'password.min'  => '密码最少8个字符',
            'password.max'  => '密码最长25个字符',
        ];
    }

    public function rules()
    {
        return [
            'name' => 'bail|required|max:45',
            'password' => 'required|min:8|max:25',
        ];
    }

}
