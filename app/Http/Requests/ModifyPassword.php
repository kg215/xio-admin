<?php

namespace App\Http\Requests;

class ModifyPassword extends UserPost
{
    public function messages()
    {
        $messages = parent::messages();
        return array_merge($messages,[
            'rePassword.required'  => '请输入密码',
            'rePassword.min'  => '密码最少8个字符',
            'rePassword.max'  => '密码最长25个字符',
            'newPassword.required'  => '请输入密码',
            'newPassword.min'  => '密码最少8个字符',
            'newPassword.max'  => '密码最长25个字符',
        ]);
    }

    public function rules()
    {
        $rules = parent::rules();
        return array_merge($rules,[
            'rePassword' => 'required|min:8|max:25',
            'newPassword' => 'required|min:8|max:25',
        ]);
    }

}
