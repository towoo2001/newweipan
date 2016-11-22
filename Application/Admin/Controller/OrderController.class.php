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
        //$id = I('get.uid');
        $list = R('Server/Order/details');
    
        $this->assign('list',$list);
        $this->display('orderdetails');
    }
    /**
     * 成交订单列表
     */
    public function Orderolist()
    {
        $list = R('Server/Order/Orderolist');
        $this->assign('list',$list);
        $this->display();
    }
    /**
     * 成交订单详情
     */
    public function odetails()
    {
        $list = R('Server/Order/odetails');
        $this->assign('list',$list);
        $this->display('Orderodetails');
    }
}
?>