<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class AdminApi extends ApiController
{
    use AuthenticatesUsers;

    protected function authenticated(){
        return $this->success();
    }

    protected function loggedOut(){
        return $this->success();
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function username()
    {
        return 'name';
    }
}
