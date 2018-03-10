<?php

//剑客

//index
Route::get('/' , 'IndexController@indexs');
Route::any('login' , 'IndexController@login')->name('login');
Route::any('loginpost' , 'IndexController@loginPost')->name('loginpost');
Route::any('wxenter' , 'IndexController@wxenter')->name('wxenter');
Route::any('loginposts' , 'IndexController@loginPosts')->name('loginposts');

//首页品牌商数据
Route::group(['prefix'=>'executive' , 'as'=>'executive_'] , function(){
    Route::get('index' , 'IndexController@index')->name('index');

});


//互动街
Route::group(['prefix'=>'street' , 'as'=>'street_'] , function(){
    Route::get('shoplist' , 'StreetController@shopList')->name('shoplist');
    Route::get('clerklist' , 'StreetController@clerkList')->name('clerklist');
    Route::get('peoplelist' , 'StreetController@peopleList')->name('peoplelist');
    Route::get('details' , 'StreetController@details')->name('details');
    Route::get('drcode' , 'StreetController@drcode')->name('drcode');
    Route::get('makedrqcode' , 'StreetController@makedrqcode')->name('makedrqcode');
    Route::get('createxecl' , 'StreetController@createxecl')->name('createxecl');

});


//数据概览
Route::group(['prefix'=>'data' , 'as'=>'data_'] , function(){
    Route::get('main' , 'DataController@main')->name('main');
    Route::get('allstores' , 'DataController@allStores')->name('allstores');
    Route::get('flow' , 'DataController@flow')->name('flow');
    Route::get('drainage' , 'DataController@drainage')->name('drainage');
    Route::get('card' , 'DataController@card')->name('card');
    Route::get('code' , 'DataController@code')->name('code');
    Route::get('lingqu' , 'DataController@lingqu')->name('lingqu');
    Route::get('introductiondata' , 'DataController@introductionData')->name('introductiondata');
    Route::get('master' , 'DataController@Master')->name('master');
    Route::get('recommend' , 'DataController@Recommend')->name('recommend');
    Route::any('createxecl' , 'DataController@createxecl')->name('createxecl');
});



//卡券
Route::group(['prefix'=>'card' , 'as'=>'card_'] , function(){
    Route::get('list' , 'CardController@list')->name('list');
    Route::get('main' , 'CardController@main')->name('main');
    Route::post('cardAddPost', 'CardController@cardAddPost')->name('cardAddPost');
    Route::post('carddistribution', 'CardController@cardDistribution')->name('carddistribution');
    Route::post('cardcreate', 'CardController@cardCreate')->name('cardcreate');
    Route::post('carddel', 'CardController@cardDel')->name('carddel');

    Route::get('advert' , 'CardController@advert')->name('advert');
    Route::post('advertdel' , 'CardController@advertdel')->name('advertdel');
    Route::post('advertadd' , 'CardController@advertadd')->name('advertadd');
});


//核销商品
Route::group(['prefix'=>'goods' , 'as'=>'goods_'] , function(){
    Route::get('goods' , 'GoodsController@goods')->name('goods');
    Route::post('goodsadd' , 'GoodsController@goodsadd')->name('goodsadd');
    Route::any('goodsdel' , 'GoodsController@goodsdel')->name('goodsdel');
});


//会员卡
Route::group(['prefix'=>'member' , 'as'=>'member_'] , function(){
    Route::get('main' , 'MemberCardController@main')->name('main');
    Route::get('modify' , 'MemberCardController@modify')->name('modify');
    Route::post('modifypost' , 'MemberCardController@modifyPost')->name('modifypost');
    Route::post('modifydelete' , 'MemberCardController@modifyDelete')->name('modifydelete');

    Route::post('pic' , 'MemberCardController@picUp')->name('pic');//图片上传
});


//订单
Route::group(['prefix'=>'recharge' , 'as'=>'recharge_'] , function(){
    Route::get('commodity' , 'RechargeController@commodity')->name('commodity');
    Route::get('details' , 'RechargeController@details')->name('details');
    Route::any('createxecl' , 'RechargeController@createxecl')->name('createxecl');
    Route::any('ajaxmian' , 'RechargeController@ajaxmian')->name('ajaxmian');
    Route::any('ajaxsou' , 'RechargeController@ajaxsou')->name('ajaxsou');
});


//账户
Route::group(['prefix'=>'account' , 'as'=>'account_'] , function(){
    Route::get('income', 'AccountController@income')->name('income');
    Route::get('defray', 'AccountController@defray')->name('defray');
    Route::get('voucher', 'AccountController@voucher')->name('voucher');
    Route::post('voucherpost', 'AccountController@voucherPost')->name('voucherpost');
    Route::get('detailed', 'AccountController@detailed')->name('detailed');
    Route::any('ajaxicome', 'AccountController@ajaxicome')->name('ajaxicome');
    Route::any('aicome', 'AccountController@aicome')->name('aicome');
    Route::any('ajaxdetaild', 'AccountController@ajaxdetaild')->name('ajaxdetaild');
    Route::any('detaileddian', 'AccountController@detaileddian')->name('detaileddian');
    Route::any('createxecl', 'AccountController@createxecl')->name('createxecl');
});


//用户
Route::group(['prefix'=>'user' , 'as'=>'user_'] , function(){
    Route::any('user' , 'UserController@user')->name('user');
    Route::any('createuser' , 'UserController@createuser')->name('createuser');
    Route::any('useradd' , 'UserController@useradd')->name('useradd');
    Route::post('carddistribution' , 'UserController@carddistribution')->name('carddistribution');
    Route::post('cardcreate' , 'UserController@cardcreate')->name('cardcreate');
    Route::post('carddel' , 'UserController@carddel')->name('carddel');

});

//概况
Route::group(['prefix'=>'survey' , 'as'=>'survey_'] , function(){
    Route::any('index' , 'SurveyController@index')->name('index');
});
