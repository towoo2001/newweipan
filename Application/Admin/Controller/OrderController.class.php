<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 
*/
class OrderController extends Controller
{
	/**
	 * 持仓订单列表
	 */
	public function Orderlist()
	{
		$list = D('order')->get_list();
		$this->assign('list',$list);
		$this->display();
	}
	/**
	 * 持仓订单详情
	 * @return [type] [description]
	 */
	public function details(){
		$id = I('get.uid');
		$list = D('order')->get_details($id);

		$this->assign('list',$list);
		$this->display('orderdetails');
	}
	/**
	 * 成交订单列表
	 */
	public function Orderolist()
	{
		$list = D('order')->get_olist();
		$this->assign('list',$list);
		$this->display();
	}
	/**
	 * 成交订单详情
	 */
	public function odetails()
	{
		$id = I('get.uid');
		$list = D('order')->get_odetails($id);
		$this->assign('list',$list);
		$this->display('Orderodetails');
	}
}
?>