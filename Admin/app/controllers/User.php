<?php

namespace App\Controllers;

class User extends Base
{

    private $model = null;

    public function __construct(\Windward\Core\Container $container)
    {
        parent::__construct($container); 
        $this->model = $container->model('User');
    }

    public function indexAction()
    {
        $sh = $this->request->getQuery('sh');
        $userlist = $this->model->questionList($sh);
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('results', $userlist);
        $response->set('sh', $sh);        
        return $response;
    }
    
    public function yjInfoyAction()
    {
        $sh = $this->request->getQuery('sh');
        $result = $this->model->yajList($sh)['items'][0];
        
        print_r($result);
        
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('result', $result);
        return $response;
    }
    
    
    
    public function yjInfonAction() { //没有缴纳押金
        $id = $this->request->getQuery('id'); 
        $result = [
            'name'=>'', 
            'tel'=>'13999999999', 
            'zffs'=>'支付宝', 
            'je'=>146, 
            'sfyth'=>'否'
            ];
        if ($result) {            
            $this->view->assign('result', $result);            
            $data["html"] = $this->view->fetch("User/yjInfon");
        } else {
            parent::$status["code"] = '1000';
            parent::$status["msg"] = 'system error';
        }
        $this->output($data, "info");
    }
    
    public function yrzInfoAction() { //实名认证已认证
        $id = $this->request->getQuery('id');
        $result = [
            'name'=>'', 
            'tel'=>'13999999999', 
            'zjh'=>'513948885858274731', 
            'zjz'=>'headpic.jpg', 
            'sqsj'=>'2016-05-22 13:13:13', 
            'czr'=>'王晶晶', 
            'zh'=>'0472341', 
            'time'=>'2016-05-22 13:13:13', 
            ];
        if ($result) {            
            $this->view->assign('result', $result);            
            $data["html"] = $this->view->fetch("User/yrzInfo");
        } else {
            parent::$status["code"] = '1000';
            parent::$status["msg"] = 'system error';
        }
        $this->output($data, "info");
    }
    
    public function qxInfoAction() { //骑行信息
        $id = $this->request->getQuery('id'); 
        $result = [
            'name'=>'', 
            'tel'=>'13999999999', 
            'ljqxxx'=>257, 
            'jytpl'=>136, 
            'ydcj'=>76
            ];
        if ($result) {            
            $this->view->assign('result', $result);            
            $data["html"] = $this->view->fetch("User/qxInfo");
        } else {
            parent::$status["code"] = '1000';
            parent::$status["msg"] = 'system error';
        }
        $this->output($data, "info");
    }
    
    public function yyInfoAction() { //预约记录信息
        $id = $this->request->getQuery('id');
        $user = [
            'name'=>'',
            'tel'=>'13268990000'
            ];
        $result = [
            ['id'=>4, 'dcbh'=>'XN400f', 'yydcwz'=>'四川成都', 'dj'=>136, 'zt'=>'已取消', 'time'=>'2015-02-26 11:39:13'],
            ['id'=>8, 'dcbh'=>'XN400s', 'yydcwz'=>'四川德阳', 'dj'=>126, 'zt'=>'已结束', 'time'=>'2015-07-26 04:39:13'],
            ['id'=>9, 'dcbh'=>'XN400f', 'yydcwz'=>'四川成都', 'dj'=>331, 'zt'=>'已取消', 'time'=>'2013-02-66 11:39:13'],
            ];
        
        if ($result) { 
            $this->view->assign('user', $user); 
            $this->view->assign('result', $result);            
            $data["html"] = $this->view->fetch("User/yyInfo");
        } else {
            parent::$status["code"] = '1000';
            parent::$status["msg"] = 'system error';
        }
        $this->output($data, "info");
    }
    
    public function xcInfoAction() { //行程记录信息
        $id = $this->request->getQuery('id');
        $user = [
            'name'=>'', 
            'tel'=>'18735678666'
            ];
        $result = [
            ['id'=>4, 'dcbh'=>'XN400f', 'kswz'=>257, 'jswz'=>136, 'qxjl'=>76, 'zt'=>'行程开始', 'xydf'=>3, 'time'=>'2015-02-26 11:39:13'],
            ['id'=>5, 'dcbh'=>'RN360f', 'kswz'=>167, 'jswz'=>166, 'qxjl'=>46, 'zt'=>'行程结束', 'xydf'=>5, 'time'=>'2014-02-23 11:29:13'],
            ['id'=>6, 'dcbh'=>'CN470u', 'kswz'=>757, 'jswz'=>836, 'qxjl'=>96, 'zt'=>'行程开始', 'xydf'=>9, 'time'=>'2013-12-25 11:29:17'],
            ];
        
        if ($result) { 
            $this->view->assign('user', $user); 
            $this->view->assign('result', $result);            
            $data["html"] = $this->view->fetch("User/xcInfo");
        } else {
            parent::$status["code"] = '1000';
            parent::$status["msg"] = 'system error';
        }
        $this->output($data, "info");
    }
    
    public function ydjInfoAction() { //已冻结
        $id = $this->request->getQuery('id'); 
        $result = [
            'name'=>'王国涛', 
            'time'=>'2013-12-25 11:29:17', 
            'zh'=>'0014267'
            ];
        if ($result) {            
            $this->view->assign('result', $result);            
            $data["html"] = $this->view->fetch("User/ydjInfo");
        } else {
            parent::$status["code"] = '1000';
            parent::$status["msg"] = 'system error';
        }
        $this->output($data, "info");
    }
    
    public function smrzAction()
    {
        
        //$id = $this->request->getQuery('id');
        
        //$sh['id'] = $this->request->getQuery('id');
        $sh = $this->request->getQuery('sh');       
        $userlist = $this->model->questionList($sh);
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('results', $userlist);
        $response->set('sh', $sh);
        return $response;
    }
    
    public function yqxxAction()
    {
        $sh = $this->request->getQuery('sh');
        $userlist = $this->model->questionList($sh);
        $response = new \Windward\Core\Response\Smarty($this->container);
        $response->set('results', $userlist);
        $response->set('sh', $sh);
        return $response;
    }
    
    public function xyjlAction()
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
            echo 1111;
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

}
