<?php

namespace App\Models;

class PassMody extends Base
{

    public function passmody($id = 0, $field = '*')
    {
        $id = (int) $id;
        if (!$id) {
            return array();
        }
        $passmody = $this->get('tb_system_admin', $field, ['id' => $id]);
        if (!$passmody) {
            return array();
        }
        return $passmody;
    }

    public function validInput($data, &$errors)
    {        
        $config = [
            'currpass' => array(
                array('isNotNull', 'currpass_not_null'),
                array('checkCharLength', 'currpass_short', array("min_length" => 6)),
                array('checkCharLength', 'currpass_long', array("max_length" => 18)),
                array('checkCurrPass', 'currpass_no', ['id' => $data['id'], 'password' => $data['currpass']]),             
            ),
            'newpass' => array(
                array('isNotNull', 'newpass_not_null'),
                array('checkCharLength', 'newpass_short', array("min_length" => 6)),
                array('checkCharLength', 'newpass_long', array("max_length" => 18)),
            ),
            'surepass' => array(
                array('isNotNull', 'surepass_not_null'),
                array('checkCharLength', 'surepass_short', array("min_length" => 6)),
                array('checkCharLength', 'surepass_long', array("max_length" => 18)),
                array('checksurepass', 'surepass_no', ['newpass' => $data['newpass'], 'surepass' => $data['surepass']]),
            ),
        ];

        $validator = new \App\Extend\Validator($this->container);
        if (!$result = $validator->validate($config, $data)) {
            $errors = $validator->error;
            $this->language->validator('PassMody', $errors);
        }
        
        return $result;
    }

    public function save($data)
    {
        $id = (int) $data['id'];

        
        $question = [
            'password' => md5($data['surepass']),            
        ];
        if (!$id) {
            $question["created"] = NOW;
            return $this->insert("tb_system_admin", $question);
        } else {
            
            return $this->update('tb_system_admin', $question, ['id' => $id]);
        }
    }

}
