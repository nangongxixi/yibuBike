<?php

class ApiController extends ControllerBase {
    
    public function indexAction() {
        $controllers = [];
        $controllerRegex = '/^([a-zA-Z]+)Controller\.php$/';
        $actionRegex = '/^([a-zA-Z]+)Action$/';
        $descRegex = '/@[\s]*description[\s]*(.*?)[\r\n*]/';  
        $dir = APP_PATH . '/controllers';
        $ignore = ['apiController'];
        $fileList = scandir($dir);
        foreach ($fileList as $fileName) {
            if (!preg_match($controllerRegex, $fileName, $m)) {
                continue;
            }
            $c = lcfirst($m[1]);
            $controller = "{$c}Controller";
            if (in_array($controller, $ignore)) {
                continue;
            }
            $controller = ucfirst($controller);
            $class = new ReflectionClass($controller);
            $desc = $class->getDocComment();
            if (!preg_match($descRegex, $desc, $m)||!strlen($m[1])) {
                continue;
            }
            $controllers[$c]['desc'] = $m[1];
            $methods = $class->getMethods();
            foreach ($methods as $mv) {
                $a = $mv->name;
                if (!preg_match($actionRegex,$a,$m)) {
                    continue;
                }
                $action = $m[1];
                $desc = $mv->getDocComment();
                if (!preg_match($descRegex, $desc, $m)||!strlen($m[1])) {
                    continue;
                }
                $actionSummary = $m[1];
                $controllers[$c]['actions'][] = [
                    'action' => $action,
                    'desc' => $actionSummary,
                ];
            }
        }
        if(empty($controllers)){
            exit('<h1 style="text-align:center;">接口未完善</h1>');
        }
        $this->view->setVar('menus', $controllers);
        $this->view->pick('api/index');
    }
    
    public function loadAction(){
        $c = $this->request->get('c');
        $a = $this->request->get('a');
        $path = "{$c}/{$a}";
        $this->view->setVar('path',$path);
        $c = ucfirst("{$c}Controller");
        $a = "{$a}Action";
        $class = new ReflectionClass($c);
        $method = $class->getMethod($a);
        $desc = $method->getDocComment();
        $descRegex = '/@[\s]*description[\s]*(.*?)[\r\n*]/';
        if (!preg_match($descRegex, $desc, $m)||!strlen($m[1])) {
            exit('<h1 style="text-align:center;">接口未完善</h1>');
        }
        $actionSummary = $m[1];
        $this->view->setVar('actionSummary',$actionSummary);
        $instance  = $class->newInstance();
        $instance->doctype = 'define';
        $define = $instance->$a();
        $count = 0;
        if(!empty($define['body'])){
            $count = count($define['body'])+1;
        }else if(!empty($define['header'])){
            $count = 2;
        }else{
            exit('<h1 style="text-align:center;">接口未完善</h1>');
        }
        if(isset($define['notice'])){
            $count += 1;
        }
        if(!$count){
            exit('<h1 style="text-align:center;">接口未完善</h1>');
        }
        $this->view->setVar('parameters',$define);
        $this->view->setVar('count',$count);
        $instance->doctype = 'response';
        $response = $instance->$a();
        if(!empty($response)){
            $this->view->setVar('return',$response);
        }else{
            exit('<h1 style="text-align:center;">接口未完善</h1>');
        }
        $status = $way = '';
        $statusRegex = '/@[\s]*status[\s]*(.*?)[\r\n*]/';
        if (preg_match($statusRegex, $desc, $m)) {
            $status = $m[1];
        }
        if(!strlen($status)){
            $status = 0;
        }
        $this->view->setVar('status',$status);
        $wayRegex = '/@[\s]*way[\s]*(.*?)[\r\n*]/';
        if (preg_match($wayRegex, $desc, $m)) {
            $way = $m[1];
        }
        if(!strlen($way)){
            $way = 'POST';
        }
        $this->view->setVar('way',$way);
        $this->view->pick('api/load');
    }
    
}

//
