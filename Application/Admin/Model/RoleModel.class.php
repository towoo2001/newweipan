<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model{
    const SYSTEM = 1;    //系统用户
    const USER = 2;   //普通用户
}