<?php
namespace Server\Controller;
use Think\Controller;
class PrivServerController extends Controller {
    public function getPrivRow($id) {
        $id = intval($id);
        
        $result = M('Privilege')->field('id')->where("parent_id = $id")->select();
        var_dump($result);exit;
        if(!empty($result)){
            $this->error('该栏目下还有子栏目，请先删除子栏目');
        }
        if(M('Privilege')->where("id = $id")->delete()!==false){
           return true;
        }else{
           return false;
        }
    }
}