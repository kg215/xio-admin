<?php

use Illuminate\Support\Facades\Route;

Route::get('/',"Client\IndexController@index");
Route::get('index',"Client\IndexController@index")->name("client.index");
Route::get('surprise',"Client\IndexController@surprise")->name("client.surprise");
Route::get('article',"Client\IndexController@article")->name("client.article");


Route::prefix("admin")->group(function(){
    Route::get("/","Admin\AdminController@index");
});

