<?php

namespace App\Controllers;

class PassMody extends Base
{

    private $model = null;

    public function __construct(\Windward\Core\Container $container)
    {
        parent::__construct($container);
        $this->model = $container->model('PassMody');
    }

    public function inputAction()
    {
        //$id = $this->router->getParams('id');
        $errors = array();
        if ($this->request->isComplete()) {
            $data = $this->request->getPost('question'); 
            $data['id']=1;
            if ($this->model->validInput($data, $errors)) {
                $this->model->save($data);
                unset($_SESSION["role_admin"]);
                $this->redirect("/index/index");                
            }
        }
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('data', $data);
        $response->set('errors', $errors);
        return $response;
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
