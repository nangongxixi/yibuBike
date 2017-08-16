<?php

/**
 * @description 用户信息
 */
class UserController extends ControllerBase {

    /**
     * @description 注册登录
     * @status 1
     */
    public function startAction() {
        if ($this->doctype == 'define') {
            $pmtBody = [
                [
                    'name' => 'id',
                    'type' => 'int',
                    'required' => false,
                    'remark' => '房间id',
                ],
                [
                    'name' => 'need_refresh_type',
                    'type' => 'int',
                    'required' => false,
                    'remark' => '是否需要刷新房间类型[0:否;1:是;]',
                ],
            ];
            $notice = "BODY参数id不传时默认返回第一个房间数据并且获取所有房间类型;";
            return $this->setParameter(null, $pmtBody, false, $notice);
        }
        if ($this->doctype == 'response') {
            $virtual_data = [
                'items' => [
                    [
                        'id' => '1',
                        'type' => '单人标间',
                    ],
                    [
                        'id' => '2',
                        'type' => '双人标间',
                    ],
                ],
                'obj' => [
                    'id' => '1',
                    'imgs' => [
                        'http://www.test.com/a.jpg',
                        'http://www.test.com/b.jpg',
                        'http://www.test.com/a.jpg',
                        'http://www.test.com/b.jpg',
                        'http://www.test.com/a.jpg',
                    ],
                    'price' => '180.00',
                    'phone' => '028-12345678',
                    'describe' => '这里是客房详情说明文字',
                ],
            ];
            return $this->output(["data" => $virtual_data,]);
        }
    }
    
    
    
}

//
