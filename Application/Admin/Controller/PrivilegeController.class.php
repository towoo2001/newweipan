<?php
namespace Admin\Controller;
use Think\Controller;
class PrivilegeController extends BaseController{
    /**
     * 添加权限
     */
    public function addPrivilege(){
        $model = D('Privilege');
        $list = $model->getPrivilegeData();
        $list = _infinite($list,0,0);
        $this->assign('list',$list);
        if(IS_POST){
            if(!$model->create($model->addPrivilegeData())){
                $this->error($model->getError());
            }
            if($model->add($model->addPrivilegeData())){
                $this->success('添加成功',U('privilegeList'));exit;
            }else{
                $this->error('添加失败');
            }
        }
        $this->display();
    }
    /**
     * 权限列表
     */
    public function privilegeList(){
        $list = D('Privilege')->getPrivilegeData();
        //无限极分类
        $list = _infinite($list,0,0);
        $this->assign('list',$list);
        $this->display();
    }
    /**
     * 修改权限
     */
    public function editPrivilege(){
        $model = D('Privilege');
        $list = $model->getPrivilegeData();
        $list = _infinite($list,0,0);
        $this->assign('list',$list);
        $id = intval($_GET['id']);
        $row = R('Server/PrivServer/editPriv',array($id));
        $this->assign('row',$row);
        if(IS_POST){
              if($model->create($_POST)){
                  if($model->data($_POST)->save()!==false){
                      $this->success('修改成功',U('privilegeList'));exit;
                  }else{
                      $this->error('修改失败');
                  }
              }
        }
        $this->display();
    }
    /**
     * 删除权限
     */
    public function delPrivilege(){
        $id = intval($_GET['id']);
        $data = R('Server/PrivServer/getPrivRow',array($id)); 
        if($data){
            $this->success('删除成功');exit;
        }else{
            $this->error('删除失败');
        }
    }
    /**
     * 添加角色
     */
    public function addRole(){
        $model = D('Privilege');
        $list = $model->getPrivilegeData();
        $list = _infinite($list,0,0);
        $this->assign('list',$list);
        if(IS_POST){
            $dada['role_name'] = $_POST['rowname'];
            $dada['privilege_id'] = implode(',', I('post.priv_id'));
            $dada['role_type'] = $_POST['roletype'];

            if(M('Role')->add($dada)){
                $this->success('添加成功',U('roleList'));exit;
            }else{
                $this->error('添加失败');
            }
        }
        $this->display();
    }
    /**
     * 角色列表
     */
    public function roleList(){
        $list = R('Server/PrivServer/roledata');
        $this->assign('list',$list);
        $this->display();
    }
    /**
     * 修改角色具备的权限
     */
    public function editRole(){
        //获取权限
        $model = D('Privilege');
        $list = $model->getPrivilegeData();
        $list = _infinite($list,0,0);
        $this->assign('list',$list);
        //根据id读取当前值
        $id = intval($_GET['id']);
        $row = R('Server/PrivServer/roleRow',array($id));

        $this->assign('row',$row);
        if(IS_POST){
            $dada['role_name'] = $_POST['rowname'];
            $dada['privilege_id'] = implode(',', I('post.priv_id'));
            $id = I('post.id');
            if(M('Role')->where("id = $id")->save($dada)!==false){
                $this->success('修改成功',U('roleList'));exit;
            }else{
                $this->error('添加失败');
            }
        }
        
        $this->display();
    }
    /**
     * 删除角色
     */
    public function  delRole(){
        $id = intval($_GET['id']);
        if(M('Role')->where("id = $id")->delete()!==false){
            $this->success('删除成功',U('roleList'));exit;
        }else{
            $this->error('删除失败');
        } 
    }    
    /**
     * 添加管理员
     */
    public function addAdmin(){
        $list = R('Server/PrivServer/getRow');
        $this->assign('list',$list);
        $model = D('Userinfo');
        if(IS_POST){
            $data['username'] = I('post.username');
            $data['otype'] = I('post.role_id');
            $data['upwd'] = md5(I('post.password'));
            $repassword =   md5(I('post.repassword'));
            $data['ustatus'] = 0;
            if(empty($data['username'])) $this->error('用户名不能为空');
            if(empty($data['username'])) $this->error('所属角色必须选择');
            if($repassword != $data['upwd']) $this->error('密码输入不一致');
            if($model->add($data)){
                $this->success('添加成功');exit;
            }else{
                $this->error('添加失败');
            }  
        }
        $this->display();
    }
    /**
     * 管理员列表
     */
    public function adminList(){
        $list = R('Server/PrivServer/getAdmin');
        $this->assign('list',$list);
        $this->display();
    }
    
    public function editAdmin(){
        $id = intval($_GET['id']);
        $row = R('Server/PrivServer/getAdminRow',array($id));
        $this->assign('row',$row);
        //获取角色列表
        $list = R('Server/PrivServer/roledata');
        $this->assign('list',$list);
        if(IS_POST){
            $id = I('post.id');
            $data['username'] = I('post.username');
            $data['otype'] = I('post.role_id');
            $oldpwd = md5(I('post.oldpassword'));
            $data['upwd'] = md5(I('post.newpassword'));
            $repassword =   md5(I('post.renewpassword'));
            $data['ustatus'] = 0;
            if(empty($data['username'])) $this->error('用户名不能为空');
            if(empty($data['username'])) $this->error('所属角色必须选择');
            if($repassword != $data['upwd']) $this->error('密码输入不一致');
            $row = R('Server/PrivServer/getAdminRow',array($id));
            if($row['upwd']!==$oldpwd){
                $this->error('原密码不正确');
            }
            if(M('Userinfo')->where("uid = $id")->save($data)!==false){
                $this->success('修改成功',U('adminList'));exit;
            }else{
                $this->error('修改失败');
            }
           
            
        }
        $this->display();
        
    }
    
    public function delAdmin(){
        $uid = intval($_GET['id']);
        //设置一个token
      
        
        if(M('Userinfo')->where("uid = $uid")->delete()!==false){
            $this->success('删除成功',U('adminList'));exit;
        }else{
            $this->error('删除失败');
        }
        
    }
    
}