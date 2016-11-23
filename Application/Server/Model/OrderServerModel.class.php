<?php
namespace Server\Model;
use Think\Model;
/**
* 
*/
class OrderServerModel extends Model
{
	protected $trueTableName = 'wp_order'; 
	/**
	 * 持仓搜索列表
	 * @return [type] [description]
	 */
	public function seach_list()
	{
		
		$tq = C('DB_PREFIX');
		$liestr =$tq.'order.buydpzs as buydpzs,'.$tq.'order.paymethod as paymethod,'.$tq.'order.ptitle as ptitle,'.$tq.'order.uid as uid,'.$tq.'order.selltime as selltime,'.$tq.'userinfo.username as username,'.$tq.'order.buytime as buytime,'.$tq.'order.ptitle as ptitle,'.$tq.'order.commission as commission,'.$tq.'order.oid as oid,'.$tq.'order.ploss as ploss,'.$tq.'order.onumber as onumber,'.$tq.'order.ostyle as ostyle,'.$tq.'order.ostaus as ostaus,'.$tq.'order.fee as fee,'.$tq.'order.pid as pid,'.$tq.'order.buyprice as buyprice,'.$tq.'order.sellprice as sellprice,'.$tq.'order.orderno as orderno,'.$tq.'accountinfo.balance as balance,'.$tq.'productinfo.cid as cid,'.$tq.'productinfo.wave as wave';
		if(!empty(I('post.username'))){
			$where['username'] = array('like','%'.I('post.username').'%');
			$sea['username'] = I('post.username');
		}
		if(!empty(I('post.orderno'))){
			$where['orderno']   = array('like','%'.I('post.orderno').'%');
			$sea['orderno'] = I('post.orderno');
		}
		if(I('post.paymethod')=='0'||I('post.paymethod')=='1'){
			$where['paymethod']   = array('eq',I('post.paymethod'));
			$sea['paymethod'] = I('post.paymethod');
		}
		if(I('post.ostyle')=='0'||I('post.ostyle')=='1'){
			$where['ostyle']   = array('eq',I('post.ostyle'));
			$sea['ostyle'] = I('post.ostyle');
		}
		if(!empty(I('post.uid'))){
			$where['wp_order.uid']   = array('eq',I('post.uid'));
			$sea['uid'] = I('post.uid');
		}
		if(!empty(I('post.ptitle'))){
			$where['wp_order.ptitle']   = array('like','%'.I('post.ptitle').'%');
			$sea['ptitle'] = I('post.ptitle');
		}
		$where['ostaus'] ='0';

		
		$count = $this->where($where)->count();
		
		$page = getpage($count,10);

		$list = $this->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')
			->join($tq.'accountinfo on '.$tq.'accountinfo.uid='.$tq.'userinfo.uid','left')
			->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid','left')
			->field($liestr)->order($tq.'order.oid desc')->where($where)->limit($page->firstRow,$page->listRows)->select();
		
		foreach($list as $k => $v){
				$list[$k]['buytime'] = date("Y-m-d H:m",$list[$k]['buytime']);
				$list[$k]['selltime'] = date("Y-m-d H:m:s",$list[$k]['selltime']);
			}


		$list['sea'] =$sea; 
		$list['page'] = $page->show();

		return	$list;
	}
	/**
	 * 持仓订单列表
	 * @return [type] [description]
	 */
	public function get_list(){
		$tq = C('DB_PREFIX');
		$liestr =$tq.'order.buydpzs as buydpzs,'.$tq.'order.paymethod as paymethod,'.$tq.'order.ostaus as ostaus,'.$tq.'order.uid as uid,'.$tq.'order.selltime as selltime,'.$tq.'userinfo.username as username,'.$tq.'order.buytime as buytime,'.$tq.'order.ptitle as ptitle,'.$tq.'order.commission as commission,'.$tq.'order.oid as oid,'.$tq.'order.ploss as ploss,'.$tq.'order.onumber as onumber,'.$tq.'order.ostyle as ostyle,'.$tq.'order.fee as fee,'.$tq.'order.pid as pid,'.$tq.'order.buyprice as buyprice,'.$tq.'order.sellprice as sellprice,'.$tq.'order.orderno as orderno,'.$tq.'accountinfo.balance as balance,'.$tq.'productinfo.cid as cid,'.$tq.'productinfo.wave as wave';
		$count = $this->where("ostaus=0")->count();
		$page = getpage($count,10);
		$list =$this->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'accountinfo.uid='.$tq.'userinfo.uid','left')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid','left')->field($liestr)->where($tq.'order.ostaus=0')->order($tq.'order.oid desc')->limit($page->firstRow,$page->listRows)->select();
		foreach($list as $k => $v){
				$list[$k]['buytime'] = date("Y-m-d H:m:s",$list[$k]['buytime']);
				$list[$k]['selltime'] = date("Y-m-d H:m:s",$list[$k]['selltime']);

			}
		$list['page'] = $page->show();


