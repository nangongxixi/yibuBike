<?php

namespace App\Controllers;

class Index extends Base {
    
    private $model = null;

    public function __construct(\Windward\Core\Container $container)
    {
        parent::__construct($container);
        $this->model = $container->model('Index');
    }
    
    public function indexAction() 
    {
        $errors = array();
        $data = $this->request->getPost("data");       
        if ($this->request->isComplete()) {
            if ($this->model->validLogin($data, $errors)) { 
                $this->redirect('/user/index');
            } else {
                $this->view->assign('errors', $errors);
                $this->view->assign('data', $data);
            }
        }        
        $response = new \Windward\Core\Response\Smarty($this->container);
        return $response;
    }

    public function logoutAction() 
    {       
        unset($_SESSION["role_admin"]);
        $this->redirect("/index/index");
    }

}
