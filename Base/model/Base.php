<?php

namespace Base\Model;

class Base extends \Windward\Mvc\Model
{

    public function questionList($sh = null)
    {
        $this->switchSlave();
        $curpage = $sh['page'];
        $perpage =isset($sh['perpage']) ? $sh['perpage'] : current(array_keys($this->codeConfig["paging"]["demo"]))?:10;
        $sql = "select * from tb_user a where a.deleted = 0 ";
        $cond = [];
        
        if ($sh['mobile']) {
            $cond['[lk]a.mobile'] = $sh['mobile'];
        }
        
        if ($sh['name']) {
            $cond['[lk]a.name'] = $sh['name'];
        }
        
        if ($sh['begin']) {
            $cond['[tgt]money'] = $sh['begin']; //数组库的datetime字段 >= 某个时间 tge:>=,tgt:>
        }
        if ($sh['end']) {
            $cond['[tlt]money'] = $sh['end']; ///数组库的datetime字段 <= 某个时间 tle:<=,tlt:<
        }
        
        if ($sh['begin']) {
            $cond['[tgt]created'] = $sh['begin']; //数组库的datetime字段 >= 某个时间 tge:>=,tgt:>
        }
        if ($sh['end']) {
            $cond['[tlt]created'] = $sh['end']; ///数组库的datetime字段 <= 某个时间 tle:<=,tlt:<
        }
        
        $params = $this->cond($sql, $cond);
        $this->orderBy($sql, 'a.desc', $this->codeConfig['order']['demo']);      
       
        $list = $this->paginate($sql, $curpage, $perpage, $params);        
        array_walk($list['items'], function(&$item) {
            $item['answer'] = json_decode($item['answer'], true);
        });
        return $list;
    }
    
    public function yajList($sh = null)
    {
        $this->switchSlave();
        $curpage = $sh['page'];
        $perpage =isset($sh['perpage']) ? $sh['perpage'] : current(array_keys($this->codeConfig["paging"]["demo"]))?:10;
        $sql = "
                select pay_type,price from tb_user_deposit a
                left join tb_user_recharge_log b on a.id=b.id_user               
                where a.deleted = 0 ";
        $cond = [];      
        
        if ($sh['id']) {
            $cond['id'] = $sh['id'];
        }
        
        $params = $this->cond($sql, $cond);
        $this->orderBy($sql, 'a.desc', $this->codeConfig['order']['demo']);
        $list = $this->paginate($sql, $curpage, $perpage, $params);
        return $list;
        
    }
        
    public function bikeList($sh = null)
    {
        $this->switchSlave();
        $curpage = $sh['page'];
        $perpage =isset($sh['perpage']) ? $sh['perpage'] : current(array_keys($this->codeConfig["paging"]["demo"]))?:10;
        $sql = "select * from tb_bicycle a where a.deleted = 0 ";
        $cond = [];
        
        if ($sh['code']) {
            $cond['[lk]a.code'] = $sh['code'];
        }
        
        if ($sh['status']) {
            $cond['[lk]a.status'] = $sh['status'];
        }
               
        $params = $this->cond($sql, $cond);
        $this->orderBy($sql, 'a.desc', $this->codeConfig['order']['demo']);
        $list = $this->paginate($sql, $curpage, $perpage, $params);
        return $list;
    }
    
    public function bookLog($sh = null)
    {
        $this->switchSlave();
        $curpage = $sh['page'];
        $perpage =isset($sh['perpage']) ? $sh['perpage'] : current(array_keys($this->codeConfig["paging"]["demo"]))?:10;
        $sql = "select * from tb_bicycle_book_log a where a.deleted = 0 ";
        $cond = [];
        
        if ($sh['code']) {
            $cond['[lk]a.code'] = $sh['code'];
        }
        
        if ($sh['begin']) {
            $cond['[tgt]created'] = $sh['begin']; //数组库的datetime字段 >= 某个时间 tge:>=,tgt:>
        }
        if ($sh['end']) {
            $cond['[tlt]created'] = $sh['end']; ///数组库的datetime字段 <= 某个时间 tle:<=,tlt:<
        }
               
        $params = $this->cond($sql, $cond);
        $this->orderBy($sql, 'a.desc', $this->codeConfig['order']['demo']);
        $list = $this->paginate($sql, $curpage, $perpage, $params);
        return $list;
    }
    
    public function managerList($sh = null)
    {
        $this->switchSlave();
        $curpage = $sh['page'];
        $perpage =isset($sh['perpage']) ? $sh['perpage'] : current(array_keys($this->codeConfig["paging"]["demo"]))?:10;
        $sql = "select * from tb_system_admin a where a.deleted = 0 ";
        $cond = [];
        
        if ($sh['code']) {
            $cond['[lk]a.code'] = $sh['code'];
        }
        
        if ($sh['status']) {
            $cond['[lk]a.status'] = $sh['status'];
        }
               
        $params = $this->cond($sql, $cond);
        $this->orderBy($sql, 'a.desc', $this->codeConfig['order']['demo']);
        $list = $this->paginate($sql, $curpage, $perpage, $params);
        return $list;
    }
    
    public function configurationList($sh = null)
    {
        $this->switchSlave();
        $curpage = $sh['page'];
        $perpage =isset($sh['perpage']) ? $sh['perpage'] : current(array_keys($this->codeConfig["paging"]["demo"]))?:10;
        $sql = "select * from tb_system_config a where a.deleted = 0 ";
        $cond = [];
        
        if ($sh['code']) {
            $cond['[lk]a.code'] = $sh['code'];
        }
        
        if ($sh['status']) {
            $cond['[lk]a.status'] = $sh['status'];
        }
               
        $params = $this->cond($sql, $cond);
        $this->orderBy($sql, 'a.desc', $this->codeConfig['order']['demo']);
        $list = $this->paginate($sql, $curpage, $perpage, $params);
        return $list;
    }
    
    use \Base\Traits\Base;
}
