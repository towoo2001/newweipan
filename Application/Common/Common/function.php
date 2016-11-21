<?php

function pre($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}


/**
 *
 * @param unknown $count  总数
 * @param number $pagesize  每页显示条数
 * @param unknown $row  查询条件
 */
function page($count,$pagesize=10,$row = array()){
    $page = new \Think\Page($count , $pagesize);
    $page->parameter = $row; //此处的row是数组，为了传递查询条件
    $page->setConfig('first','首页');
    $page->setConfig('prev','&#8249;');
    $page->setConfig('next','&#8250;');
    $page->setConfig('last','尾页');
    $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
    return $page;
}

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