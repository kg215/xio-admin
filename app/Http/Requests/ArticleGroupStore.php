<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ArticleGroupStore extends FormRequest
{

    public function messages()
    {
        return [
            'title.required' => '标题未填写',
            'title.max' => '标题不能超过45个字',
            'title.unique' => '分组已存在',
            'pid.required'  => 'pid is required',
        ];
    }

    public function rules()
    {
        return [
            "title"=>[
                "required",
                "max:45",
                Rule::unique('article_group')->where(function ($query) {
                    return $query->where('uid', Auth::guard("web")->user()->uid);
                })
            ],
            "pid"=>"required|int"
        ];
    }
}
