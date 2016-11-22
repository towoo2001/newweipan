<?php
namespace Server\Controller;
use Think\Controller;
class UserServerController extends Controller {
    /**
     * 登录
     * @condition array  查询条件
     * @return boolean
     */
    public function login($condition){
        $user = D('userinfo');
        $condition['ustatus'] = $user::STATUS_ON;
        $result = $user->field("uid,upwd,username,utel,utime,otype,ustatus,vertus")->where($condition)->find();
        return $result;
    }

    /**
     * 记录登录时间
     * @return boolean
     */
    public function lastLogin($id,$arr){
        $user = D('userinfo');
        $result = $user->where("uid = ".$id)->save($arr);
        return $result;
    }

    /**
     * 获取会员列表
     * @get array  查询条件
     * @return array
     */
    public function getMemberList($get=array()){
        $pre = C('DB_PREFIX');  //表前缀
        $user = D('userinfo');
        $order = D('order');
        $condition = "u.ustatus = ".$user::STATUS_ON;
        //根据手机号码查询
        if($get['phone']) {
            $condition .= " and u.utel like '%".$get['phone']."%'";
            $sea['phone'] = $get['phone'];
        }
        //根据名称查询
        if($get['username']) {
            $condition .= " and u.username like '%".$get['username']."%'";
            $sea['username'] = $get['username'];
        }
        //根据时间查询
        if($get['starttime']){
            $time = strtotime($get['starttime']);
            $condition .= " and u.utime > $time";
            $sea['starttime'] = $get['starttime'];
        }
        if($get['endtime']) {
            $time = strtotime($get['endtime']);
            $condition .= " and u.utime < $time";
            $sea['endtime'] = $get['endtime'];
        }
        if($get['starttime'] && $get['endtime']) {
            $sTime = strtotime($get['starttime']);
            $eTime = strtotime($get['endtime']);
            $condition .= " and u.utime between $sTime and $eTime";
            $sea['starttime'] = $get['starttime'];
            $sea['endtime'] = $get['endtime'];
        }
        if($get['status']){
            $status = $get['status']-1;
            $condition .= " and u.ustatus = {$status}";
        }
        if($get['type']){
            $type = $get['type']-1;
            $condition .= " and u.otype = {$type}";
        }
        if($get['oid']){                                    // 查找所属下级
            $condition .= " and u.oid = ".$get['oid'];
            $orderby = "u.otype desc,u.uid desc";
            $sea['oid'] = $get['oid'];
        } elseif($get['uid']){                              //查找上级
            $condition .= " and u.uid = ".$get['uid'];
        } else{                                             //查找会员单位
            $condition .= " and u.otype = ".$user::TYPE_MEMBER;
            $orderby = "u.uid desc";
        }

        //查询用户和账户信息
        $field = 'u.uid,u.username,u.nickname,u.utel,u.address,u.utime,u.oid,u.managername,u.lastlog,a.balance,u.otype';
        $ulist = $user->table($pre.'userinfo u')->join($pre.'accountinfo a on u.uid = a.uid','left')->where($condition)->field($field)->order($orderby)->select();

        //循环用户id，操作用户信息
        foreach($ulist as $k => $v){
            $ulist[$k]['oid'] = empty($v['oid']) ? 0 : $v['oid'] ;
            $ocount = $order->where('uid='.$v['uid'])->count();
            $ulist[$k]['ocount'] = $ocount;                                                                     //获得订单数
            $ulist[$k]['balance'] = number_format($ulist[$k]['balance'],2);                                     //获得余额
            $ulist[$k]['nickname'] = isset($ulist[$k]['nickname']) ? $ulist[$k]['nickname'] :'(非微信用户)';
            $ulist[$k]['managername'] = M('userinfo')->where('uid='.$v['oid'])->getField('username');
            $ulist[$k]['lower'] = M('userinfo')->where('oid='.$v['uid'])->count();                              //获得下级数量
            switch($v['otype']){
                case 0: $otype =  '客户';break;
                case 1: $otype =  '经纪人';break;
                case 2: $otype =  '会员单位';break;
                case 3: $otype =  '管理员';break;
                case 4: $otype =  '代理商';break;
            }
            $ulist[$k]['otype'] = $otype;
        }
        $ulist = [$ulist,$sea];
        return $ulist;
    }

    /**
     * 获取单个用户信息
     * @get array  查询条件
     * @return array
     */
    public function getOneList($id){
        $user = D('userinfo');
        $data = $user->find($id);
        return $data;
    }

    /**
     * 添加用户
     * @$data array 数据
     * @return boolean
     */
    public function addUser($data){
        $user = D('userinfo');
        $result = $user->create($data);
        if(!$result){
            $this->error($user->getError());
        } else {
            $data['upwd'] = md5($data['upwd']);
            $data['utime'] = time();
            $data['otype'] = $user::TYPE_MEMBER;
            $data['oid']   = R('Server/UserServer/getExchangeID');
            $data['wxtype']= 1;
            $result = $user->add($data);
            return $result;
        }
    }

    /**
     * 修改用户
     * @$data array 数据
     * @return boolean
     */
    public function updateUser($data){
        $user = D('userinfo');
        $result = $user->create($data);
        if(!$result){
            $this->error($user->getError());
        } else {
            $data['upwd'] = md5($data['upwd']);
            $data['utime'] = time();
            $data['otype'] = $user::TYPE_MEMBER;
            $data['oid']   = R('Server/UserServer/getExchangeID');
            $data['wxtype']= 1;
            $result = $user->save($data);
            return $result;
        }
    }

    /**
     * 删除用户
     * @$data array 数据
     * @return boolean
     */
    public function deleteUser($id,$arr){
        $user = D('userinfo');
        $result = $user->where('uid = '.$id)->save($arr);
        return $result;
    }

    /**
     * 获取交易所信息
     * @return string
     */
    public function getExchangeID(){
        $user = D('userinfo');
        $type = $user::TYPE_EXCHANGE;
        $data = $user->field('uid')->where('otype = '.$type)->find();
        return $data['uid'];
    }
}