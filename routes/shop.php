<?php

//运营

//index
Route::get('/' , 'StoreController@index');
Route::post('getcode' , 'StoreController@getCode')->name('get_code');


Route::group(['prefix'=>'process' , 'as'=>'process_'] , function(){
    Route::get('enterbywx' , 'ProcessController@enterByWx')->name('enter_by_wx');

});


// Route::group(['prefix'=>'shake' , 'as'=>'shake_'] , function(){
//     Route::get('/' , 'ShakeController@index')->name('index');
//     Route::get('main' , 'ShakeController@main')->name('main');
//     Route::post('getshakes' , 'ShakeController@getShakes')->name('get_shakes');
//
// });
//
//
// Route::group(['prefix'=>'card' , 'as'=>'card_'] , function(){
//     Route::get('/' , 'CardController@index')->name('index');
//     Route::get('main' , 'CardController@main')->name('main');
//
// });
//
//
//
// Route::group(['prefix'=>'store' , 'as'=>'store_'] , function(){
//     Route::get('/' , 'StoreController@index')->name('index');
//     Route::get('main' , 'StoreController@main')->name('main');
//     Route::get('employee' , 'StoreController@employee')->name('employee');
//
// });
