<?php

//运营

//index
// Route::get('/' , 'AdminController@index');
Route::get('/',function(){
    return redirect()->route('manage_street_main');
});

Route::get('login' , 'AdminController@login')->name('login');
Route::post('login' , 'AdminController@loginPost')->name('login_post');

Route::group(['prefix'=>'shake' , 'as'=>'shake_'] , function(){
    Route::get('/' , 'ShakeController@index')->name('index');
    Route::get('main' , 'ShakeController@main')->name('main');
    Route::get('shakepage' , 'ShakeController@shakepage')->name('shakepage');
    Route::get('shakepageadd' , 'ShakeController@shakepageAdd')->name('shakepage_add');
    Route::get('shakepageedit' , 'ShakeController@shakepageEdit')->name('shakepage_edit');
    Route::get('shakebind' , 'ShakeController@shakeBind')->name('bind');
    Route::post('shakebind' , 'ShakeController@shakeBindPost')->name('bind_post');
    Route::post('updatecomment' , 'ShakeController@updateComment')->name('update_comment');
    Route::post('shakepageadd' , 'ShakeController@shakepageAddPost')->name('shakepage_add_post');
    Route::post('shakepageedit' , 'ShakeController@shakepageEditPost')->name('shakepage_edit_post');
    Route::post('getshakes' , 'ShakeController@getShakes')->name('get_shakes');
    Route::post('getshakepages' , 'ShakeController@getShakePages')->name('get_shake_pages');
    Route::post('devicetopage' , 'ShakeController@deviceToPage')->name('device_to_page');
    Route::post('pagetodevice' , 'ShakeController@pageToDevice')->name('page_to_device');
    Route::post('viewpage' , 'ShakeController@viewPage')->name('view_page');
    Route::any('devprocess' , 'ShakeController@devProcess')->name('dev_process');

    Route::any('posrecord' , 'ShakeController@posRecord')->name('posrecord');//pos登录记录
    Route::any('posout' , 'ShakeController@posout')->name('posout');//pos登录记录
    Route::any('qrcodelist' , 'ShakeController@qrCodeList')->name('qrcodelist');//pos登录记录

    //二维码
    Route::post('shakepageformadd' , 'ShakeController@shakepageformAdd')->name('shakepageformadd');
    Route::get('shakeforms' , 'ShakeController@shakeforms')->name('shakeforms');
    Route::post('shakeformsadd' , 'ShakeController@shakeformsAdd')->name('shakeformsadd');
    Route::any('qrcodeform' , 'ShakeController@qrcodeForm')->name('qrcodeform');
    Route::any('qrcoderwm' , 'ShakeController@qrcodeRwm')->name('qrcoderwm');  
});


Route::group(['prefix'=>'card' , 'as'=>'card_'] , function(){
    Route::get('/' , 'CardController@index')->name('index');
    Route::get('main' , 'CardController@main')->name('main');
    Route::get('code' , 'CardController@code')->name('code');
    Route::get('details' , 'CardController@details')->name('details');
    Route::get('advert' , 'CardController@advert')->name('advert');
    Route::post('advertadd' , 'CardController@advertadd')->name('advertadd');
    Route::post('advertdel' , 'CardController@advertdel')->name('advertdel');
    Route::get('advertst' , 'CardController@advertst')->name('advertst');
    Route::post('cardaddpost' , 'CardController@cardAddPost')->name('cardaddpost');
});


Route::group(['prefix'=>'executive' , 'as'=>'executive_'] , function(){
    Route::get('/' , 'ExecutiveController@index')->name('index');
    Route::get('main' , 'ExecutiveController@main')->name('main');
    Route::any('street' , 'ExecutiveController@street')->name('street');
    Route::any('store' , 'ExecutiveController@store')->name('store');
    Route::any('storeauthority' , 'ExecutiveController@storeAuthority')->name('storeauthority');
    Route::any('streetauthority' , 'ExecutiveController@streetAuthority')->name('streetauthority');
    Route::any('add' , 'ExecutiveController@add')->name('add');
    Route::any('addpost' , 'ExecutiveController@addpost')->name('addpost');
    Route::post('updatermarks' , 'ExecutiveController@updateRmarks')->name('updatermarks');

});


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

Route::group(['prefix'=>'shop' , 'as'=>'shop_'] , function(){
    Route::get('/' , 'ShopController@index')->name('index');
    Route::get('main' , 'ShopController@main')->name('main');
    Route::get('employee' , 'ShopController@employee')->name('employee');//店员
    Route::get('kol' , 'ShopController@kol')->name('kol');//店员

    Route::post('changestreet' , 'ShopController@changeStreet')->name('change_street');

    Route::get('bindshake' , 'ShopController@bindShake')->name('bind_shake');//商户绑定设备
    Route::post('bindshake' , 'ShopController@bindShakePost')->name('bind_shake_post');//商户绑定设备

    Route::get('details' , 'ShopController@details')->name('details');
    Route::get('modify' , 'ShopController@modify')->name('modify');
    Route::get('deleteShop' , 'ShopController@deleteShop')->name('deleteShop');
    Route::any('examine' , 'ShopController@examine')->name('examine');//审核
    Route::any('editexamine' , 'ShopController@editexamine')->name('editexamine');//审核
});

