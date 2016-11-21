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
        $list = M('Role')->field("id,role_name")->select();
        return $list;
    }
    public function getAdmin(){
        $sql = "select group_concat(concat(id)) as ids from wp_role";
        $ids = M()->query($sql);
        empty($ids[0]['ids']) ? $this->error('请添加角色') : $ids = $ids[0]['ids'];
        
        $list = M('Userinfo')->field("a.uid,a.upwd,a.username,b.role_name")->join("a left join wp_role b on a.otype = b.id")->where("a.otype in ({$ids})")->select();
        return $list;
    }
    public function getAdminRow($id){
        $row = M('Userinfo')->where("uid = $id")->find();
        return  $row;
    }
    
    
}