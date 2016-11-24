<?php
namespace Api\Model;
use Think\Model;
class LoginModel extends Model{
    
    protected $trueTableName = 'wp_userinfo';
    /**
     * 根据用户手机号码查询是否存在该账户
     * @param unknown $mobile
     */
    public function getUserInfo($mobile){
        return $this->where("utel = '{$mobile}'")->find();
    }
    public function checkLogin(){
        
    }
    
   
}