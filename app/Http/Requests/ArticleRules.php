<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRules extends FormRequest
{

    public function messages()
    {
        return [
            'title.required' => '请输入标题',
            'title.string' => '标题请输入字符串',
            'title.max'  => '标题过长',

            'author.max'  => '作者名字过长',

            'content.required'  => '请输入内容',
        ];
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:45',
            'module_id' => 'required|integer',
            'author' => 'max:30',
            'content' => 'required',
            "disabled"=>"nullable|integer",
        ];
    }
}
