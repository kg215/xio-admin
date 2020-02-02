<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    use Response;
    /**
     *
     *
     * @var App\Model\User
     * @author kaxio
     * @date 2020-01-22
     */
    public $user=null;

    public function __construct()
    {
        $this->user = self::user();
        $this->admin = Auth::guard('admin')->user();
    }

    static function user(){
        return Auth::guard('web')->user();
    }

}
