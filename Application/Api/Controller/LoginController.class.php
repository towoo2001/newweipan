<?php
namespace Api\Controller;
use Think\Controller;
use Api\Model;
/**
 * 登录接口类
 * @author Administrator
 *
 */
class LoginController extends Controller{
    public function login() {
        
        if(IS_POST){
            //获取提交过来的用户名
            $mobile = I('post.mobile');
            $password = I('post.password');
            //根据手机号码查询改帐号是否存在
            $user = new Model\LoginModel();
            $info = $user->getUserInfo($mobile);
            if(empty($info)){
                $data = array('');
               
            }
        }
    }
}