<?php




Route::group(['prefix'=>'gate' , 'as'=>'gate_' ] , function(){
    Route::get('/' , 'SteinsGateController@index')->name('index');
});

//店长管理
Route::group(['prefix'=>'leading' , 'as'=>'leading_' , 'middleware'=>'h5store'] , function(){
    Route::get('/' , 'LeadingController@index')->name('index');
    Route::get('main' , 'LeadingController@main')->name('main');//首页
    Route::get('verify' , 'LeadingController@verify')->name('verify');//核销
    Route::get('verifylog' , 'LeadingController@verifylog')->name('verifylog');//核销记录
    Route::get('my' , 'LeadingController@my')->name('my');//我的


    Route::get('deposit' , ['uses'=>'LeadingController@deposit' , 'as'=>'deposit']);//保证金
    Route::get('depositdetail' , ['uses'=>'LeadingController@depositDetail' , 'as'=>'deposit_detail']);//保证金详情
    Route::post('depositdetail' , ['uses'=>'LeadingController@depositDetailPost' , 'as'=>'deposit_detail_post']);//账户余额

    Route::get('accountpage' , ['uses'=>'LeadingController@accountpage' , 'as'=>'accountpage']);//账户主页
    Route::get('recharge' , ['uses'=>'LeadingController@recharge' , 'as'=>'recharge']);//账户充值
    Route::post('luck', 'LeadingController@luckPost')->name('luck_post');//红包
    Route::post('merchantpost', 'LeadingController@merchantPost')->name('merchantpost');//红包

    Route::get('accountnum' , ['uses'=>'LeadingController@accountnum' , 'as'=>'accountnum']);//充值次数
    Route::get('accountuse' , ['uses'=>'LeadingController@accountuse' , 'as'=>'accountuse']);//账户余额
    Route::get('accountusedetail' , ['uses'=>'LeadingController@accountuseDetail' , 'as'=>'accountuse_detail']);//账户余额

    // Route::get('dorecharge' , ['uses'=>'LeadingController@doRecharge' , 'as'=>'do_recharge']);//账户充值

    Route::post('recharge' , ['uses'=>'LeadingController@rechargePost' , 'as'=>'recharge_post']);//账户充值处理
    Route::get('taken' , ['uses'=>'LeadingController@taken' , 'as'=>'taken']);//账户提现
    Route::post('taken' , ['uses'=>'LeadingController@takenPost' , 'as'=>'taken_post']);//账户提现处理
    Route::get('history' , ['uses'=>'LeadingController@history' , 'as'=>'history']);//历史记录
    Route::get('historydata' , 'LeadingController@historydata')->name('historydata');//店员

    Route::get('employees' , 'LeadingController@employees')->name('employees');//店员
    Route::post('employeedel' , 'LeadingController@employeeDel')->name('employee_del');//删除店员
    Route::post('employeermdev' , 'LeadingController@employeeRmdev')->name('employee_rmdev');//删除店员设备
    Route::post('employeeveri' , 'LeadingController@employeeVeri')->name('employee_veri');//删除店员设备

    Route::get('profile' , 'LeadingController@profile')->name('profile');//店铺信息
    Route::post('profile' , 'LeadingController@profilePost')->name('profile_post');//店铺信息
    Route::get('store','LeadingController@store')->name('store');
    Route::get('wechatstore','LeadingController@wechatStore')->name('wechatstore');//微信店铺
    Route::post('createshops' , 'LeadingController@createShops')->name('createshops');//店铺信息

    Route::get('card' , 'LeadingController@card')->name('card');//卡券
    Route::get('cardadd' , 'LeadingController@cardAdd')->name('card_add');//卡券
    Route::post('cardadd' , 'LeadingController@cardAddPost')->name('card_add_post');//卡券添加
    Route::post('cardedit' , 'LeadingController@cardEditPost')->name('card_edit_post');//卡券编辑
    Route::get('cardallot' , 'LeadingController@cardAllot')->name('card_allot');//分配卡券
    Route::get('cardreallot' , 'LeadingController@cardReAllot')->name('card_reallot');//增加分配卡券
    Route::post('cardallot' , 'LeadingController@cardAllotPost')->name('card_allot_post');//卡券
    Route::post('cardcustomcode' , 'LeadingController@cardCustomCode')->name('card_custom_code');//卡券
    Route::get('cardprice' , 'LeadingController@cardPrice')->name('card_price');//设置佣金
    Route::post('cardprice' , 'LeadingController@cardPricePost')->name('card_price_post');//设置佣金
    Route::any('cardyincang' , 'LeadingController@cardyincang')->name('cardyincang');//设置佣金


    Route::get('cardinfo' , 'LeadingController@cardInfo')->name('card_info');//卡券
    Route::get('carddetails' , 'LeadingController@cardDetails')->name('card_details');//卡券
    Route::post('cardstatus' , 'LeadingController@cardStatus')->name('card_status');//卡券状态
    Route::post('cardnum' , 'LeadingController@cardNum')->name('card_num');//卡券库存

    Route::any('cardverify' , 'LeadingController@cardVerify')->name('card_verify');//卡券核销

    Route::get('dev', 'LeadingController@dev')->name('dev');//设备
    Route::get('devadd', 'LeadingController@devAdd')->name('dev_add');//设备
    Route::post('devpost', 'LeadingController@devPost')->name('dev_post');//设备
    Route::any('wxenter', 'LeadingController@wxenter')->name('wxenter');//设备


    Route::any('cardtop', 'LeadingController@cardTop')->name('card_top');//异业
    Route::get('yiye', 'LeadingController@yiye')->name('yiye');//异业
    Route::post('yiye', 'LeadingController@yiyePost')->name('yiye_post');//异业

    Route::any('kol', 'LeadingController@kol')->name('kol');//达人

    Route::get('data', 'LeadingController@data')->name('data');//数据
    Route::get('datainfo1', 'LeadingController@datainfo1')->name('datainfo1');//数据
    Route::get('datainfo2', 'LeadingController@datainfo2')->name('datainfo2');//数据
    Route::get('datainfo3', 'LeadingController@datainfo3')->name('datainfo3');//数据
    Route::get('datainfo4', 'LeadingController@datainfo4')->name('datainfo4');//数据

    Route::get('datadetail1', 'LeadingController@dataDetail1')->name('data_detail1');//数据详情

    Route::get('datadetail2', 'LeadingController@dataDetail2')->name('data_detail2');//数据详情

    Route::any('datadetadianji', 'LeadingController@datadetadianji')->name('data_detadianji');//点击详情
    Route::any('datadetazh', 'LeadingController@datadetazh')->name('data_detazh');//转换详情

    Route::any('datadetadianji1', 'LeadingController@datadetadianji1')->name('data_detadianji1');//本店点击
    Route::any('datadetazh1', 'LeadingController@datadetazh1')->name('data_detazh1');//本店转化
    Route::any('datadetail1z', 'LeadingController@datadetail1z')->name('data_detail1z');//本店转化
    Route::any('datadetazh2', 'LeadingController@datadetazh2')->name('data_detazh2');//转化
    Route::any('dataliulan', 'LeadingController@dataliulan')->name('data_liulan');//转化

    Route::any('datayin', 'LeadingController@datayin')->name('data_yin');//数据引入、引出
    Route::any('datayinxx', 'LeadingController@datayinxx')->name('data_yinxx');//数据引入、引出详细

    Route::post('writeofffee', 'LeadingController@writeoffFee')->name('writeofffee');//核销费充值
    Route::get('equipment', 'LeadingController@equipment')->name('equipment');//POS机查看设备
    Route::any('posout', 'LeadingController@posout')->name('posout');//POS退出

    Route::get('datadetails', 'LeadingController@dataDetails')->name('datadetails');//POS退出
    Route::get('purchase', 'LeadingController@purchase')->name('purchase');//内购
    Route::post('purchasepost', 'LeadingController@purchasepost')->name('purchasepost');//内购
    Route::post('pospost', 'LeadingController@pospost')->name('pospost');//申请pos机

    Route::any('probation', 'LeadingController@probation')->name('probation');//试用
    Route::get('applypos', 'LeadingController@applypos')->name('applypos');//POS机申请

    Route::any('kolveri', 'LeadingController@kolveri')->name('kolveri');//开启达人核销

    Route::any('hxgoods', 'LeadingController@hxgoods')->name('hxgoods');//核销商品
    Route::any('goodspost', 'LeadingController@goodspost')->name('goodspost');//商品价格提交
    Route::get('fujinshop', 'LeadingController@fujinShop')->name('fujinshop');//附近的店

    //店铺数据详情页
    Route::any('fkgpdetails', 'LeadingController@fkgpDetails')->name('fkgpdetails');
    Route::any('guokedetails', 'LeadingController@guokeDetails')->name('guokedetails');
    Route::any('huobandetails', 'LeadingController@huobandetails')->name('huobandetails');
    Route::any('kolliudetails', 'LeadingController@kolliudetails')->name('kolliudetails');
    Route::any('kollingdetails', 'LeadingController@kollingdetails')->name('kollingdetails');
    Route::any('kaquan', 'LeadingController@kaquan')->name('kaquan');
    Route::any('gongxiankl', 'LeadingController@gongxiankl')->name('gongxiankl');
    Route::any('ziyouqudao', 'LeadingController@ziyouqudao')->name('ziyouqudao');
    Route::any('yiyequdao', 'LeadingController@yiyequdao')->name('yiyequdao');
    Route::any('darengongxian', 'LeadingController@darengongxian')->name('darengongxian');
    Route::any('lianmengkeliu', 'LeadingController@lianmengkeliu')->name('lianmengkeliu');

});



