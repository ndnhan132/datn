<?php
use Illuminate\Support\Facades\Route;
Route::get('/is', function(){
    echo 'xxxx';
});
Route::get('/', 'HomeController@index');
