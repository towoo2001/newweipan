<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 
*/
class OrderController extends BaseController
{
    /**
     * 持仓订单列表
     */
    public function Orderlist()
    {
        
        if(IS_POST){

            $list = R('Server/OrderServer/seach');
            
        }else {
            $list = R('Server/OrderServer/Orderlist');
        }
        $this->assign('list',$list);
        $this->display();

    }
    /**
     * 持仓订单详情
     * @return [type] [description]
     */
    public function details(){
        $id = I('get.oid');
        $list = R('Server/OrderServer/Orderdetails',array($id));
    
        $this->assign('list',$list);
        $this->display('orderdetails');
    }
    /**
     * 成交订单列表
     */
    public function Orderolist()
    {
        if(IS_POST){
            
            $list = R('Server/OrderServer/oseach');
        
        }else {
            $list = R('Server/OrderServer/Orderolist');
        }
        
        $this->assign('list',$list);
        $this->display();
    }
    /**
     * 成交订单详情
     */
    public function odetails(){
        $id = I('get.oid');
        $list = R('Server/OrderServer/Orderodetails',array($id));

        $this->assign('list',$list);
        $this->display('Orderodetails');
    }
}
?>