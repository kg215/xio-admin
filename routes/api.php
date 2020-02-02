<?php

use Illuminate\Support\Facades\Route;

Route::namespace("Api")->group(function(){

    Route::get("token","ApiToken@get");
    Route::get("register","UserController@register");
    Route::get("login","UserController@login");

    //文章api
    Route::apiResource("articles",'ArticleApi');

    //收藏的
    Route::get('articles/star/{id}','ArticleApi@star');

    //用户的
    Route::namespace("Web")->group(function(){
        Route::get('user/info/{id}','UserApi@show');
    });

    //评论的
    Route::prefix("comment")->group(function(){
        Route::get("/","CommentApi@show"); //查询comment列表
        Route::get("complaint/{id}","CommentApi@complaint"); //举报
        Route::post("update","CommentApi@update")->middleware("auth:admin");
    });

    Route::group(["middleware"=>["auth:web"]],function(){
        //文章点赞
        Route::get('articles/thumbs_up/{id}','ArticleApi@thumbsUp');

        //评论
        Route::prefix("comment")->group(function(){
            Route::post('send', 'CommentApi@send');
            Route::get('thumbs_up/{id}', 'CommentApi@thumbsUp');
            //删除
            Route::delete('/{id}', 'CommentApi@destroy');
        });
    });



    Route::group(["middleware"=>["auth:api"]],function (){
        Route::get('friends', "FriendsController@index");
        Route::get("modify","UserController@modify");
    });

    Route::group(['middleware' => ['web',"auth:web"]], function () {
        Route::get("logout","UserController@logout");
        Route::post("upload","UploadApi@store");
    });



});
//后台管理
Route::namespace("Api\Admin")->group(function () {

    Route::prefix("admin")->group(function(){
        Route::post("login","AdminApi@login");
        Route::get("logout","AdminApi@logout");
    });

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::apiResource("article","ArticleApi");
        Route::apiResource("module","ModuleApi");
    });

});

Route::namespace("Api\Web")->group(function () {

    Route::prefix("web")->group(function(){

        Route::post("login","UserApi@login");
        Route::post("register","UserApi@register");
        Route::get("logout","UserApi@logout");

        Route::group(['middleware' => 'auth:web'], function () {
            Route::post("user/setting","UserApi@setting");
            Route::get("users","UserApi@users");
            Route::get("user/info","UserApi@info");
            Route::post("user/avatar","UserApi@avatar");
            Route::put('article_group/pid/{id}','ArticleGroupApi@pid');
            Route::apiResource('article/group', 'ArticleGroupApi');
            Route::apiResource('user/articles', 'UserArticleApi');
            Route::put('user/articles/move/{id}','UserArticleApi@move');
            Route::post("upload","UploadApi@store");
        });
    });


});