//店员管理
Route::group(['prefix'=>'employee' , 'as'=>'employee_'] , function(){
    Route::get('/' , 'EmployeeController@index')->name('index');
    Route::get('main' , 'EmployeeController@main')->name('main');
    Route::get('verify' , 'EmployeeController@verify')->name('verify');
    Route::get('profile' , 'EmployeeController@profile')->name('profile');
    Route::post('profile' , 'EmployeeController@profileUpdate')->name('profile_update');
    Route::any('cardverify' , 'EmployeeController@cardVerify')->name('card_verify');
    Route::any('data' , 'EmployeeController@data')->name('data');
    Route::any('data1' , 'EmployeeController@data1')->name('data1');
    Route::any('data2' , 'EmployeeController@data2')->name('data2');
    Route::any('data3' , 'EmployeeController@data3')->name('data3');


});


//消费者
Route::group(['prefix'=>'buyer' , 'as'=>'buyer_'] , function(){
    Route::get('cardshow' , 'BuyerController@cardShow')->name('card_show');//领取卡券
});

//店铺页面
Route::group(['prefix'=>'store' , 'as'=>'store_'] , function(){
    Route::get('/' , 'StoreController@index')->name('index');
    Route::any('main' , 'StoreController@main')->name('main');//店铺主页
    Route::get('mainhost' , 'StoreController@mainHost')->name('main_host');//店铺卡券

    Route::get('enterbyshake' , 'StoreController@enterByShake')->name('enter_byshake');//摇一摇统一入口/devsn
    Route::get('register' , 'StoreController@register')->name('register');
    Route::get('registerbyshake' , 'StoreController@registerByShake')->name('register_byshake');
    Route::post('register' , 'StoreController@registerPost')->name('register_post');
    // Route::get('recruit' , 'StoreController@recruit')->name('recruit');

    Route::get('employeesbind' , 'StoreController@employeesbind')->name('employeesbind');//店员
    Route::post('employeesbind' , 'StoreController@employeesbindPost')->name('employeesbind_post');//店员

    Route::get('cardget' , 'StoreController@cardGet')->name('card_get');//领取卡券
    Route::post('cardwxget' , 'StoreController@cardWxGet')->name('card_wxget');//领取卡券

    Route::get('changeown' , 'StoreController@changeOwn')->name('change_own');//更改店长
    Route::post('changeown' , 'StoreController@changeOwnPost')->name('change_own_post');//更改店长

    // Route::any('sao','StoreController@sao')->name('sao');

    Route::get('kol' , 'StoreController@kol')->name('kol');//达人
    Route::get('kolbind' , 'StoreController@kolbind')->name('kolbind');//达人入驻
    Route::post('kolbind' , 'StoreController@kolbindPost')->name('kolbind_post');//达人入驻
    Route::any('koldata' , 'StoreController@koldata')->name('koldata');//达人入驻
    Route::any('wxregisterpost' , 'StoreController@wxregisterpost')->name('wxregisterpost');//绑定管理
    Route::any('wxregister' , 'StoreController@wxregister')->name('wxregister');

    Route::any('execwxenter', 'StoreController@execWxenter')->name('execwxenter');//设备

    Route::get('posenter', 'StoreController@posEnter')->name('pos_enter');//设备登录


    Route::any('poswxenter' , 'StoreController@posWxenter')->name('poswxenter');
    Route::post('registerpost' , 'StoreController@posregisterPost')->name('registerpost');
    Route::get('regulations' , 'StoreController@regulations')->name('regulations');
    Route::get('agreement' , 'StoreController@agreement')->name('agreement');
    Route::get('sofaudit' , 'StoreController@sofAudit')->name('sofaudit');

    Route::get('execregister' , 'StoreController@execregister')->name('execregister');//exec品牌商注册
    Route::post('execregisterpost' , 'StoreController@execregisterpost')->name('execregisterpost');
    Route::post('execregistername' , 'StoreController@execregistername')->name('execregistername');
    Route::any('kollq' , 'StoreController@kollq')->name('kollq');
    Route::any('guanzhu' , 'StoreController@guanzhu')->name('guanzhu');
    Route::get('success' , 'StoreController@success')->name('success');
    Route::any('guanzhu1' , 'StoreController@guanzhu1')->name('guanzhu1');
    Route::any('fenxi' , 'StoreController@fenxi')->name('fenxi');
    Route::any('yiyedj' , 'StoreController@yiyedj')->name('yiyedj');
    //达人会员卡-附近的店
    Route::any('storelistbycity', 'StoreController@storeListByCity')->name('storelistbycity');
    //店铺主页定位修改达人所在城市
    Route::post('shopkol' , 'StoreController@shopKol')->name('shopkol');
});


