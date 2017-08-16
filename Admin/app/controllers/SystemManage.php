<?php

namespace App\Controllers;

class SystemManage extends Base {

    private $model = null;

    public function __construct(\Windward\Core\Container $container) {
        parent::__construct($container);
        $this->model = $container->model('SystemManage');
    }

    public function managerAction() {
        $sh = $this->request->getQuery('sh');
        $userlist = $this->model->managerList($sh);
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('results', $userlist);
        $response->set('sh', $sh);
        return $response;
    }

    public function configurationAction() {
        $sh = $this->request->getQuery('sh');
        $userlist = $this->model->configurationList($sh);
        $configLogCount = $this->model->configLogCount($sh);
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('results', $userlist);
        $response->set('configLogCount', $configLogCount['paging']['total_items']);
        $response->set('sh', $sh);
        return $response;
    }

    public function systemConfigLogAction() {
        $sh = $this->request->getQuery('sh');
        $userlist = $this->model->configLogCount($sh);
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('results', $userlist);
        $response->set('sh', $sh);
        return $response;
    }

    public function configuraModyAction() {
        $id = $this->router->getParams('id');
        $errors = array();
        if ($this->request->isComplete()) {
            $data = $this->request->getPost('question');
            $data['id'] = $id;
            if ($this->model->validPrice($data, $errors)) {
                $this->model->savePrice($data);
                $this->redirect('/systemmanage/configuration');
            }
        } else {
            if ($id) {
                $data = $this->model->configuraMody($id);
                if (!$data) {
                    $this->redirect('/systemmanage/configuration');
                }
            }
        }

        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('results', $data);
        $response->set('errors', $errors);
        return $response;
    }

    public function inputAction() {
        $id = $this->router->getParams('id');
        $errors = array();
        if ($this->request->isComplete()) {
            $data = $this->request->getPost('question');
            $data['id'] = $id;
            if ($this->model->validInput($data, $errors)) {
                $this->model->save($data);
                $this->redirect('/systemmanage/manager');
            }
        } else {
            if ($id) {
                $data = $this->model->manager($id);
                if (!$data) {
                    $this->redirect('/systemmanage/manager');
                }
            }
        }

        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('results', $data);
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
    
}
