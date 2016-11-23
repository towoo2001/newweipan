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
        $condition['vertus'] = $user::VERTUS_ON;
        $condition['otype'] = array('neq',$user::TYPE_CUSTOMER);
        $result = $user->field("uid,upwd,username,utel,utime,otype,ustatus,vertus,comname")->where($condition)->find();
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
    public function getMemberList($get = array()){
        $info = $_SESSION['login'];
        $pre = C('DB_PREFIX');  //表前缀
        $user = D('userinfo');
        $order = D('order');

        $condition = "1";
        //根据手机号码查询
        if($get['phone']) {
            $condition .= " and utel like '%".$get['phone']."%'";
            $sea['phone'] = $get['phone'];
        }
        //根据名称查询
        if($get['username']) {
            $condition .= " and username like '%".$get['username']."%'";
            $sea['username'] = $get['username'];
        }
        //根据时间查询
        if($get['starttime']){
            $time = strtotime($get['starttime']);
            $condition .= " and utime > $time";
            $sea['starttime'] = $get['starttime'];
        }
        if($get['endtime']) {
            $time = strtotime($get['endtime']);
            $condition .= " and utime < $time";
            $sea['endtime'] = $get['endtime'];
        }
        if($get['starttime'] && $get['endtime']) {
            $sTime = strtotime($get['starttime']);
            $eTime = strtotime($get['endtime']);
            $condition .= " and utime between $sTime and $eTime";
            $sea['starttime'] = $get['starttime'];
            $sea['endtime'] = $get['endtime'];
        }
        if($get['status']){
            $status = $get['status']-1;
            $condition .= " and ustatus = {$status}";
        }
        if($get['oid']){                                    // 查找所属下级
            $condition .= " and oid = ".$get['oid'];
            $orderby = "otype desc,uid desc";
            $sea['oid'] = $get['oid'];
        } /*elseif($get['uid']){                              //查找上级
            $condition .= " and uid = ".$get['uid'];
        } */else {
            $condition .= " and oid = ".$info['uid'];
            $orderby = "otype desc";
        }

        $count = $user->where($condition)->count();
        $page = getpage($count,20);
        //查询用户和账户信息
        $field = 'uid,username,utel,utime,oid,managername,otype,ustatus,comname,code';
        $ulist = $user->table($pre.'userinfo')->where($condition)->field($field)->order($orderby)->limit($page->firstRow,$page->listRows)->select();

        //循环用户id，操作用户信息
        foreach($ulist as $k => $v){
            $ulist[$k]['oid'] = empty($v['oid']) ? 0 : $v['oid'] ;
            $ulist[$k]['utel'] = str_replace(substr($v['utel'],3,4),'****',$v['utel']);
            $ocount = $order->where('uid='.$v['uid'])->count();
            $ulist[$k]['ocount'] = $ocount;                                                                     //获得订单数
            $ulist[$k]['balance'] = number_format($ulist[$k]['balance'],2);                                     //获得余额
            //$ulist[$k]['nickname'] = isset($ulist[$k]['nickname']) ? $ulist[$k]['nickname'] :'(非微信用户)';
            $ulist[$k]['managername'] = M('userinfo')->where('uid='.$v['oid'])->getField('username');
            $ulist[$k]['lower'] = M('userinfo')->where('oid='.$v['uid'])->count();                              //获得下级数量
            $ulist[$k]['ustatus'] = $v['ustatus'] == 0 ? '正常': '冻结' ;
            switch($v['otype']){
                case 0: $otype =  '客户';break;
                case 1: $otype =  '经纪人';break;
                case 2: $otype =  '运营中心';break;
                case 3: $otype =  '管理员';break;
                case 4: $otype =  '代理商';break;
                case 5: $otype =  '交易所';break;
                case 6: $otype =  '综合会员';break;
                case 7: $otype =  '经济会员';break;
            }
            $ulist[$k]['otype'] = $otype;
        }

        $ulist = array('ulist' => $ulist,'sea' => $sea,'page' => $page->show());
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
            
            //生成随机邀请码
            $str = array_merge(range(0,9),range('a','z'),range('A','Z'));
            shuffle($str);
            $str = strtoupper(implode('',array_slice($str,0,8)));
            $data['code'] = $str.$data['uid'];

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
     * 用户详情
     * @$data array 数据
     * @return boolean
     */
    public function detailUser($id){
        $user = D('userinfo');
        $order = D('order');
        $account = D('accountinfo');
        $bank = D('bankinfo');
        //查询用户和账户信息
        $field = 'uid,username,nickname,utel,address,utime,oid,managername,lastlog,otype,ustatus,comname,rname,center';
        $ulist = $user->field($field)->find($id);
        switch($ulist['otype']){
            case 0: $otype =  '客户';break;
            case 1: $otype =  '经纪人';break;
            case 2: $otype =  '运营中心';break;
            case 3: $otype =  '管理员';break;
            case 4: $otype =  '代理商';break;
            case 5: $otype =  '交易所';break;
            case 6: $otype =  '综合会员';break;
            case 7: $otype =  '经济会员';break;
        }
        $ulist['otype'] = $otype;

        //查询余额
        $account = $account->field('balance')->where('uid ='.$id)->find();
        //查询银行
        $bank = $bank->where('uid ='.$id)->find();
        //查询订单
        $order = $order->where('uid ='.$id)->find();
        //查询下级数
        $count = $user->where('oid='.$id)->count();

        //组合返回列表
        $ulist['balance'] = $account['balance'];
        $ulist['bank'] = $bank;
        $ulist['order'] = $order;
        $ulist['lower'] = $count;

        return $ulist;
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