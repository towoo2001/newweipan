<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 
*/
class OrderController extends Controller
{
	
	public function Orderlist()
	{
		$list = D('order')->get_list();
		$this->assign('list',$list);
		$this->display();
	}
}
?>