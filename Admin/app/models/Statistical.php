<?php

namespace App\Models;

class Statistical extends Base {
    
    public function Statistical($id = 0, $field = '*') {
        $id = (int) $id;
        if (!$id) {
            return array();
        }
        $manager = $this->get('tb_system_stat', $field, ['id' => $id]);
        if (!$manager) {
            return array();
        }
        return $manager;
    }

    public function validInput($data, &$errors) {
        $config = [
            'question' => array(
                array('isNotNull', 'question_not_null'),
            ),
            'answer' => array(
                array('checkAnswer', 'answer_is_invalid', ['type' => $data['type']]),
            ),
        ];

        $validator = new \App\Extend\Validator($this->container);
        if (!$result = $validator->validate($config, $data)) {
            $errors = $validator->error;
            $this->language->validator('demo', $errors);
        }

        return $result;
    }

    public function save($data) {
        $id = (int) $data['qid'];

        $data['answer'] = array_filter($data['answer'], function($v, $k) {
            return $v['text'];
        });
        $question = [
            'type' => (int) $data['type'],
            'question' => (string) $data['question'],
            'answer' => json_encode($data['answer']),
            'remark' => (string) $data['remark'],
        ];
        if (!$id) {
            $question["created"] = NOW;
            return $this->insert("question", $question);
        } else {
            return $this->update('question', $question, ['qid' => $id]);
        }
    }

    public function del($id) {
        if ($this->update('question', ['deleted' => 1], ['qid' => $id]) === false) {
            return false;
        }
        return true;
    }

}
