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
    Route::any('hui' , 'UserController@hui')->name('hui');
    Route::any('xiugai' , 'UserController@xiugai')->name('xiugai');
    Route::any('userxiugai' , 'UserController@userxiugai')->name('userxiugai');
    Route::any('distribution' , 'UserController@distribution')->name('distribution');
    Route::any('distributionpost' , 'UserController@distributionpost')->name('distributionpost');
});


//客户管理
Route::group(['prefix'=>'customer' , 'as'=>'customer_'] , function(){
    Route::any('main' , 'CustomerController@main')->name('main');
    Route::get('khadd' , 'CustomerController@khadd')->name('khadd');
    Route::post('khaddpost' , 'CustomerController@khaddpost')->name('khaddpost');
    // Route::get('khdetails' , 'CustomerController@khdetails')->name('khdetails');
    Route::any('khgrades' , 'CustomerController@khgrades')->name('khgrades');
    Route::any('followup' , 'CustomerController@followup')->name('followup');
    Route::any('followuppost' , 'CustomerController@followuppost')->name('followuppost');
    Route::get('chzuyuan' , 'CustomerController@chzuyuan')->name('chzuyuan');
    Route::get('zuyuankh' , 'CustomerController@zuyuankh')->name('zuyuankh');
    Route::get('khdetail' , 'CustomerController@khdetail')->name('khdetail');
    Route::get('khterxm' , 'CustomerController@khterxm')->name('khterxm');
});


//日报
Route::group(['prefix'=>'daily' , 'as'=>'daily_'] , function(){
    Route::get('main' , 'DailyController@main')->name('main');
    Route::any('adddaily' , 'DailyController@adddaily')->name('adddaily');
    Route::any('rb' , 'DailyController@rb')->name('rb');
});


//项目管理
Route::group(['prefix'=>'project' , 'as'=>'project_'] , function(){
    Route::get('main' , 'ProjectController@main')->name('main');
    Route::get('list' , 'ProjectController@list')->name('list');
    Route::any('addproject' , 'ProjectController@addproject')->name('addproject');
    Route::any('addprojectst' , 'ProjectController@addprojectst')->name('addprojectst');
    Route::any('addprojectpost' , 'ProjectController@addprojectpost')->name('addprojectpost');
    Route::post('updatastatus' , 'ProjectController@updatastatus')->name('updatastatus');
    Route::any('gaidijia' , 'ProjectController@gaidijia')->name('gaidijia');
});


//日历
Route::group(['prefix'=>'calendar' , 'as'=>'calendar_'] , function(){
    Route::get('main' , 'CalendarController@main')->name('main');
    Route::get('eventdetails' , 'CalendarController@eventdetails')->name('eventdetails');
    Route::get('eventlist' , 'CalendarController@eventlist')->name('eventlist');
    Route::post('addcalendar' , 'CalendarController@addcalendar')->name('addcalendar');
    Route::post('updatestatus' , 'CalendarController@updatestatus')->name('updatestatus');
});


//财务管理
Route::group(['prefix'=>'finance' , 'as'=>'finance_'] , function(){
    Route::any('main' , 'FinanceController@main')->name('main');
    Route::get('fdetails' , 'FinanceController@fdetails')->name('fdetails');
});


//请假
Route::group(['prefix'=>'leave' , 'as'=>'leave_'] , function(){
    Route::get('main' , 'LeaveController@main')->name('main');
    Route::any('mainlist' , 'LeaveController@dailylist')->name('mainlist');
    Route::get('ldetails' , 'LeaveController@ldetails')->name('ldetails');
    Route::post('addldetails' , 'LeaveController@addldetails')->name('addldetails');
    Route::post('leavestatus' , 'LeaveController@leavestatus')->name('leavestatus');
});


//通知
Route::group(['prefix'=>'notice' , 'as'=>'notice_'] , function(){
    Route::get('main' , 'NoticeController@main')->name('main');
    Route::get('mainlist' , 'NoticeController@mainlist')->name('mainlist');
    Route::get('addnotice' , 'NoticeController@addnotice')->name('addnotice');
    Route::any('tz' , 'NoticeController@tz')->name('tz');
});
