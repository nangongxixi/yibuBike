<?php

$langError = [];
$langError['base'] = array(
    'db' => '系统错误',
    'timeout' => '请求超时',
);

$langError['demo'] = array(
    'question_not_null' => '请输入问题',
    'answer_not_null' => '请输入答案',
    'answer_is_invalid' => '答案A,B必填，答案设置不能跳跃，单选/判断只能勾选一个正确答案，多选题勾选两个及其以上正确答案',
    
    'del_failed' => '删除失败',
);

$langError['admin'] = array(
    'account_not_null' => '帐号不能为空', 
    'account_short' => '帐号必须大于6位',
    'account_long' => '帐号不能多于18位',
    'pwd_not_null' => '密码不能为空',
    'login_failure' => '密码错误',    
    'pwd_short' => '密码必须大于6位',
    'pwd_long' => '密码不能多于18位',
    'account_is_Exixts' => '帐号不存在',
    
);

$langError['PassMody'] = array(
    'currpass_not_null' => '当前密码不能为空', 
    'currpass_short' => '当前密码必须大于6位',
    'currpass_long' => '当前密码不能多于18位',
    'currpass_no' => '原密码不正确',
    
    'newpass_not_null' => '新密码不能为空', 
    'newpass_short' => '新密码必须大于6位',
    'newpass_long' => '新密码不能多于18位',
    
    'surepass_not_null' => '确认密码不能为空', 
    'surepass_short' => '确认密码必须大于6位',
    'surepass_long' => '确认密码不能多于18位',
    'surepass_no' => '确认密码与新密码输入不一致',
    
);

$langError['SystemManage'] = array(
    'account_not_null' => '帐号不能为空', 
    'account_is_Exixts' => '帐号已存在，请重新填写',
    'account_short' => '帐号必须大于6位',
    'account_long' => '帐号不能多于18位',    
    
    'name_not_null' => '姓名不能为空',    
    'name_long' => '姓名不能多于16位',
    
    'mobile_format' => '手机号必须为1开始的11位数字',
    
    'newpassword_short' => '密码必须大于6位',
    'newpassword_long' => '密码不能多于18位',
    
    'surepassword_short' => '确认密码必须大于6位',
    'surepassword_long' => '确认密码不能多于18位',
    'surepassword_no' => '确认密码与密码输入不一致',
    
    'val_format' => '必须是两位小数',
);