//员工页面
Route::group(['prefix'=>'person' , 'as'=>'person_'] , function(){
    Route::get('/' , 'PersonController@index')->name('index');
    Route::any('main' , 'PersonController@main')->name('main');
});


//达人
Route::group(['prefix'=>'kol' , 'as'=>'kol_' , 'middleware'=>'h5kol'] , function(){
    Route::get('/' , 'KolController@index')->name('index');
    Route::any('main' , 'KolController@main')->name('main');//首页
    Route::get('near' , 'KolController@near')->name('near');//附近卡券
    Route::post('near' , 'KolController@nearPost')->name('near_post');//附近卡券
    Route::get('board' , 'KolController@board')->name('board');//我的主页
    Route::get('analysis' , 'KolController@analysis')->name('analysis');//附近卡券
    Route::get('analysiscarddetail' , 'KolController@analysisCardDetail')->name('analysis_card_detail');//附近卡券

    Route::get('account' , 'KolController@account')->name('account');//附近卡券
    Route::get('accountdetail' , 'KolController@accountDetail')->name('account_detail');//附近卡券

    Route::post('luck', 'KolController@luckPost')->name('luck_post');//红包
    Route::get('homepage', 'KolController@homepage')->name('homepage');//红包
    Route::get('mingxi', 'KolController@mingxi')->name('mingxi');//明细
    Route::post('merchantpost', 'KolController@merchantPost')->name('merchantpost');//红包

    //数据修改
    Route::get('datamodification', 'KolController@dataModification')->name('datamodification');
    Route::any('datamodificaupload', 'KolController@dataModificaupload')->name('datamodificaupload');

    //会员卡
    Route::any('memberall', 'KolController@memberall')->name('memberall');
    Route::post('memberadd', 'KolController@memberAdd')->name('memberadd');
    Route::post('memberdel', 'KolController@memberDel')->name('memberdel');
    Route::any('receive', 'KolController@receive')->name('receive');
    Route::any('receives', 'KolController@receives')->name('receives');
    Route::any('kolgrade', 'KolController@kolGrade')->name('kolgrade');

    //开启达人核销
    Route::any('verify', 'KolController@verify')->name('verify');
    Route::any('cardverify', 'KolController@cardverify')->name('card_verify');

    //从会员卡跳过来的页面
    //达人会员卡-推广赚钱
    Route::any('tuiguang', 'KolController@tuiguang')->name('tuiguang');
    //达人会员卡-附近的店
    Route::any('getStoreByCity', 'KolController@getStoreByCity')->name('getStoreByCity');
    //达人会员卡-省钱
    Route::any('fujin', 'KolController@fujin')->name('fujin');
    //达人会员卡-等级
    Route::any('level', 'KolController@level')->name('level');
    //佣金明细
    Route::any('comdetails', 'KolController@comdetails')->name('comdetails');

    //分享券，分享卡
    Route::get('sharevoucher', 'KolController@shareVoucher')->name('sharevoucher');
    Route::get('sharecard', 'KolController@shareCard')->name('sharecard');

    //券详情
    Route::get('calculation', 'KolController@calculation')->name('calculation');
    Route::get('record', 'KolController@record')->name('record');

    //领取会员卡的时候判断他是否是该会员卡的上级
    Route::any('judsuper', 'KolController@judsuper')->name('judsuper');

    //判断可否推广
    Route::any('kolpan', 'KolController@kolpan')->name('kolpan');

    //交易记录
    Route::get('kolrecord', 'KolController@kolrecord')->name('kolrecord');

    //分享
    Route::any('fenxi', 'KolController@fenxi')->name('fenxi');

    //异业点击
    Route::any('yiyedj', 'KolController@yiyedj')->name('yiyedj');

    //异业点击
    Route::get('autokol', 'KolController@autoKol')->name('autokol');
    Route::post('autokolpost', 'KolController@autoKolpost')->name('autokolpost');

    //灰色领卡提示
    Route::get('cardsuccess', 'KolController@cardSuccess')->name('cardsuccess');

    Route::get('packingcard', 'KolController@packingcard')->name('packingcard');

    Route::get('receivefujin', 'KolController@receiveFujin')->name('receivefujin');

    Route::get('daohang', 'KolController@daohang')->name('daohang');


});

