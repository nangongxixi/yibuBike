<?php

namespace App\Models;

class SystemManage extends Base {

    public function manager($id = 0, $field = '*') {
        $id = (int) $id;
        if (!$id) {
            return array();
        }
        $manager = $this->get('tb_system_admin', $field, ['id' => $id]);
        if (!$manager) {
            return array();
        }
        return $manager;
    }

    public function configuraMody($id = 0, $field = '*') {
        $id = (int) $id;
        if (!$id) {
            return array();
        }
        $manager = $this->get('tb_system_config', $field, ['id' => $id]);
        if (!$manager) {
            return array();
        }
        return $manager;
    }

    public function validInput($data, &$errors) {
        $config = [
            'account' => array(
                array('isNotNull', 'account_not_null'),
                array('accIsOnly', 'account_is_Exixts', array('id' => $data['id'])),
                array('checkCharLength', 'account_short', array("min_length" => 6)),
                array('checkCharLength', 'account_long', array("max_length" => 18)),
            ),
            'name' => array(
                array('isNotNull', 'name_not_null'),
                array('checkCharLength', 'name_long', array("max_length" => 16)),
            ),
            'mobile' => array(
                array('checkPhoneNumber', 'mobile_format', array("mobile" => $data['mobile'])),
            ),
            'newpassword' => array(
                array('checkCharLength', 'newpassword_short', array("min_length" => 6, "empty_flag" => true)),
                array('checkCharLength', 'newpassword_long', array("max_length" => 18, "empty_flag" => true)),
            ),
            'surepassword' => array(
                array('checkCharLength', 'surepassword_short', array("min_length" => 6, "empty_flag" => true)),
                array('checkCharLength', 'surepassword_long', array("max_length" => 18, "empty_flag" => true)),
                array('checksurepassword', 'surepassword_no', ['newpassword' => $data['newpassword'], 'surepassword' => $data['surepassword']]),
            ),
        ];
        $validator = new \App\Extend\Validator($this->container);
        if (!$result = $validator->validate($config, $data)) {
            $errors = $validator->error;
            $this->language->validator('SystemManage', $errors);
        }

        return $result;
    }

    public function validPrice($data, &$errors) {
        $config = [
            'val' => array(
                array('checkTwoDecimal', 'val_format'),
            ),
        ];
        $validator = new \App\Extend\Validator($this->container);
        if (!$result = $validator->validate($config, $data)) {
            $errors = $validator->error;
            $this->language->validator('SystemManage', $errors);
        }

        return $result;
    }

    public function save($data) {
        $id = (int) $data['id'];
        if (empty($data['type'])) {
            $data['type'] = 6;
        } else {
            $data['type'] = implode(',', $data['type']) . ',6';
        }
        $question = [
            'account' => (string) $data['account'],
            'name' => (string) $data['name'],
            'mobile' => (string) ($data['mobile']),
            'password' => (string) $data['surepassword'],
            'auth' => (string) ($data['type']),
        ];
        if (!empty($question['password'])) {
            $question['password'] = md5($question['password']);
        }
        if (!$id) {
            if (empty($question['password'])) {
                $question['password'] = '123456';
            }
            $question["created"] = NOW;
            return $this->insert("tb_system_admin", $question);
        } else {
            if (empty($question['password'])) {
                unset($question['password']);
            }
            return $this->update('tb_system_admin', $question, ['id' => $id]);
        }
    }

    public function savePrice($data) {
        $id = (int) $data['id'];
        $question = [
            'id' => (string) $data['id'],
            'val' => (string) $data['val'],
        ];
        $insertLog = [
            'id_system_config' => (int) $data['id'],
            //'id_admin' => (int) $_SESSION['role_admin']['id'],
            'val' => (string) $data['val'],
        ];
        if ($id) {
            $this->update('tb_system_config', $question, ['key' => 'price', 'id' => $question['id']]);
            $insertLog["created"] = NOW;
            $this->insert('tb_system_config_log', $insertLog);
            return;
        }
    }

    public function del($id) {
        if ($this->update('tb_system_admin', ['deleted' => 1], ['id' => $id]) === false) {
            return false;
        }
        return true;
    }

}
