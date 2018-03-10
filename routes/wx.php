<?php



Route::any('auth' , 'MainController@auth')->name('auth');
Route::any('authmember' , 'MainController@authMember')->name('auth_member');
Route::any('authmember1' , 'MainController@authMember1')->name('auth_member1');
Route::any('clear' , 'MainController@clear')->name('clear');

//-----------------
Route::any('token' , 'MainController@token')->name('token');
Route::any('page' , 'MainController@page')->name('page');


//-----------------
Route::get('aaa','MainController@aa')->name('aaa');

Route::group(['prefix'=>'notify' , 'as'=>'notify_'] , function(){
    Route::any('paynum' , 'NotifyController@payNum')->name('pay_num');//充值次数
    Route::any('payad' , 'NotifyController@payAd')->name('pay_ad');//推广
    Route::any('paypur' , 'NotifyController@payPur')->name('pay_pur');//推广
    Route::any('paypos' , 'NotifyController@payPos')->name('pay_pos');//推广

});



Route::any('wx','MainController@wx');
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


Route::any('shake','MainController@shake')->name('shake');//门店


Route::any('/{$str}','MainController@main');
