<?php
namespace Admin\Model;
use Think\Model;
class PrivilegeModel extends Model{
    /**
     * 
     * @var unknown 自动验证
     */
    protected $_validate = array(
        array('privilege_name','require','权限名称不能为空'),
        array('parent_id','number','上级权限必须是数字')
    );
    
    
    /**
     * 获取列表数据
     */
    public function getPrivilegeData(){
        $list = $this->select();
        return $list;
    }
    
    public function addPrivilegeData(){
        $data['privilege_name'] = I('post.privilege_name');
        $data['privilege_url'] = I('post.privilege_url');
        $data['order'] = I('post.order');
        $data['parent_id'] = I('post.parent_id');
        empty($data['order']) ?  $data['order'] = 0 : $data['order'] = I('post.parent_id');
        return $data;
    }
    
   
    
    
    

}