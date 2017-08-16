<?php

namespace App\Controllers;

class Statistical extends Base {

    private $model = null;

    public function __construct(\Windward\Core\Container $container) {
        parent::__construct($container);
        $this->model = $container->model('Statistical');
    }

    public function platformAction() {
        $sh = $this->request->getQuery('sh');
        $Statistical = $this->model->statisticalList($sh);
        if ($sh['begin'] || $sh['end']) {
            if ($sh['begin'] == $sh['end']) {
                if ($sh['end'] == date('Y-m-d', strtotime(NOW))) {
                    $timeTip = '今日';
                }
            }
            if (!$sh['begin'] && $sh['end']) {
                $timeTip = $sh['end'];
            }
            if ($sh['begin'] && !$sh['end']) {
                $timeTip = $sh['begin'];
            }
            if ($sh['end'] && $sh['begin']) {
                if ($sh['end'] != $sh['begin']) {
                    $timeTip = $sh['begin'] . ' — ' . $sh['end'];
                }
                if ($sh['end'] == $sh['begin']) {
                    if ($sh['end'] != date('Y-m-d', strtotime(NOW))) {
                        $timeTip = $sh['begin'];
                    }
                    if ($sh['begin'] != date('Y-m-d', strtotime(NOW))) {
                        $timeTip = $sh['begin'];
                    }
                }
            }
        } else {
            $timeTip = '平台';
        }        
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('row', $Statistical);
        $response->set('timeTip', $timeTip);
        $response->set('sh', $sh);
        return $response;
    }

    public function inputAction() {
        $id = $this->router->getParams('qid');
        $errors = array();
        if ($this->request->isComplete()) {
            $data = $this->request->getPost('question');
            $data['qid'] = $id;
            if ($this->model->validInput($data, $errors)) {
                $this->model->save($data);
                $this->redirect('/demo/index');
            }
        } else {
            if ($id) {
                $data = $this->model->question($id);
                if (!$data) {
                    $this->redirect('/demo/index');
                }
            }
        }
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('question', $data);
        $response->set('errors', $errors);
        return $response;
    }

    public function delAction() {
        $id = $this->request->getQuery('id');
        if ($this->model->del($id) === false) {
            return $this->error('del_failed');
        }
        return $this->success(null, 'del_succ');
    }

    //ajax
    public function ajaxListAction() {
        $response = new \Windward\Core\Response\Smarty($this->container);
        return $response;
    }

    public function ajaxFormAction() {
        $response = new \Windward\Core\Response\Smarty($this->container);
        return $response;
    }

}
