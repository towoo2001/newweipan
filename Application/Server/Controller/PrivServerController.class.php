<?php
namespace Server\Controller;
use Think\Controller;
class PrivServerController extends Controller {
    public function getPrivRow($id) {
        $id = intval($id);
        $result = M('Privilege')->field('id')->where("parent_id = $id")->select();
        if(!empty($result)){
            $this->error('该栏目下还有子栏目，请先删除子栏目');
        }
        if(M('Privilege')->where("id = $id")->delete()!==false){
           return true;
        }else{
           return false;
        }
    }
    /**
     * 获取一条信息
     * @param unknown $id
     */
    public function editPriv($id){
        //根据id查询当前数据信息
        $row = M('Privilege')->where("id = $id")->find();
        return $row;
    }
    
    /**
     * 角色具备有哪些权限
     */
    public function roledata() {
       $list = M('Role')->select();
       
       foreach($list as $k=>$v){
           $privilegelist = '';
           $priv = M('Privilege')->field('privilege_name')->where("id in({$v['privilege_id']})")->select();
           foreach($priv as $v1){
               $privilegelist .=$v1['privilege_name'].',';
           }
           $list[$k]['privilegelist'] = rtrim($privilegelist,',');
       }
       return $list;
    }
    /**
     * 读取角色的值
     */
    public function roleRow($id){
        $row = M('Role')->where("id = $id")->find();
        return $row;
    }
    /**
     * 获取角色列表
     */
    public function getRow(){
        $list = M('Role')->field("id,role_name")->where("role_type = 1")->select();
        return $list;
    }
    public function getAdmin(){
        $role = D('role');
        $sql = "select group_concat(concat(id)) as ids from wp_role";
        $ids = M()->query($sql);
        empty($ids[0]['ids']) ? $this->error('请添加角色') : $ids = $ids[0]['ids'];
        $list = M('Userinfo')->field("a.uid,a.upwd,a.username,b.role_name")->join("a left join wp_role b on a.otype = b.id")->where("a.otype in ({$ids}) and a.otype = ".$role::SYSTEM)->select();
        return $list;
    }
    public function getAdminRow($id){
        $row = M('Userinfo')->where("uid = $id")->find();
        return  $row;
    }
    
    /**
     * 去除菜单栏
     */
    public function getButton(){
        //思路：根据登录管理员到id,分别获取权限按钮，要求只取出前两级的按钮。
        $admin_id = intval($_SESSION['login']['uid']);
        if(empty($admin_id)) $this->error('必须登陆',U('User/login'));
        
        if($admin_id==285){
            //则是超级管理员
            //先取出顶级权限，再根据顶级权限取出其子级权限。
            $sql="select * from wp_privilege where  parent_id = 0";
            $arr = M()->query($sql);//返回的是二维数组
            //再根据顶级权限取出其子级权限
            foreach($arr as $k=>$v){
                $sql="select * from wp_privilege where parent_id={$v['id']} and is_show = 0";
                $arr[$k]['child']=M()->query($sql);
            }
        }else{
            //去除该用户下具备的权限id
            $sql = "select b.privilege_id from wp_userinfo  a left join wp_role b on otype = b.id   where a.uid = {$admin_id}"; 
            $list = M()->query($sql);
            
            //取出该栏目下伏击栏目
            $sql = "select * from (select * from wp_privilege where id in({$list[0]['privilege_id']})) a having parent_id = 0";
            $arr = M()->query($sql);
            
            //根据父级的id取出子集
            foreach($arr as $k=>$v){
                $sql = "select * from wp_privilege where parent_id = {$v['id']}  and is_show = 0";
                $arr[$k]['child']=M()->query($sql);
            }
        }
        return $arr;
    }
    
    
}