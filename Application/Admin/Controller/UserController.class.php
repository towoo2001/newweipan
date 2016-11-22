<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller {
    /**
     * 用户登录
     * */
    public function login(){
        if(IS_POST){
            $condition['username'] = I('post.username');
            $condition['upwd'] = md5(I('post.password'));
            $user = D('userinfo');
            $result = $user->login($condition);
            if(empty($result)){
                $this->error('用户名或密码错误!');
            } else {
                session('login',"{$result['username']}",time()+3600);
                $this->success('登录成功!', U('Index/index'));
            }
        } else {
            $this->display();
        }
    }

    /**
     * 用户列表
     * */
    public function index(){
        $this->display();exit;
        $user = D('userinfo');
        $get = $_GET;
        $condition = "u.ustatus = ".$user::STATUS_ON;
        //根据手机号码查询
        if($get['phone']) {
            $condition .= " and u.utel like '%".$get['phone']."%'";
            $sea['phone'] = $get['phone'];
        }
        //根据名称查询
        if($get['username']) {
            $condition .= " and u.username like '%".$get['username']."%'";
            $sea['username'] = $get['username'];
        }
        //根据时间查询
        if($get['starttime']){
            $time = strtotime($get['starttime']);
            $condition .= " and u.utime > $time";
            $sea['starttime'] = $get['starttime'];
        }
        if($get['endtime']) {
            $time = strtotime($get['endtime']);
            $condition .= " and u.utime < $time";
            $sea['endtime'] = $get['endtime'];
        }
        if($get['starttime'] && $get['endtime']) {
            $sTime = strtotime($get['starttime']);
            $eTime = strtotime($get['endtime']);
            $condition .= " and u.utime between $sTime and $eTime";
            $sea['starttime'] = $get['starttime'];
            $sea['endtime'] = $get['endtime'];
        }
        if($get['status']){
            $status = $get['status']-1;
            $condition .= " and u.ustatus = {$status}";
        }
        if($get['type']){
            $type = $get['type']-1;
            $condition .= " and u.otype = {$type}";
        }
        if($get['oid']){
            $condition .= " and u.oid = ".$get['oid'];
            $order = "u.otype desc,u.uid desc";
            $sea['oid'] = $get['oid'];
        } else{
            $condition .= " and u.otype = ".$user::TYPE_MEMBER;
            $order = "u.uid desc";
        }
        $field = 'u.uid,u.username,u.nickname,u.utel,u.address,u.utime,u.oid,u.managername,u.lastlog,a.balance,u.otype';
        $ulist = $user->getMemberList($field,$condition,$order);
        $this->assign('ulist',$ulist);
        $this->assign('sea',$sea);
        $this->display();
    }

    /**
     * 添加用户
     * */
    public function create(){
        if(IS_POST){
            $user = D('userinfo');
            $reault = $user->create($_POST);
            if(!$reault){
                $this->error($user->getError());
            } else {
                if($user->add($_POST)){
                    $this->success('添加成功！',U('User/index'));
                }
            }
        } else {
            $this->display();
        }
    }

    /**
     * 修改用户
     * */
    public function update(){
        if(IS_POST){


        } else {

            $this->display();
        }
    }

    /**
     * 删除用户
     * */
    public function delete(){

    }
}