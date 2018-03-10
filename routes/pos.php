<?php


//index
Route::get('/' , 'IndexController@index');

Route::get('loginouts' , 'IndexController@loginouts')->name('loginouts');
Route::post('loginpost' , 'IndexController@loginPost')->name('loginpost');

Route::any('paymentresult', 'IndexController@paymentResult')->name('paymentResult');//接收pos信息
Route::any('writeofffee', 'IndexController@writeoffFee')->name('writeofffee');//接收pos信息

Route::get('eliminate' , 'IndexController@eliminate')->name('eliminate');
Route::get('tel' , 'IndexController@tel')->name('tel');
Route::any('getshopoperationer' , 'IndexController@getshopoperationer')->name('getshopoperationer');
Route::any('saoresult' , 'IndexController@saoResult')->name('saoResult');
Route::any('regshop' , 'IndexController@regShop')->name('regShop');

Route::any('itemdata' , 'IndexController@itemData')->name('itemdata');
// Route::any('itemdatasession' , 'IndexController@itemdatasession')->name('itemdatasession');
