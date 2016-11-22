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
function page($count,$pagecount=10,$row = array()){
    $page = new \Think\Page($count , $pagecount);
    $page->parameter = $row; //此处的row是数组，为了传递查询条件
    $page->setConfig('first','首页');
    $page->setConfig('prev','上一页');
    $page->setConfig('next','下一页');
    $page->setConfig('last','尾页');
    $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% 第 '.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)');
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