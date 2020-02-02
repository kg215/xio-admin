<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class FriendsController extends ApiController
{

    public function index(Request $request){
        var_dump($this->user->uid);
    }

}
