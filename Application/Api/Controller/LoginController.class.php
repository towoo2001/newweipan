<?php
namespace Api\Controller;
use Think\Controller;
use Api\Model;
/**
 * 登录接口类
 * @author Administrator
 */
class LoginController extends BaseController{
    public function __construct(){
        self::checkLogin();
    }
    /**
     * 登录
     */
    public function login() {
        //验证是否是POST提交
       if(!IS_POST){
          return self::formatResult(8, 'Not post submission');
       }
        $user =  new Model\LoginModel();
        $mobile = I('post.mobile');
        $password = I('post.passowrd');
        
        //查询用户信息
        $userinfo = $user->getUserInfo($mobile);
        if(empty($userinfo)){
            $this->ajaxReturn(self::formatResult(9, 'The user does not exist'));
        }
        //验证用户信息是否正确
        if(md5($password)!==$userinfo['upwd']){
            $this->ajaxReturn(self::formatResult(10, 'Password mistake'));
        }
        //设置Token
        $token = self::set_Token($userinfo['utel'],$userinfo['upwd']);
        //将Token放置在session中
        session(array('name'=>$mobile,'expire'=>3600*24*7));
        session($mobile,$token);
        $this->ajaxReturn(self::formatSuccessResult($token));
    }
}