		return $list; 
	}
	/**
	 * 持仓订单详情
	 * @param  [int] $id [用户id]
	 * @return [array]   [详情]
	 */
	public function get_details($id)
	{
		$list = $this->where('oid='.$id)->find();//订单基本信息
		return $list;

	}
	/**
	 * 成交订单列表
	 */
	public function get_olist()
	{
		$tq = C('DB_PREFIX');
		$liestr =$tq.'order.selldpzs as selldpzs,'.$tq.'order.buydpzs as buydpzs,'.$tq.'order.paymethod as paymethod,'.$tq.'order.ostaus as ostaus,'.$tq.'order.uid as uid,'.$tq.'order.selltime as selltime,'.$tq.'userinfo.username as username,'.$tq.'order.buytime as buytime,'.$tq.'order.ptitle as ptitle,'.$tq.'order.commission as commission,'.$tq.'order.oid as oid,'.$tq.'order.ploss as ploss,'.$tq.'order.onumber as onumber,'.$tq.'order.ostyle as ostyle,'.$tq.'order.fee as fee,'.$tq.'order.pid as pid,'.$tq.'order.buyprice as buyprice,'.$tq.'order.sellprice as sellprice,'.$tq.'order.orderno as orderno,'.$tq.'accountinfo.balance as balance,'.$tq.'productinfo.cid as cid,'.$tq.'productinfo.wave as wave';

		$count = $this->where("ostaus=1")->count();

		$page = getpage($count,10);

		$list =$this->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'accountinfo.uid='.$tq.'userinfo.uid','left')->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid','left')->field($liestr)->where($tq.'order.ostaus=1')->order($tq.'order.oid desc')->limit($page->firstRow,$page->listRows)->select();
		foreach($list as $k => $v){
				$list[$k]['buytime'] = date("Y-m-d H:m:s",$list[$k]['buytime']);
				$list[$k]['selltime'] = date("Y-m-d H:m:s",$list[$k]['selltime']);

			}
		$list['page'] = $page->show();
		return $list;	
	}

		/**
	 * 成单订单详情
	 * @param  [int] $id [用户id]
	 * @return [array]   [详情]
	 */
	public function get_odetails($id)
	{
		$tq = C('DB_PREFIX');
		$list = $this->where('oid='.$id)->find();//订单基本信息
		$uid = $list['uid'];
		$model = M('userinfo');
		$info = $model->where('uid='.$uid)->find();//user表信息
		foreach($info as $k=>$v){
			$list[$k] = $v;
				
		}
		return $list;

	}
	/**
	 * 成交搜索列表
	 * @return [type] [description]
	 */
	public function seach_olist()
	{
		
		$tq = C('DB_PREFIX');
		$liestr =$tq.'order.paymethod as paymethod,'.$tq.'order.ptitle as ptitle,'.$tq.'order.uid as uid,'.$tq.'order.selltime as selltime,'.$tq.'userinfo.username as username,'.$tq.'order.buytime as buytime,'.$tq.'order.ptitle as ptitle,'.$tq.'order.commission as commission,'.$tq.'order.oid as oid,'.$tq.'order.ploss as ploss,'.$tq.'order.onumber as onumber,'.$tq.'order.ostyle as ostyle,'.$tq.'order.ostaus as ostaus,'.$tq.'order.fee as fee,'.$tq.'order.pid as pid,'.$tq.'order.buyprice as buyprice,'.$tq.'order.sellprice as sellprice,'.$tq.'order.orderno as orderno,'.$tq.'accountinfo.balance as balance,'.$tq.'productinfo.cid as cid,'.$tq.'productinfo.wave as wave';
		if(!empty(I('post.username'))){
			$where['username'] = array('like','%'.I('post.username').'%');
			$sea['username'] = I('post.username');
		}
		if(!empty(I('post.orderno'))){
			$where['orderno']   = array('like','%'.I('post.orderno').'%');
			$sea['orderno'] = I('post.orderno');
		}
		if(I('post.paymethod')=='0'||I('post.paymethod')=='1'){
			$where['paymethod']   = array('eq',I('post.paymethod'));
			$sea['paymethod'] = I('post.paymethod');
		}
		if(I('post.ostyle')=='0'||I('post.ostyle')=='1'){
			$where['ostyle']   = array('eq',I('post.ostyle'));
			$sea['ostyle'] = I('post.ostyle');
		}
		if(!empty(I('post.uid'))){
			$where['wp_order.uid']   = array('eq',I('post.uid'));
			$sea['uid'] = I('post.uid');
		}
		if(!empty(I('post.ptitle'))){
			$where['wp_order.ptitle']   = array('like','%'.I('post.ptitle').'%');
			$sea['ptitle'] = I('post.ptitle');
		}
		if(!empty(I('post.strtime')) && !empty('post.strtime')){
			$strtime = strtotime(I('post.strtime')." 00:00:00");
			$endtime = strtotime(I('post.endtime')." 23:59:59");
			$where['buytime']   = array('between',array($strtime,$endtime));

			$sea['strtime'] = I('post.strtime');
			$sea['endtime'] = I('post.endtime');
		}

		
		$where['ostaus'] ='1';
		$count = $this->where($where)->count();
		$page = getpage($count,10);

		$list = $this->join($tq.'userinfo on '.$tq.'order.uid='.$tq.'userinfo.uid','left')
			->join($tq.'accountinfo on '.$tq.'accountinfo.uid='.$tq.'userinfo.uid','left')
			->join($tq.'productinfo on '.$tq.'order.pid='.$tq.'productinfo.pid','left')
			->field($liestr)->order($tq.'order.oid desc')->where($where)->limit($page->firstRow,$page->firstRows)->select();
		foreach($list as $k => $v){
				$list[$k]['buytime'] = date("Y-m-d H:m",$list[$k]['buytime']);
				$list[$k]['selltime'] = date("Y-m-d H:m:s",$list[$k]['selltime']);
			}
			/*foreach($sea as $k=>$v){
				$list[$k]=$v;
			}*/
		$list['sea']  = $sea;
		$list['page'] = $page->show();
		//pre($list);
		return	$list;
	}
}
?>