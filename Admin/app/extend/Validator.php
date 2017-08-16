<?php

namespace App\Extend;

class Validator extends \Windward\Extend\Validator {

    public function isNotExixts($account, $vars = null) 
    {
        $model = $this->container->model('Index');
        $count = $model->count('tb_system_admin', ['account' => $account]);
        return $count ? true : false;
    }
    
    public function accIsOnly($account, $vars = null) 
    {
        
        
        if ($vars['id']) {
            return true;
        } else {
            $model = $this->container->model('SystemManage');
            $count = $model->count('tb_system_admin', ['account' => $account]);
            return $count ? false : true;
        }
        
    }

    public function passAndAcc($data, $vars = []) {
        $model = $this->container->model('Index');
        $one = $model->get('tb_system_admin', 'id, password', ['account' => $vars["account"], '[eq]deleted' => 0]);
        if (!$one || $one["password"] != md5($vars["password"])) {
            return false;
        } else {
            $_SESSION["role_admin"] = [
                "id" => $one["id"],
                "password" => $one["password"]
            ];
            return true;
        }
    }
    
    public function checkCurrPass($data, $vars = []) {
        $model = $this->container->model('PassMody');
        $one = $model->get('tb_system_admin', 'password', ['id' => $vars["id"], '[eq]deleted' => 0]);
        if (!$one || $one["password"] != md5($vars["password"])) {
            return false;
        }
        return true;
    }
    
    public function checksurepassword($data, $vars = []) {
        $model = $this->container->model('SystemManage');        
        if ($vars["newpassword"] != $vars["surepassword"]) {
            return false;
        }
        return true;
    }

    public function checkCharLength($field, $vars = array()) {//字符长度(中英文)       
        if (!isset($field) && $vars['isset_flag'] === true) {
            return true;
        }
        if ($vars['empty_flag'] === true && strlen($field) === 0) {
            return true;
        }
        if (isset($field)) {
            $count = -1;
            if (isset($vars['max_length'])) {
                preg_match_all("/./us", $field, $match);
                $count = count($match[0]);
                if ($count > $vars['max_length']) {
                    return false;
                }
            }
            if (isset($vars['min_length'])) {
                if ($count == -1) {
                    preg_match_all("/./us", $field, $match);
                    $count = count($match[0]);
                }
                if ($count < $vars['min_length']) {
                    return false;
                }
            }
            if (isset($vars['length'])) {
                if ($count == -1) {
                    preg_match_all("/./us", $field, $match);
                    $count = count($match[0]);
                }
                if ($count != $vars['length']) {
                    return false;
                }
            }
            if (isset($vars['match_value'])) {
                if ($field != $vars['match_value']) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    public function checkAccountOnly($field, $vars = array()) {
        $model = $this->container->model('Index');
        $cond = ['account' => $field, '[eq]deleted' => 0];
        $id = $vars['id'];
        if ($id) {
            $cond['[neq]id'] = $id;
        }
        if ($model->get($model->adminTbn, 'id', $cond)) {
            return false;
        }
        return true;
    }
    
    function checkPhoneNumber($field, $vars = array()) {//手机+座机验证
        return preg_match("/^((0\d{2,3}-\d{7,8})|(1[34578]\d{9}))$/", $field);
    }
    
    function checkDigitalz($field, $vars = array()) {//数字
        return preg_match("/^[1-9]+(.[1-9]{1,2})?$/", $field);
    }
    
    function checkTwoDecimal($field, $vars = array()) {//两位小数
        return preg_match("/\d{1,}\.\d{2}$/", $field);
    }

    function isPassword($field, $vars = array()) {
        if (!isset($field) && $vars['isset_flag'] === true) {
            return true;
        }
        if ($vars['empty_flag'] === true && strlen($field) === 0) {
            return true;
        }
        if (isset($field)) {
            return preg_match('/^[0-9a-zA-Z]+$/', $field);
        }
    }

    function isAccount($field, $vars = array()) {
        if (!isset($field) && $vars['isset_flag'] === true) {
            return true;
        }
        if ($vars['empty_flag'] === true && strlen($field) === 0) {
            return true;
        }
        if (isset($field)) {
            return preg_match('/^[0-9a-zA-Z]+$/', $field);
        }
    }

    function checkAccount($field, $vars = array()) {
        return preg_match('/^[0-9a-zA-Z]{5,18}$/', $field);
    }

    public function checkAnswer($data, $vars = array()) {
        $type = $vars['type'];

        foreach ($data as $key => $item) {
            if ($item['is_right'] && !$item['text']) {
                return false;
            }
            $ord = ord($key);
            if ($item['is_right'] || $item['text']) {
                $prevKey = chr($ord - 1);
                if (!$data[$prevKey]['text'] && $ord != 97) {
                    return false;
                }
            }
        }

        $tmp = array_map(function(&$item) {
            return $item['is_right'];
        }, $data);
        if ($type == 1 || $type == 3) {
            return array_sum($tmp) == 1;
        } elseif ($type == 2) {
            return array_sum($tmp) > 1;
        }
    }

}
