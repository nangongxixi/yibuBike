<?php

/**
 * @description 短信网关
 */
class CaptchaController extends ControllerBase
{

    /**
     * @description 发送验证码
     * @status 
     */
    public function getAction()
    {
        if ($this->doctype == 'define') {
            $pmtHeader = [
                'APP_TOKEN' => [
                    'required' => 'O',
                ]
            ];
            $pmtBody = [
                [
                    'name' => 'mobile',
                    'type' => 'bigint',
                    'remark' => '手机号码',
                ],
                [
                    'name' => 'type',
                    'type' => 'tinyint',
                    'required' => 'O',
                    'especial' => true,
                    'remark' => '类型(1:登录注册;)',
                ],
            ];
            $notice = "BODY参数id不传时默认返回第一个房间数据并且获取所有房间类型";
            return $this->setParameter($pmtHeader, $pmtBody, false, $notice);
        }
        if ($this->doctype == 'response') {
            return $this->output(['msg' => '验证码已发送, 测试版本固定值:' . $this->code['captcha']['test_value'],]);
        }
    }

}
