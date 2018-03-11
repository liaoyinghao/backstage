<?php

//后台
Route::get('/',function(){
    return redirect()->route('manage_street_main');
});

Route::get('login' , 'AdminController@login')->name('login');
Route::any('loginpost' , 'AdminController@loginPost')->name('loginpost');


Route::group(['prefix'=>'street' , 'as'=>'street_'] , function(){
    Route::get('/' , 'StreetController@index')->name('index');
    Route::get('main' , 'StreetController@main')->name('main');
});


Route::group(['prefix'=>'user' , 'as'=>'user_'] , function(){
    Route::get('main' , 'UserController@main')->name('main');
    Route::get('userdetailed' , 'UserController@userdetailed')->name('userdetailed');
});

