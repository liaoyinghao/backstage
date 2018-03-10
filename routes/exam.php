<?php


Route::get('aaa','MainController@aa')->name('aaa');


Route::any('wx','MainController@wx');
Route::any('abb','MainController@abb');
Route::any('acc','MainController@acc');
Route::any('wxcard2','MainController@wxCard2');
Route::any('wxuser','MainController@user');
Route::any('wxuserb','MainController@userBusiness');
Route::any('wxusers','MainController@userScopes')->name('sc');
Route::any('wxuserba','MainController@userBack');
Route::any('wxconfig','MainController@configs');
Route::any('pay','MainController@pay');//公众号支付
Route::any('notify','MainController@notify');

Route::any('bpay','MainController@bpay');//企业支付
Route::any('luck','MainController@luck')->name('luck');//红包
Route::any('card','MainController@card')->name('card');//卡券
Route::any('shop','MainController@shop')->name('shop');//门店
Route::any('analysis','MainController@analysis')->name('analysis');//门店
Route::any('device','MainController@device')->name('device');//门店
Route::any('group','MainController@shakeGroup')->name('group');//门店
Route::any('log','MainController@log')->name('log');//日志


Route::any('shake','MainController@shake')->name('shake');//门店
Route::any('xml','MainController@xml')->name('xml');//门店
Route::any('gps','MainController@gps')->name('gps');//门店


Route::any('/{$str}','MainController@main');

Route::any('pntceshi','MainController@pntceshi')->name('pntceshi');//创建微信门店

Route::any('gettext','MainController@gettext')->name('gettext');//获取微信门店信息

Route::any('change','MainController@change')->name('change');//修改微信门店

Route::any('list','MainController@list')->name('list');//获取微信门店列表

Route::any('del','MainController@del')->name('del');//删除微信门店

Route::any('qianyi','MainController@qianyi')->name('qianyi');//删除微信门店

Route::any('cardpricepost','MainController@cardpricepost')->name('cardpricepost');//删除微信门店
Route::any('paymentResult','MainController@paymentResult')->name('paymentResult');//删除微信门店


Route::any('paymentresults_s', 'MainController@paymentResults')->name('paymentresults_s');//接收pos信息

Route::any('merchantpay', 'MainController@merchantpay')->name('merchantpay');//测试企业

Route::any('getmer', 'MainController@getmer')->name('getmer');


Route::any('creatsql', 'MainController@creatsql')->name('creatsql');
Route::any('getpos', 'MainController@getpos')->name('getpos');

Route::any('notice', 'MainController@notice')->name('notice');

Route::any('tupian', 'MainController@tupian')->name('tupian');


Route::any('loadingpage', 'MainController@loadingpage')->name('loadingpage');

Route::any('automaticlowerframe', 'MainController@automaticLowerFrame')->name('automaticlowerframe');
Route::any('reportform', 'MainController@reportform')->name('reportform');
Route::any('star', 'MainController@star')->name('star');
Route::any('xiugai', 'MainController@xiugai')->name('xiugai');






//视图测试
Route::group(['prefix'=>'view' , 'as'=>'view_'] , function(){
    Route::any('kol', 'ViewController@kol')->name('kol');

});
