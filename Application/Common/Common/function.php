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
function Getzimu($str)
{
    $str= iconv("UTF-8","gb2312", $str);//如果程序是gbk的，此行就要注释掉
    if (preg_match("/^[\x7f-\xff]/", $str))
    {
        $fchar=ord($str{0});
        if($fchar>=ord("A") and $fchar<=ord("z") )return strtoupper($str{0});
        $a = $str;
        $val=ord($a{0})*256+ord($a{1})-65536;
        if($val>=-20319 and $val<=-20284)return "A";
        if($val>=-20283 and $val<=-19776)return "B";
        if($val>=-19775 and $val<=-19219)return "C";
        if($val>=-19218 and $val<=-18711)return "D";
        if($val>=-18710 and $val<=-18527)return "E";
        if($val>=-18526 and $val<=-18240)return "F";
        if($val>=-18239 and $val<=-17923)return "G";
        if($val>=-17922 and $val<=-17418)return "H";
        if($val>=-17417 and $val<=-16475)return "J";
        if($val>=-16474 and $val<=-16213)return "K";
        if($val>=-16212 and $val<=-15641)return "L";
        if($val>=-15640 and $val<=-15166)return "M";
        if($val>=-15165 and $val<=-14923)return "N";
        if($val>=-14922 and $val<=-14915)return "O";
        if($val>=-14914 and $val<=-14631)return "P";
        if($val>=-14630 and $val<=-14150)return "Q";
        if($val>=-14149 and $val<=-14091)return "R";
        if($val>=-14090 and $val<=-13319)return "S";
        if($val>=-13318 and $val<=-12839)return "T";
        if($val>=-12838 and $val<=-12557)return "W";
        if($val>=-12556 and $val<=-11848)return "X";
        if($val>=-11847 and $val<=-11056)return "Y";
        if($val>=-11055 and $val<=-10247)return "Z";
    }
    else
    {
        return false;
    }
}

