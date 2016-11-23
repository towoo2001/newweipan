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


function getpage($count, $pagesize = 10) {
    $p = new Think\Page($count, $pagesize);
    $p->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录 第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
    $p->setConfig('prev', '上一页');
    $p->setConfig('next', '下一页');
    $p->setConfig('last', '末页');
    $p->setConfig('first', '首页');
    $p->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
    $p->lastSuffix = false;//最后一页不显示为总页数
    $p->parameter=I('get.');
    return $p;
}


/**
 * 分页方法调用实例
 * $m = M('User');
 *   $where = "id>10";
 *   $count = $m->where($where)->count();
 *   $p = getpage($count,1);
 *   $list = $m->field(true)->where($where)->order('id')->limit($p->firstRow, $p->listRows)->select();
 *   $this->assign('select', $list); // 赋值数据集
 *   $this->assign('page', $p->show()); // 赋值分页输出
 *   $this->display();
 *
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
