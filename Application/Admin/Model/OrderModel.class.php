<?php
namespace Admin\Model;
use Think\Model;
class OrderModel extends Model{
	/**
	 * 获取post参数
	 */
	public function get_post(){

	}
	public function seach_list()
	{
		
		$tq = C('DB_PREFIX');
		$liestr =$tq.'order.ostaus as ostaus,'.$tq.'order.uid as uid,'.$tq.'order.selltime as selltime,'.$tq.'userinfo.username as username,'.$tq.'order.buytime as buytime,'.$tq.'order.ptitle as ptitle,'.$tq.'order.commission as commission,'.$tq.'order.oid as oid,'.$tq.'order.ploss as ploss,'.$tq.'order.onumber as onumber,'.$tq.'order.ostyle as ostyle,'.$tq.'order.ostaus as ostaus,'.$tq.'order.fee as fee,'.$tq.'order.pid as pid,'.$tq.'order.buyprice as buyprice,'.$tq.'order.sellprice as sellprice,'.$tq.'order.orderno as orderno,'.$tq.'accountinfo.balance as balance,'.$tq.'productinfo.cid as cid,'.$tq.'productinfo.wave as wave';
		if(!empty(I('post.username'))){
			$where['username'] = array('like','%'.I('post.username').'%');
		}
		if(!empty(I('post.orderno'))){
			$where['orderno']   = array('like','%'.I('post.orderno').'%');
		}
		if(!empty(I('post.ostyle'))){
			$where['ostyle']   = array('eq',I('post.ostyle'));
		}
		if(!empty(I('post.uid'))){
			$where['uid']   = array('eq',I('post.uid'));
		}

		$list = $this->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')
			->join($tq.'accountinfo on '.$tq.'accountinfo.uid='.$tq.'userinfo.uid','left')
			->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid','left')
			->field($liestr)->order($tq.'order.oid desc')->where($where)->select();
		foreach($list as $k => $v){
				$list[$k]['buytime'] = date("Y-m-d H:m",$list[$k]['buytime']);
				$list[$k]['selltime'] = date("Y-m-d H:m:s",$list[$k]['selltime']);
			}
		return	$list;
	}
	/**
	 * 持仓订单列表
	 * @return [type] [description]
	 */
	public function get_list(){
		$tq = C('DB_PREFIX');
		$liestr =$tq.'order.ostaus as ostaus,'.$tq.'order.uid as uid,'.$tq.'order.selltime as selltime,'.$tq.'userinfo.username as username,'.$tq.'order.buytime as buytime,'.$tq.'order.ptitle as ptitle,'.$tq.'order.commission as commission,'.$tq.'order.oid as oid,'.$tq.'order.ploss as ploss,'.$tq.'order.onumber as onumber,'.$tq.'order.ostyle as ostyle,'.$tq.'order.ostaus as ostaus,'.$tq.'order.fee as fee,'.$tq.'order.pid as pid,'.$tq.'order.buyprice as buyprice,'.$tq.'order.sellprice as sellprice,'.$tq.'order.orderno as orderno,'.$tq.'accountinfo.balance as balance,'.$tq.'productinfo.cid as cid,'.$tq.'productinfo.wave as wave';
		$list =$this->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'accountinfo.uid='.$tq.'userinfo.uid','left')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid','left')->field($liestr)->where($tq.'order.ostaus=0')->order($tq.'order.oid desc')->select();
		foreach($list as $k => $v){
				$list[$k]['buytime'] = date("Y-m-d H:m:s",$list[$k]['buytime']);
				$list[$k]['selltime'] = date("Y-m-d H:m:s",$list[$k]['selltime']);

			}
		return $list; 
	}
	/**
	 * 持仓订单详情
	 * @param  [int] $id [用户id]
	 * @return [array]   [详情]
	 */
	public function get_details($id)
	{
		$list = $this->where('uid='.$id)->find();//订单基本信息
		return $list;

	}
	/**
	 * 成交订单列表
	 */
	public function get_olist()
	{
		$tq = C('DB_PREFIX');
		$liestr =$tq.'order.ostaus as ostaus,'.$tq.'order.uid as uid,'.$tq.'order.selltime as selltime,'.$tq.'userinfo.username as username,'.$tq.'order.buytime as buytime,'.$tq.'order.ptitle as ptitle,'.$tq.'order.commission as commission,'.$tq.'order.oid as oid,'.$tq.'order.ploss as ploss,'.$tq.'order.onumber as onumber,'.$tq.'order.ostyle as ostyle,'.$tq.'order.ostaus as ostaus,'.$tq.'order.fee as fee,'.$tq.'order.pid as pid,'.$tq.'order.buyprice as buyprice,'.$tq.'order.sellprice as sellprice,'.$tq.'order.orderno as orderno,'.$tq.'accountinfo.balance as balance,'.$tq.'productinfo.cid as cid,'.$tq.'productinfo.wave as wave';
		$list =$this->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'accountinfo.uid='.$tq.'userinfo.uid','left')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid','left')->field($liestr)->where($tq.'order.ostaus=1')->order($tq.'order.oid desc')->select();
		foreach($list as $k => $v){
				$list[$k]['buytime'] = date("Y-m-d H:m:s",$list[$k]['buytime']);
				$list[$k]['selltime'] = date("Y-m-d H:m:s",$list[$k]['selltime']);

			}
		return $list;	
	}

		/**
	 * 持仓订单详情
	 * @param  [int] $id [用户id]
	 * @return [array]   [详情]
	 */
	public function get_odetails($id)
	{
		$list = $this->where('uid='.$id)->find();//订单基本信息
		return $list;

	}
}
?>