Route::group(['prefix'=>'recharge' , 'as'=>'recharge_'] , function(){
    Route::resource('goods', 'GoodsRechargeReController');
    Route::resource('shop', 'ShopRechargeReController');
    Route::resource('order', 'OrderRechargeReController');
    Route::resource('luck', 'LuckReController');
    Route::get('promotionfee', 'PromotionFeeController@index')->name('promotionfee');
    Route::get('details', 'PromotionFeeController@details')->name('details');
    Route::get('detailed', 'PromotionFeeController@detailed')->name('detailed');
    Route::get('merchant', 'PromotionFeeController@merchant')->name('merchant');
    Route::get('purchase', 'PromotionFeeController@purchase')->name('purchase');
    Route::get('paypos', 'PromotionFeeController@paypos')->name('paypos');
    Route::get('payposdetails', 'PromotionFeeController@payposDetails')->name('payposdetails');
    Route::post('payposmodify', 'PromotionFeeController@payposModify')->name('payposmodify');
    Route::get('commodity', 'CommodityController@commodity')->name('commodity');
    Route::get('cdetails', 'CommodityController@Cdetails')->name('cdetails');

});


Route::group(['prefix'=>'data' , 'as'=>'data_'] , function(){
    Route::get('/' , 'DataController@index')->name('index');
    Route::get('pv' , 'DataController@pv')->name('pv');
});

Route::group(['prefix'=>'user' , 'as'=>'user_'] , function(){
    Route::get('/' , 'UserController@index')->name('index');
    Route::get('wechat' , 'UserController@wechat')->name('wechat');//微信用户
    Route::post('wechat' , 'UserController@wechatPost')->name('wechat_post');//微信用户
    Route::post('wechats' , 'UserController@wechatPosts')->name('wechats');//微信用户
    Route::post('search' , 'UserController@search')->name('search');
    Route::post('searchpagination' , 'UserController@searchPagination')->name('searchpagination');
    Route::post('sortingdata' , 'UserController@sortingData')->name('sortingdata');
    Route::post('sortingpagination' , 'UserController@sortingPagination')->name('sortingpagination');
});

Route::group(['prefix'=>'system' , 'as'=>'system_'] , function(){
    Route::get('/' , 'SystemController@index')->name('index');
    Route::get('text' , 'SystemController@text')->name('text');//
    Route::post('text' , 'SystemController@textPost')->name('text_post');//
    Route::get('textadd' , 'SystemController@textAdd')->name('text_add');//
    Route::post('textadd' , 'SystemController@textAddPost')->name('text_add_post');//

    Route::get('pic' , 'SystemController@pic')->name('pic');//

    Route::get('logs' , 'SystemController@logs')->name('logs');//

});


Route::group(['prefix' => 'process' , 'as' => 'process_'] , function(){
    // Route::any('upload' , ['uses' => 'BaseAdminController@upload' , 'as' => 'upload']);
    Route::any('keupload' , ['uses' => 'BaseAdminController@kindEditorUpload' , 'as' => 'keupload']);
    Route::any('kefile' , ['uses' => 'BaseAdminController@kindEditorFile' , 'as' => 'kefile']);
    Route::any('pagesidebar' , ['uses' => 'BaseAdminController@pageSidebar' , 'as' => 'pagesidebar']);
    Route::any('statuscheck' , ['uses' => 'BaseAdminController@statuscheck' , 'as' => 'statuscheck']);
    Route::any('wxmember' , ['uses' => 'BaseAdminController@wxmember' , 'as' => 'wxmember']);
});


Route::group(['prefix'=>'member' , 'as'=>'member_'] , function(){
    Route::get('main' , 'MemberController@main')->name('main');
    Route::get('modify' , 'MemberController@modify')->name('modify');
    Route::any('modifypost' , 'MemberController@modifyPost')->name('modifypost');
    Route::post('modifydelete' , 'MemberController@modifyDelete')->name('modifydelete');

    Route::any('pic' , 'MemberController@picUp')->name('pic');
});

//
Route::group(['prefix'=>'commodity' , 'as'=>'commodity_'] , function(){
    Route::get('main', 'CommodityController@main')->name('main');
});

//账户
Route::group(['prefix'=>'account' , 'as'=>'account_'] , function(){
    Route::get('auditing', 'AccountController@auditing')->name('auditing');
    Route::get('defray', 'AccountController@defray')->name('defray');
    Route::any('shouru', 'AccountController@shouru')->name('shouru');
    Route::get('datails', 'AccountController@datails')->name('datails');
    Route::any('datailsget', 'AccountController@datailsget')->name('datailsget');
    Route::get('detailed', 'AccountController@detailed')->name('detailed');
    Route::any('comdetails', 'AccountController@comdetails')->name('comdetails');
});

//品牌商
Route::group(['prefix'=>'operate' , 'as'=>'operate_'] , function(){
    Route::get('main' , 'OperateController@main')->name('main');
    Route::any('store' , 'OperateController@store')->name('store');
});