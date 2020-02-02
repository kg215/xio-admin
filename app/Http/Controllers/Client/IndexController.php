<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class IndexController extends Controller
{

    public function index(Request $request){
        return view('index');
    }

    public function surprise(Request $request){
        return view('surprise');
    }

    public function article(Request $request){
        return view('article');
    }
}
