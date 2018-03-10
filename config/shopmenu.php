<?php

return [
    // 'executive'=>[
    //     'name'=>'剑客',
    //     'icon'=>'icon-user',
    //     'son'=>[
    //         'main'=>[
    //             'name'=>'剑客列表',
    //             'url'=>'main'
    //         ],
    //     ]
    // ],
    //
    // 'street'=>[
    //     'name'=>'商街',
    //     'icon'=>'icon-direction',
    //     'son'=>[
    //         'main'=>[
    //             'name'=>'商街列表',
    //             'url'=>'main'
    //         ],
    //     ]
    // ],

    'store'=>[
        'name'=>'门店',
        'icon'=>'icon-users',
        'son'=>[
            'main'=>[
                'name'=>'门店信息',
                'url'=>'main'
            ],
            'employee'=>[
                'name'=>'员工列表',
                'url'=>'employee'
            ],
        ]
    ],

    'shake'=>[
        'name'=>'摇一摇',
        'icon'=>'icon-drawer',
        'son'=>[
            'main'=>[
                'name'=>'摇一摇列表',
                'url'=>'main'
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
        ]
    ],
];
