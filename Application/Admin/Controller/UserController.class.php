<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller {
    /**
     * 用户登录
     * */
    public function login(){
        if(IS_POST){
            $user = I('post.username');
            $pwd = md5(I('post.password'));
            $condition = "(username = '{$user}' and upwd = '{$pwd}') or (utel = '{$user}' and upwd = '{$pwd}')";
            $result = R('Server/UserServer/login',array($condition));
            if(empty($result)){
                $this->error('登录失败!');
            } else {
                $id = $result['uid'];
                $arr = array('uid' => $id,'username' => $result['username'],'otype' => $result['otype'],'comname' => $result['comname']);
                $data['lastlog'] = time();
                //记录登录时间
                R('Server/UserServer/lastLogin',array($id,$data));
                session(array('name' => 'login','expire' =>time()+3600));
                session('login',$arr);
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
        $get = $_GET;
        $ulist = R('Server/UserServer/getMemberList',array($get));
        $this->assign('ulist',$ulist['ulist']);
        $this->assign('sea',$ulist['sea']);
        $this->assign('page',$ulist['page']);
        $this->assign('type',$ulist['type']);
        $this->display();
    }

    /**
     * 修改用户
     * */
    public function update(){
        if(IS_POST){
            if($_POST['uid']){
                //修改
                $result = R('Server/UserServer/updateUser',array($_POST));
                if($result){
                    $this->success('修改成功！',U('User/index'));
                } else{
                    $this->error('修改失败！');
                }
            } else {
                //添加
                $result = R('Server/UserServer/addUser',array($_POST));
                if($result){
                    $this->success('添加成功！',U('User/index'));
                } else{
                    $this->error('添加失败！');
                }
            }
        } else {
            if($_GET['uid']){
                $data = R('Server/UserServer/getOneList',array($_GET['uid']));
                $this->assign('data',$data);
            }
            $dl = R('Server/UserServer/dropDownList');
            $this->assign('dl',$dl);
            $this->display();
        }
    }

    /**
    * 删除用户
    * */
    /*public function delete(){
        $user = D('userinfo');
        $arr = array('ustatus' => $user::STATUS_OFF);
        $result = R('Server/UserServer/deleteUser',array($_GET['uid'],$arr));
        if($result){
            $this->success('删除成功！',U('User/index'));
        } else{
            $this->error('删除失败！');
        }
    }*/

    /**
     * 切换状态
     * */
    public function statusChange(){
        $id = $_GET['uid'];
        $result = R('Server/UserServer/statusChange',array($id));
        $this->redirect('User/index');
    }

    /**
     * 用户详情
     * */
    public function detail(){
        $data = R('Server/UserServer/detailUser',array($_GET['uid']));
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 退出
     * */
    public function logout(){
        session('login','');
        $this->redirect('User/login');
    }
}
