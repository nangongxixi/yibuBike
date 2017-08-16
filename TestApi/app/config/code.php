<?php

$codeConfig = [];

$codeConfig['api'] = [
    'header' => [
        [
            'name' => 'APP_AUTH',
            'remark' => '加密后的数据',
        ],
        [
            'name' => 'APP_AUTH_IV',
            'remark' => '私钥',
        ],
        [
            'name' => 'APP_VERSION',
            'remark' => 'APP版本',
        ],
        [
            'name' => 'DEVICE_UUID',
            'remark' => '客户端UUID',
        ],
        [
            'name' => 'DEVICE_MODEL',
            'remark' => '设备(1:iphone;2:android)',
        ],
        [
            'name' => 'DEVICE_VERSION',
            'remark' => '客户端版本',
        ],
        [
            'name' => 'DEVICE_TOKEN',
            'remark' => '客户端push token',
            'required' => 'C',
            'especial' => true,
        ],
        [
            'name' => 'APP_TOKEN',
            'remark' => '登录令牌token',
            'required' => 'C',
            'especial' => true,
        ],
    ],
    'explain' => [
        'status' => [
            'summary' => '操作状态',
        ],
        'code' => [
            'summary' => '错误编码',
        ],
        'msg' => [
            'summary' => '状态信息',
        ],
        'data' => [
            'summary' => '返回数据',
            'type' => '',
        ],
        'need_relogin' => [
            'summary' => '是否需要重新登录(0:不需要;1:需要;)',
            'type' => '',
        ],
        'paging' => [
            'summary' => '分页信息',
            'type' => 'jsonObject',
        ],
        'total_page' => [
            'summary' => '总页数',
        ],
        'current_page' => [
            'summary' => '当前页码',
        ],
        'perpage' => [
            'summary' => '分页条数',
        ],
        'total_items' => [
            'summary' => '总数据量',
        ],
    ],
];

$codeConfig['captcha'] = [
    'test_value' => 123456,
];

return $codeConfig;

//
