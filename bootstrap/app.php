<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/
$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

//$app->afterBootstrapping(\Illuminate\Foundation\Bootstrap\LoadConfiguration::class, function ($app) {
//    $request = Illuminate\Http\Request::capture();
//    $key = $request->input("key");
//    if(!empty($key)){
//    try {
//            $pdo = new PDO(
//                'mysql:host=127.0.0.1;dbname=housekeeper;port=3306;charset=utf8',
//                '123456',
//                '123456'
//            );
//            $sql = 'SELECT id, username FROM yw_admin WHERE id = :id LIMIT 0,1';
//            $statement = $pdo->prepare($sql);
//            $statement->bindValue(':id', 3, PDO::PARAM_STR);
//            $statement->execute();
//            $result = $statement->fetchObject();
//            if(empty($result->username)){
//                throw new PDOException("请填写正确的agent_id");
//            }
//
//        } catch (PDOException $ex) {
//            echo $ex->getMessage();
//            exit();
//        }
//        config([
//            "database.connections.mysql.database"=>"aa",
//        ]);
//    }

//});
/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
