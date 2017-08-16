<?php

namespace App\Config;

class_alias('\Base\Config\\' . ucfirst(APP_ENV) . '\Code', "BaseCodeConfig");

class Code extends \BaseCodeConfig
{
    public $menu = [        
        'user' => [
            'name' => '用户管理',
            'sub' => [
                'index' => ['name' => '用户一览', 'uri' => '/user/index'],
                'smrz' => ['name' => '实名认证', 'uri' => '/user/smrz'],
                'yqxx' => ['name' => '邀请信息', 'uri' => '/user/yqxx'],
                'xyjl' => ['name' => '信用记录', 'uri' => '/user/xyjl'],
            ]
        ],
        'bike' => [
            'name' => '单车管理',
            'sub' => [
                'index' => ['name' => '单车一览', 'uri' => '/bike/index'],
                'booklog' => ['name' => '预约信息', 'uri' => '/bike/booklog'],
                'rentlog' => ['name' => '租赁记录', 'uri' => '/bike/rentlog'],
                'troublelog' => ['name' => '故障处理', 'uri' => '/bike/troublelog'],
                'faultlog' => ['name' => '举报处理', 'uri' => '/bike/faultlog'],
            ]
        ],
        'financial' => [
            'name' => '财务管理',
            'sub' => [
                'topup' => ['name' => '充值一览', 'uri' => '/financial/topup'],
                'consumption' => ['name' => '消费一览', 'uri' => '/financial/consumption'],
                'deposit' => ['name' => '押金信息', 'uri' => '/financial/deposit'],
            ]
        ],
        'statistical' => [
            'name' => '统计管理',
            'sub' => [
                'index' => ['name' => '平台一览', 'uri' => '/statistical/platform'],
            ]
        ],
        'systemmanage' => [
            'name' => '系统管理',
            'sub' => [
                'index' => ['name' => '管理员', 'uri' => '/systemmanage/manager'],
                'sm' => ['name' => '参数配置', 'uri' => '/systemmanage/configuration'],
            ]
        ],
        'passmody' => [
            'name' => '我的账户',
            'sub' => [
                'index' => ['name' => '密码修改', 'uri' => '/passmody/input'],
            ]
        ],
    ];    
    
        
    public $yajstatus = [
        'type' => [
            0 => ['name' => '未缴纳', 'value' => 0],
            1 => ['name' => '已缴纳', 'value' => 1],
            2 => ['name' => '申请退还', 'value' => 2],
            3 => ['name' => '已退还', 'value' => 3],
        ],
    ];
    
    public $realnamestatus = [
        'type' => [
            0 => ['name' => '未认证', 'value' => 0],
            1 => ['name' => '申请中', 'value' => 1],
            2 => ['name' => '认证失败', 'value' => 2],
            3 => ['name' => '已认证', 'value' => 3],
        ],
    ];
    
    public $freeze = [
        'type' => [
            1 => ['name' => '正常', 'value' => 1],
            2 => ['name' => '已冻结', 'value' => 2],            
        ],
    ];
    
    public $topuptype = [
        'type' => [
            1 => ['name' => '余额', 'value' => 1],
            2 => ['name' => '押金', 'value' => 2],            
        ],
    ];
    
    public $topupstatus = [
        'type' => [
            1 => ['name' => '正常', 'value' => 1],
            2 => ['name' => '异常', 'value' => 2],            
        ],
    ];
    
    public $paytype = [
        'type' => [
            1 => ['name' => '微信', 'value' => 1],
            2 => ['name' => '支付宝', 'value' => 2],            
        ],
    ];
    
    public $paystatus = [
        'type' => [
            1 => ['name' => '已付款', 'value' => 1],
            2 => ['name' => '未付款', 'value' => 2],            
        ],
    ];
    
    public $managerauth = [
        'type' => [
            1 => ['name' => '用户管理', 'value' => 1],
            2 => ['name' => '单车管理', 'value' => 2], 
            3 => ['name' => '财务管理', 'value' => 3], 
            4 => ['name' => '统计管理', 'value' => 4], 
            5 => ['name' => '系统管理', 'value' => 5],
        ],
    ];
    
    public $question = [
        'type' => [
            1 => ['name' => '单选', 'value' => 1],
            2 => ['name' => '多选', 'value' => 2],
            3 => ['name' => '判断', 'value' => 3],
        ],
    ];
    
    public $order = [
        'demo' => [
            'a' => [
                'field' => 'a.id',
                'type' => 'asc',
            ],
            'b' => [
                'field' => 'a.question',
                'type' => 'asc',
            ],
        ],
        
        'user' => [
            'a' => [
                'field' => 'email',
                'type' => 'desc',
            ],
        ],
    ];
    
    public $paging = [
        'default' => [
            10 => '10条',
            20 => '20条',
            50 => '50条',
            0 => '所有',
        ],
        
        'demo' => [
            5 => '5条',
            20 => '20条',
            50 => '50条',
            0 => '所有',
        ],
    ];
    
    public $xyjlxz = [
        'type' => [
            1 => ['name' => '加分记录', 'value' => 1],
            2 => ['name' => '负面记录', 'value' => 2],           
        ],
    ];
}
