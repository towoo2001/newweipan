<?php
namespace Admin\Controller;
use Think\Controller;
class  BaseController extends Controller{
	public function _initialize(){
		$admin_id = 285;
		
		if(empty($admin_id)){
		    $admin_id = cookie('admin_id');
		}
		
		if($admin_id > 0){
			//如果是超级管理员则不需要验证
			if($_SESSION['admin_id']==285){
				return true;
			}
			if(CONTROLLER_NAME =='Index'){
				return true;
			}
			//取出当前登陆管理员权限具备的权限
			$url = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
			$sql = "select b.privilege_id from wp_userinfo  a left join wp_role b on otype = b.id   where a.uid = {$admin_id}"; 
			$list = M()->query($sql);
			$sql = "select * from (select * from wp_privilege where id in({$list[0]['privilege_id']})) a having privilege_url = '{$url}' ";
			$info = M()->query($sql);
			if($info){
				return true;
			}else{
                
				$this->error('你无权操作');
			}
			return true;
		}else{
			$this->error('必须登陆',U('Login/login'));
		}
	}
}