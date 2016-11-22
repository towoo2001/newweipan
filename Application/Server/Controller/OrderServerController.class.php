<?php
namespace Server\Controller;
use Think\Controller;
use Server\Model\OrderServerModel;
/**
* 
*/
class OrderServerController extends Controller
{
	/**
	 * 持仓订单列表
	 */
	public function Orderlist()
    {
       $model = new OrderServerModel();
       $list = $model->get_list();
       return $list;

    }
    /**
	 * 成交订单列表
	 */
	public function Orderolist()
    {
       $model = new OrderServerModel();
       $list = $model->get_olist();
       return $list;

    }

    /**
	 * 持仓订单详情
	 */
	public function Orderdetails()
    {
       $id = I('get.oid');
       $model = new OrderServerModel();
       $list = $model->get_details($id);
       return $list;

    }
     /**
	 * 成交订单详情
	 */
	public function Orderodetails()
    {
       $id = I('get.oid');
       $model = new OrderServerModel();
       $list = $model->get_odetails($id);
       return $list;

    }
 	/**
	 * 持仓搜索列表
	 */
	public function seach()
    {
       
       $model = new OrderServerModel();
       $list = $model->seach_list();
       return $list;

    }

    

}
?>