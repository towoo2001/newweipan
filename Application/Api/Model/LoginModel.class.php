<?php
namespace Api\Model;
use Think\Model;
class LoginModel extends Model{
    protected $userTableName = 'wp_userinfo';
    public function getUserInfo($mobile){
        return $this->where("utel = '{$mobile}'")->find();
    }
   
}