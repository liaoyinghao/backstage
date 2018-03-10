<?php

return [
    'executive'=>[
        'name'=>'品牌商',
        'icon'=>'icon iconfont icon-pinpaishang',
        'son'=>[
            'main'=>[
                'name'=>'品牌商列表',
                'url'=>'main'
            ],
        ]
    ],

    // 'operate'=>[
    //     'name'=>'运营商',
    //     'icon'=>'icon iconfont icon-yunyingshang',
    //     'son'=>[
    //         'main'=>[
    //             'name'=>'运营商列表',
    //             'url'=>'main'
    //         ],
    //     ]
    // ],

    'street'=>[
        'name'=>'商街',
        'icon'=>'icon-direction',
        'son'=>[
            'main'=>[
                'name'=>'商街列表',
                'url'=>'main'
            ],
        ]
    ],

    'shop'=>[
        'name'=>'店铺',
        'icon'=>'icon-users',
        'son'=>[
            'main'=>[
                'name'=>'店铺列表',
                'url'=>'main'
            ],
            'employee'=>[
                'name'=>'店员列表',
                'url'=>'employee'
            ],
            'kol'=>[
                'name'=>'达人列表',
                'url'=>'kol'
            ],
            'examine'=>[
                'name'=>'店铺审核',
                'url'=>'examine'
            ],
        ]
    ],

    'shake'=>[
        'name'=>'设备',
        'icon'=>'icon-drawer',
        'son'=>[
            'main'=>[
                'name'=>'设备列表',
                'url'=>'main'
            ],
            'posrecord'=>[
                'name'=>'POS机登录记录',
                'url'=>'posrecord'
            ],
            'qrcode'=>[
                'name'=>'二维码',
                'url'=>'qrcodelist'
            ],
        ]
    ],
    'card'=>[
        'name'=>'卡券',
        'icon'=>'icon-present',
        'son'=>[
            'main'=>[
                'name'=>'卡券列表',
                'url'=>'main'
            ],
            'code'=>[
                'name'=>'卡券领取',
                'url'=>'code'
            ],
            'advert'=>[
                'name'=>'外部券',
                'url'=>'advert'
            ],
        ]
    ],
    'recharge'=>[
        'name'=>'订单',
        'icon'=>'icon-bag',
        'son'=>[
            'goods'=>[
                'name'=>'充值产品',
                'url'=>'goods.index'
            ],
            'shop'=>[
                'name'=>'充值店铺',
                'url'=>'shop.index'
            ],
            'order'=>[
                'name'=>'充值记录',
                'url'=>'order.index'
            ],
            'luck'=>[
                'name'=>'红包记录',
                'url'=>'luck.index'
            ],
            'promotionfee'=>[
                'name'=>'推广费订单',
                'url'=>'promotionfee'
            ],
            'merchant'=>[
                'name'=>'企业支付记录',
                'url'=>'merchant'
            ],
            'purchase'=>[
                'name'=>'商店内购订单',
                'url'=>'purchase'
            ],
            'commodity'=>[
                'name'=>'商品购买订单',
                'url'=>'commodity'
            ],
            'paypos'=>[
                'name'=>'申请pos机订单',
                'url'=>'paypos'
            ],
        ]
    ],

    'data'=>[
        'name'=>'流量',
        'icon'=>'icon-bubble',
        'son'=>[
            'pv'=>[
                'name'=>'访问',
                'url'=>'pv'
            ],
        ]
    ],

    // 'user'=>[
    //     'name'=>'用户',
    //     'icon'=>'icon-user',
    //     'son'=>[
    //         'pv'=>[
    //             'name'=>'微信用户',
    //             'url'=>'wechat'
    //         ],
    //     ]
    // ],

    'member'=>[
        'name'=>'会员',
        'icon'=>'icon iconfont icon-huiyuanqia',
        'son'=>[
            'mian'=>[
                'name'=>'会员卡列表',
                'url'=>'main'
            ],
        ]
    ],

    'account'=>[
        'name'=>'账户',
        'icon'=>'icon iconfont icon-zhanghu',
        'son'=>[
            'defray'=>[
                'name'=>'支出',
                'url'=>'defray'
            ],
            'auditing'=>[
                'name'=>'佣金确认',
                'url'=>'auditing'
            ],
            'comdetails'=>[
                'name'=>'佣金积分明细',
                'url'=>'comdetails'
            ],
        ]

    ],

    'system'=>[
        'name'=>'系统',
        'icon'=>'icon-settings',
        'son'=>[
            'text'=>[
                'name'=>'说明文字',
                'url'=>'text'
            ],
            'pic'=>[
                'name'=>'素材图片',
                'url'=>'pic'
            ],
            'logs'=>[
                'name'=>'错误日志',
                'url'=>'logs'
            ],
        ]
    ],
];
