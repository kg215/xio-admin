<?php

namespace App\Exceptions;

use App\Http\Controllers\Api\Response;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    use Response;
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];
    protected $internalDontReport = [
        AppException::class
    ];

    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {
        //验证错误不跳转，直接json返回
        if ($exception instanceof ValidationException) {
            return response()->json($exception->errors(),$exception->status);
        }
        if($exception instanceof AppException){
            return $this->error(["tips"=>$exception->getMessage()]);
        }
        return response()->json($exception->getMessage(),500);
    }
}
