<?php

return [
    'debug'  => true,
    'app_id'  => 'wx6f9fd20592118244',         // AppID
    'secret'  => 'c8878895c1414c445a9468ab94f1283b',     // AppSecret
    'token'   => 'YuzurihaInori',          // Token
    'aes_key' => 'iewvlYzSW7KkbCVns6otbwLI1FmYfqJStUAv5Y7o9LC',                    // EncodingAESKey，安全模式下请一定要填写！！！
    /**
    * 日志配置
    *
    * level: 日志级别, 可选为：
    *         debug/info/notice/warning/error/critical/alert/emergency
    * permission：日志文件权限(可选)，默认为null（若为null值,monolog会取0644）
    * file：日志文件位置(绝对路径!!!)，要求可写权限
    */
    'log' => [
        'level'      => 'debug',
        // 'permission' => 0777,
        'file'       => '../storage/logs/easywechat.log',
    ],
    /**
    * OAuth 配置
    *
    * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
    * callback：OAuth授权完成后的回调页地址
    */
    'oauth' => [
        'scopes'   => ['snsapi_userinfo'],
        'callback' => '/wx/authmember'
    ],
    /**
    * 微信支付
    */
    'payment' => [
        'merchant_id'       => '1352111401',
        'key'               => 'o2oparkshanghupingtai12345678910',
        'cert_path'         => __DIR__.'/../resources/cert/apiclient_cert.pem', // XXX: 绝对路径！！！！
        'key_path'          => __DIR__.'/../resources/cert/apiclient_key.pem',  // XXX: 绝对路径！！！！

        // 'device_info'     => '013467007045764',
        // 'sub_app_id'      => '',
        // 'sub_merchant_id' => '',
        // ...
    ],
    //开放平台
    // 'open_platform' => [
    //     'app_id'   => 'wxf3764668f9f8ba89',
    //     'secret'   => 'f3771fdc7e0288732a05720dc845dd71',
    //     'token'    => 'HoshimiyaKaito',
    //     'aes_key'  => 'pH588Nu5h8nDhg8CEEOH6dgd9oG6gh68g818E8uHD54'
    //     ],


    //mini
    'mini_program' => [
            'app_id'   => 'wx1e12de865255e4a8',
            'secret'   => 'edf249031356fde8c51d0af72bc115e0',
            // token 和 aes_key 开启消息推送后可见
            // 'token'    => 'your-token',
            // 'aes_key'  => 'your-aes-key'
        ],
    /**
    * Guzzle 全局设置
    *
    * 更多请参考： http://docs.guzzlephp.org/en/latest/request-options.html
    */
    'guzzle' => [
        'timeout' => 6.0, // 超时时间（秒）
        'verify' => false, // 关掉 SSL 认证（强烈不建议！！！）
    ],
];
