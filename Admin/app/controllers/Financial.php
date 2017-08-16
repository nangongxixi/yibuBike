<?php

namespace App\Controllers;

class Financial extends Base
{

    private $model = null;

    public function __construct(\Windward\Core\Container $container)
    {
        parent::__construct($container);
        $this->model = $container->model('Demo');
    }

    public function topupAction()
    {
        $sh = $this->request->getQuery('sh');
        $userlist = $this->model->questionList($sh);
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('results', $userlist);
        $response->set('sh', $sh);
        return $response;
    }
    
    public function consumptionAction()
    {
        $sh = $this->request->getQuery('sh');
        $userlist = $this->model->questionList($sh);
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('results', $userlist);
        $response->set('sh', $sh);
        return $response;
    }
    
    public function depositAction()
    {
        $sh = $this->request->getQuery('sh');
        $userlist = $this->model->questionList($sh);
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('results', $userlist);
        $response->set('sh', $sh);
        return $response;
    }

    public function inputAction()
    {
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

    public function delAction()
    {
        $id = $this->request->getQuery('id');
        if ($this->model->del($id) === false) {
            return $this->error('del_failed');
        }
        return $this->success(null, 'del_succ');
    }

    //ajax
    public function ajaxListAction()
    {
        $response = new \Windward\Core\Response\Smarty($this->container);
        return $response;
    }
    
    public function ajaxFormAction()
    {
        $response = new \Windward\Core\Response\Smarty($this->container);
        return $response;
    }

}
