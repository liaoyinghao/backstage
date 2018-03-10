<?php

//默认路由

Route::get('/', function () {
    return redirect()->to("https://www.o2opark.com");
});




Route::group(['prefix' => 'api' , 'namespace' => 'Api'] , function(){

    Route::any('AddTicket','FzController@add');
    Route::any('UseTicket','FzController@uses');
    Route::any('SearchTicket','FzController@search');
    // Route::any('fztable','FzController@fztable');
    Route::any('getTicket','FzController@getTicket');
    Route::any('getShops','FzController@getShops');
    Route::any('userTicket','FzController@userTicket');
    Route::any('streetTicket','FzController@streetTicket');
    Route::any('analyseTicket','FzController@analyseTicket');
    Route::any('myj/carduse','FzController@cardUse')->name('myj');

    Route::group(['prefix' => 'card' ] , function(){
        Route::any('checkcode','ApiCardController@checkCode');
    });

});

Route::any('notice/success' , 'HomeController@success')->name('notice_success');
Route::any('notice/error' , 'HomeController@error')->name('notice_error');

Route::any('notice/errorreport' , 'Wx\NotifyController@errToLogs')->name('notice_report');//tamlok 1207 feedback

Route::group(['prefix' => 'notice'] , function(){//异步通知
    Route::any('/','NoticeController@index')->name('index');
    Route::any('modelmsg','NoticeController@modelMsg')->name('model_msg');//模版消息
});


Auth::routes();
//
// Route::get('/home', 'HomeController@index');
