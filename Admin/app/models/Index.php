<?php

namespace App\Models;

class Index extends Base {

    public function validLogin($data, &$errors) {
        
        $config = [
            'account' => array(
                array('isNotNull', 'account_not_null'),
                array('checkCharLength', 'account_short', array("min_length" => 6)),
                array('checkCharLength', 'account_long', array("max_length" => 18)),
                array('isNotExixts', 'account_is_Exixts'),
            ),
            'password' => array(
                array('isNotNull', 'pwd_not_null'),
                array('checkCharLength', 'pwd_short', array("min_length" => 6)),
                array('checkCharLength', 'pwd_long', array("max_length" => 18)),
                array('passAndAcc', 'login_failure', ['account' => $data['account'], 'password' => $data['password']]),
            ),
        ];
        
        
        $validator = new \App\Extend\Validator($this->container);
        if (!$result = $validator->validate($config, $data, false)) {
            $errors = $validator->error;
            $this->language->validator('admin', $errors);
        }

        return $result;
    }

}
