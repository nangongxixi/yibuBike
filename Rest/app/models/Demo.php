<?php

namespace App\Models;

class Demo extends Base
{
    public function validInput($data, &$errors)
    {
        $config = [
            'name' => array(
                array('isNotNull', 'name_empty'),
            ),
            'email' => array(
                array('isNotNull', 'email_empty'),
                array('isNotExixts', 'email_is_exixts', ['id' => $data['id']]),
            ),
        ];
        
        $validator = new \App\Extend\Validator($this->container);
        if (!$result = $validator->validate($config, $data, false)) {
            $errors = $validator->error;
            $this->language->validator('demo', $errors);
        }
        
        return $result;
    }

    public function save($data)
    {
        $id = (int) $data['id'];

        $this->begin();
        
        $id && ($one = $this->get('users', 'id', ['id' => $id], true, null, true));
        if ($id && !$one) {
            $this->rollback();
            return false;
        }

        $user = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];
        if ($id) {
            if ($this->update('users', $user, ['id' => $id]) === false) {
                $this->rollback();
                return false;
            }
        } else {
            if (($id = $this->insert('users', $user)) === false) {
                $this->rollback();
                return false;
            }
        }

        $this->commit();
        return $id;
    }

}