//系统处理
Route::group(['prefix'=>'process' , 'as'=>'process_'] , function(){
    Route::any('picupload' , 'ProcessController@picUpload')->name('pic_upload');
    Route::any('pic' , 'ProcessController@picUp')->name('pic');
    Route::any('file' , 'ProcessController@fileUp')->name('file');
    Route::any('savepic' , 'ProcessController@savePic')->name('save_pic');
    Route::any('wxreturn' , 'ProcessController@wxPayReturn')->name('wx_pay_return');
    Route::any('zlog' , 'ProcessController@zlog')->name('zlog');


    Route::any('getcard' , 'ProcessController@buyerGetCard')->name('get_card');
    Route::any('getwxcard' , 'ProcessController@buyerWxCard')->name('get_wx_card');
    Route::any('getqrcard' , 'ProcessController@buyerQrCard')->name('get_qr_card');



    Route::any('success' , 'ProcessController@success')->name('success');
    Route::any('error' , 'ProcessController@error')->name('error');
    Route::any('guanzhu' , 'ProcessController@guanzhu')->name('guanzhu');

    Route::any('notify' , 'ProcessController@wxNotify')->name('wx_notify');

    Route::any('downfile' , 'ProcessController@downFile')->name('down_file');

    Route::any('help' , 'ProcessController@help')->name('help');
    Route::any('packingcard', 'ProcessController@packingcard')->name('packingcard');//卡券包装
    Route::post('packingcache', 'ProcessController@packingCache')->name('packingcache');//卡券包装

    // Route::any('pp' , 'ProcessController@pp')->name('pp');
    // 判断是否为黑卡
    Route::post('judge' , 'ProcessController@judge')->name('judge');

    Route::any('fenxi', 'ProcessController@fenxi')->name('fenxi');//卡券包装

    Route::any('external', 'ProcessController@external')->name('external');//卡券包装

    Route::any('automaticlowerframe', 'ProcessController@automaticLowerFrame')->name('automaticlowerframe');//卡券下架
    Route::any('sendcode' , 'ProcessController@sendCode')->name('sendcode');

    Route::any('reportform' , 'ProcessController@reportform')->name('reportform');//定时发送佣金报表
    Route::any('send' , 'ProcessController@send')->name('send');//邮件
    Route::any('externaldianji' , 'ProcessController@externaldianji')->name('externaldianji');//邮件
});
