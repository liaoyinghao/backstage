<?php

//后台
Route::get('/',function(){
    return redirect()->route('manage_street_main');
});

//登录
Route::get('login' , 'AdminController@login')->name('login');
Route::any('loginpost' , 'AdminController@loginPost')->name('loginpost');


//后台首页
Route::group(['prefix'=>'street' , 'as'=>'street_'] , function(){
    Route::get('/' , 'StreetController@index')->name('index');
    Route::get('main' , 'StreetController@main')->name('main');
});


//账号添加
Route::group(['prefix'=>'user' , 'as'=>'user_'] , function(){
    Route::get('main' , 'UserController@main')->name('main');
    Route::get('userdetailed' , 'UserController@userdetailed')->name('userdetailed');
    Route::any('userzhuce' , 'UserController@userzhuce')->name('userzhuce');
    Route::any('del' , 'UserController@del')->name('del');
    Route::any('xiugai' , 'UserController@xiugai')->name('xiugai');
    Route::any('userxiugai' , 'UserController@userxiugai')->name('userxiugai');
});


//客户管理
Route::group(['prefix'=>'customer' , 'as'=>'customer_'] , function(){
    Route::any('main' , 'CustomerController@main')->name('main');
    Route::get('khadd' , 'CustomerController@khadd')->name('khadd');
    Route::get('khdetails' , 'CustomerController@khdetails')->name('khdetails');
});


//日报
Route::group(['prefix'=>'daily' , 'as'=>'daily_'] , function(){
    Route::get('main' , 'CustomerController@main')->name('main');
});


//项目管理
Route::group(['prefix'=>'project' , 'as'=>'project_'] , function(){
    Route::get('main' , 'ProjectController@main')->name('main');
});


//日历
Route::group(['prefix'=>'calendar' , 'as'=>'calendar_'] , function(){
    Route::get('main' , 'CalendarController@main')->name('main');
});


//财务管理
Route::group(['prefix'=>'finance' , 'as'=>'finance_'] , function(){
    Route::get('main' , 'FinanceController@main')->name('main');
});


//通知
Route::group(['prefix'=>'notice' , 'as'=>'notice_'] , function(){
    Route::get('main' , 'NoticeController@main')->name('main');
});
