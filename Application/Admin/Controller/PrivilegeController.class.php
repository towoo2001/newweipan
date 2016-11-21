<?php
namespace Admin\Controller;
use Think\Controller;
class PrivilegeController extends Controller{
    /**
     * 添加权限
     */
    public function addPrivilege(){
        $model = D('Privilege');
        if(IS_POST){
            if(!$model->create($model->addPrivilegeData())){
                $this->error($model->getError());
            }
            if($model->add($model->addPrivilegeData())){
                $this->success('添加成功');exit;
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
        
    }
    /**
     * 删除权限
     */
    public function delPrivilege(){
        
    }
}