<?php

//后台
Route::get('/',function(){
    return redirect()->route('manage_street_main');
});

Route::get('login' , 'AdminController@login')->name('login');
Route::post('login' , 'AdminController@loginPost')->name('login_post');


Route::group(['prefix'=>'street' , 'as'=>'street_'] , function(){
    Route::get('/' , 'StreetController@index')->name('index');
    Route::get('main' , 'StreetController@main')->name('main');

    Route::get('add' , 'StreetController@add')->name('add');
    Route::post('add' , 'StreetController@addPost')->name('add_post');
    Route::get('edit' , 'StreetController@edit')->name('edit');
    Route::post('edit' , 'StreetController@editPost')->name('edit_post');

    Route::get('bindshake' , 'StreetController@bindShake')->name('bind_shake');//商街绑定设备
    Route::post('bindshake' , 'StreetController@bindShakePost')->name('bind_shake_post');//商街绑定设备

});

