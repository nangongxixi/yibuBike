<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

    public $doctype = '';
    private $virtual = false;

    public function initialize()
    {
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/MSIE\s(\d+)\..*/i', $agent, $regs)) {
            if ($regs[1] < 9) {
                exit('<h1 style="text-align:center;">当前使用浏览器版本过低</h1>');
            }
        }
        $conName = lcfirst($this->dispatcher->getHandlerClass());
        $conName = str_replace('Controller', '', $conName);
        $actName = lcfirst($this->dispatcher->getActionName());
        if ($conName != 'api') {
            if (IS_TEST_VERSION && VIRTUAL_FLAG) {
                $class = new \ReflectionClass(ucfirst($conName . 'Controller'));
                $method = $class->getMethod($actName . 'Action');
                $desc = $method->getDocComment();
                $statusRegex = '/@[\s]*status[\s]*(.*?)[\r\n*]/';
                $status = '';
                if (preg_match($statusRegex, $desc, $m)) {
                    $status = $m[1];
                }
                if (!strlen($status)) {
                    $status = 0;
                }
                if ($status == 0) {
                    $this->doctype = 'response';
                    $this->virtual = true;
                }
            }
        } else {
            if (!STATIC_FLAG) {
                exit('<h1 style="text-align:center;">已关闭静态API的显示使用</h1>');
            }
            $this->tag->setTitle(PROJECT_NAME);
        }
    }

    private function handleData(&$data, $dataExplain = null, $pageFlag = false)
    {
        if ($this->doctype == 'response' && $this->virtual) {
            if (isset($data['data']['illustrate'])) {
                unset($data['data']['illustrate']);
            }
            if ($pageFlag) {
                $this->setPageData($data['data']);
            }
        }
        if ($this->doctype == 'response' && !$this->virtual) {
            $return = [];
            if (isset($data['data']['illustrate'])) {
                if ($pageFlag) {
                    $data['data']['illustrate'] = '' . $data['data']['illustrate'];
                }
                $return['illustrate'] = $data['data']['illustrate'];
                unset($data['data']['illustrate']);
            } else if ($pageFlag) {
                $return['illustrate'] = '';
            }
            if ($pageFlag) {
                $this->setPageData($data['data']);
            }
            $dataExplain = empty($dataExplain) ? $this->code['api']['explain'] : array_merge($this->code['api']['explain'], $dataExplain);
            $return['str'] = $this->jsonFormat($data, $dataExplain);
            return $return;
        }
        return true;
    }

    public function output($data = [], $dataExplain = null, $pageFlag = false)
    {
        $output = [
            'status' => $data['code'] ? 0 : 1,
            'code' => '',
            'msg' => '',
            'data' => [],
            'need_relogin' => '0'
        ];
        $output = array_merge($output, $data);
        $flag = $this->handleData($output, $dataExplain, $pageFlag);
        if ($flag !== true) {
            return $flag;
        }
        header('content-type: text/json');
        if (is_array($output['data']) && empty($output['data'])) {
            $output['data'] = new \stdClass();
        }
        if (IS_TEST_VERSION) {
            header("Access-Control-Allow-Origin: *");
        }
        exit(json_encode($output));
    }

    private function jsonFormat($data, $dataExplain = null, $indent = '&nbsp;&nbsp;&nbsp;&nbsp;', $newline = '<br/>')
    {
        array_walk_recursive($data, function (&$val) {
            if ($val !== true && $val !== false && $val !== null) {
                if ($val != new stdClass()) {
                    $val = urlencode($val);
                }
            }
        });
        if (is_array($data['data']) && empty($data['data'])) {
            $data['data'] = new \stdClass();
        }
        $data = json_encode($data);
        $data = urldecode($data);
        $ret = '';
        $pos = 0;
        $length = strlen($data);
        $nextChar = $prevchar = '';
        $outofquotes = true;
        $flagStart = $flagEnd = true;
        for ($i = 0; $i <= $length; $i++) {
            $char = $nextChar === '' ? substr($data, $i, 1) : $nextChar;
            $nextChar = substr($data, $i + 1, 1);
            if ($char == '"' && $prevchar != '\\') {
                $outofquotes = !$outofquotes;
            } else if ((($char == '}' && $prevchar != '{' || $char == ']' && $prevchar != '[')) && $outofquotes) {
                $ret .= $newline;
                $pos --;
                for ($j = 0; $j < $pos; $j++) {
                    $ret .= $indent;
                }
            }
            if ($char == '"' && $flagStart && $nextChar != ']' && $nextChar != '}') {
                $strLength = strpos($data, '"', $i + 1) - $i + 1;
                $temp = substr($data, $i + 1, $strLength);
                if ($temp[$strLength - 1] == ':') {
                    $str = substr($temp, 0, $strLength - 2);
                    $title = '暂无提示信息';
                    if (isset($dataExplain[$str])) {
                        $summary = isset($dataExplain[$str]['summary']) ? $dataExplain[$str]['summary'] : '';
                        $type = isset($dataExplain[$str]['type']) ? $dataExplain[$str]['type'] : 'string';
                        if (strlen($summary)) {
                            $title = $summary;
                            if (strlen($type)) {
                                $title .= "&emsp;{$type}";
                            }
                        } else {
                            if (strlen($type)) {
                                $title = $type;
                            }
                        }
                    }
                    $ret .= "<span title='{$title}' class='tooltip'>";
                    $flagStart = false;
                }
            } else if ($char == ':' && $flagEnd && !$flagStart) {
                $ret .= '</span>';
                $flagEnd = false;
            }
            if ($char == ',' && $nextChar == '"' || $char == '{' || $char == '[' || $char == '}' || $char == ']') {
                $flagStart = $flagEnd = true;
            }
            $ret .= $char;
            if (($char == ',' && ($nextChar == '"' || $nextChar == '{' || $nextChar == '[') || $char == '{' && $nextChar != '}' || $char == '[' && $nextChar != ']') && $outofquotes) {
                $ret .= $newline;
                if ($char == '{' || $char == '[') {
                    $pos ++;
                }
                for ($j = 0; $j < $pos; $j++) {
                    $ret .= $indent;
                }
            }
            $prevchar = $char;
        }
        return $ret;
    }

    public function setParameter($pmtHeader = null, $pmtBody = null, $pageFlag = false, $notice = '')
    {
        $pmtHeader = $this->headerMerge($pmtHeader);
        $parameters = [
            'header' => $pmtHeader,
        ];
        if (isset($pmtBody) && is_array($pmtBody)) {
            $parameters['body'] = $pmtBody;
        }
        $tempStr1 = '<td class="handle_hide" colspan="5"><span class="handle_hide font_color_red">注意:\\n</span>R-必填(Required), O-可选(Optional), C-报文中该参数在一定条件下可选(Conditional)';
        $tempStr2 = '<span class="handle_hide">加密内容, APPID与validtime(10位时间戳)英文逗号拼接;\\n加密方式, ENCRYPT_KEY加密(AES/128/CBC/NoPadding)加密内容</span>';
        if (empty($notice) && !$pageFlag) {
            $parameters['notice'] = $tempStr1 . ";\\n" . $tempStr2;
        } else {
            $parameters['notice'] = str_replace('"handle_hide', '"', $tempStr1) . ';\\n' . str_replace("</span>", ';\\n</span>', $tempStr2) . $notice;
            if (!empty($notice) && $pageFlag) {
                $parameters['notice'] .= ';\\n';
            }
        }
        if ($pageFlag) {
            $this->setPageParameter($parameters);
        }
        $parameters['notice'] .= "</td>";
        return $parameters;
    }

    private function headerMerge($pmtHeader = null)
    {
        $header = $this->code['api']["header"];
        if (isset($pmtHeader) && is_array($pmtHeader)) {
            foreach ($header as $key => $head) {
                $name = $head["name"];
                if (isset($pmtHeader[$name])) {
                    if (!isset($pmtHeader[$name]['required'])) {
                        $pmtHeader[$name]['required'] = 'R';
                    }
                    foreach ($pmtHeader[$name] as $k => $v) {
                        $header[$key][$k] = $v;
                    }
                }
            }
        }
        return $header;
    }

    private function setPageParameter(&$data = null)
    {
        if (isset($data)) {
            $pmtBody = [
                [
                    'name' => 'page',
                    'type' => 'int',
                    'required' => 'O',
                    'remark' => '切换页码',
                ],
                [
                    'name' => 'perpage',
                    'type' => 'int',
                    'required' => 'O',
                    'remark' => "分页条数",
                ],
            ];
            $data['body'] = isset($data['body']) ? array_merge($pmtBody, $data['body']) : $pmtBody;
            $str = '分页参数page默认显示第一页数据;\\nperpage不传将以服务器为准, 否则以传的值为准';
            $data['notice'] = "{$data['notice']}" . $str;
        }
    }

    private function setPageData(&$data)
    {
        $paging = [
            'paging' => [
                'total_page' => '1',
                'current_page' => '1',
                'perpage' => '5',
                'total_items' => '2',
            ],
        ];
        $data = array_merge($paging, $data);
    }

}

//
