<?php

function pre($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}
/**
 * TODO 基础分页的相同代码封装，使前台的代码更少
 * @param $m 模型，引用传递
 * @param $where 查询条件
 * @param int $pagesize 每页查询条数
 * @return \Think\Page
 */
function getpage(&$m,$where,$pagesize=10){
    $m1=clone $m;//浅复制一个模型
    $count = $m->where($where)->count();//连惯操作后会对join等操作进行重置
    $m=$m1;//为保持在为定的连惯操作，浅复制一个模型
    $p=new Think\Page($count,$pagesize);
    $p->lastSuffix=false;
    $p->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;每页<b>%LIST_ROW%</b>条&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
    $p->setConfig('prev','上一页');
    $p->setConfig('next','下一页');
    $p->setConfig('last','末页');
    $p->setConfig('first','首页');
    $p->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
    $p->parameter=I('get.');
    $m->limit($p->firstRow,$p->listRows);
    return $p;
}
/**
 * 分页方法调用实例
 * $m=M('products');
 * $p=getpage($m,$where,10);
 * $list=$m->field(true)->where($where)->order('id desc')->select();
 * $this->list=$list;
 * $this->page=$p->show();
 * 
 */


/**
 * 无限极分类
 * @param unknown $list
 * @param number $parent_id
 * @param number $deep
 */

function _infinite($list,$parent_id=0,$deep=0){
    static $arr = array();
    foreach ($list as $v){
        if($v['parent_id']==$parent_id){
            $v['deep'] = $deep;
            $arr[] = $v;
            _infinite($list,$v['id'],$deep+1);
        }
    }
    return $arr;

}

/**
 * 设置一个令牌
 */
function set_token() {
    $_SESSION['token'] = md5(microtime(true));
}
/**
 * 验证令牌
 * @return boolean
 */
function valid_token() {
    $return = $_REQUEST['token'] === $_SESSION['token'] ? true : false;
    set_token();
    return $return;
}