<?php
namespace Server\Controller;
use Think\Controller;
class UserServerController extends Controller {
    /**
     * 登录
     * @condition array  查询条件
     * @return boolean
     */
    public function login($where){
        $user = D('userinfo');
        $role = D('role');
        $status = $user::STATUS_ON;
        $vertus = $user::VERTUS_ON;
        $otype = $user::TYPE_CUSTOMER;
        $condition = $where . " and ustatus = $status and vertus = $vertus and otype != $otype";
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
        $role = D('role');
        $order = D('order');

        $condition = "1";
        //根据手机号码查询
        if($get['phone']) {
            $condition .= " and utel like '%".$get['phone']."%'";
            $sea['phone'] = $get['phone'];
        }
        //根据名称查询
        if($get['unum']) {
            $condition .= " and unum like '%".$get['unum']."%'";
            $sea['unum'] = $get['unum'];
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
        if($get['otype']){
            $condition .= " and otype =".$get['otype'];
            $sea['otype'] = $get['otype'];
        }
        if($get['status']){
            $status = $get['status']-1;
            $condition .= " and ustatus = {$status}";
        }
        if($get['oid']){                                    // 查找所属下级
            $condition .= " and oid = ".$get['oid'];
            $orderby = "otype asc,uid desc";
            $sea['oid'] = $get['oid'];
        } else {
            $condition .= " and oid = ".$info['uid'];
            $orderby = "otype asc,uid desc";
        }

        $count = $user->where($condition)->count();
        $page = getpage($count,10);
        //查询用户和账户信息
        $field = 'uid,username,utel,utime,oid,managername,otype,ustatus,comname,code,unum';
        $ulist = $user->table($pre.'userinfo')->where($condition)->field($field)->order($orderby)->limit($page->firstRow,$page->listRows)->select();

        //循环用户id，操作用户信息
        foreach($ulist as $k => $v){
            $ulist[$k]['oid'] = empty($v['oid']) ? 0 : $v['oid'] ;
            $ulist[$k]['utel'] = str_replace(substr($v['utel'],3,4),'****',$v['utel']);
            //$ocount = $order->where('uid='.$v['uid'])->count();
            //$ulist[$k]['ocount'] = $ocount;                                                                    //获得订单数
            //$ulist[$k]['balance'] = number_format($ulist[$k]['balance'],2);                                     //获得余额
            //$ulist[$k]['nickname'] = isset($ulist[$k]['nickname']) ? $ulist[$k]['nickname'] :'(非微信用户)';
            //获得上级
            if($v['otype'] == $user::TYPE_CUSTOMER){
                $top = M('userinfo')->where('uid='.$v['oid'])->getField('utel');
            } else {
                $top = M('userinfo')->where('uid='.$v['oid'])->getField('comname');
            }
            $ulist[$k]['managername'] = $top;
            //获得下级数量
            $ulist[$k]['lower'] = M('userinfo')->where('oid='.$v['uid'])->count();
            //用户状态
            $ulist[$k]['ustatus'] = $v['ustatus'] == 0 ? '正常': '冻结' ;
            //获得用户等级
            $otype = $role->field('role_name')->where('id ='.$v['otype'])->find();
            $ulist[$k]['otype'] = $otype['role_name'];
        }
        //用户等级列表
        $type = $this->userType();
        $ulist = array('ulist' => $ulist,'sea' => $sea,'page' => $page->show(),'type' => $type);
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

    //用户等级列表
    public function userType(){
        $role = D('role');
        $data = $role->field('id,role_name')->where('role_type ='.$role::USER)->select();
        return $data;
    }

    //下级列表
    public function dropDownList(){
        $info = $_SESSION['login'];
        $user = D('userinfo');
        if($info['otype'] == $user::TYPE_ADMIN){
            $otype = array($user::TYPE_CENTER => '运营中心' );
        } elseif($info['otype'] == $user::TYPE_CENTER){
            $otype = array($user::TYPE_COLLIGATE => '综合会员');
        } elseif($info['otype'] == $user::TYPE_COLLIGATE){
            $otype = array($user::TYPE_MEMBER => '经济会员',$user::TYPE_AGENCY => '代理商',$user::TYPE_AGENT => '经纪人',$user::TYPE_CUSTOMER => '客户');
        } elseif($info['otype'] == $user::TYPE_MEMBER){
            $otype = array($user::TYPE_AGENT => '经纪人',$user::TYPE_CUSTOMER => '客户');
        } elseif($info['otype'] == $user::TYPE_AGENCY){
            $otype = array($user::TYPE_AGENT => '经纪人');
        } elseif($info['otype'] == $user::TYPE_AGENT){
            $otype = array($user::TYPE_CUSTOMER => '客户');
        }
        return $otype;
    }

    /**
     * 添加用户
     * @$data array 数据
     * @return boolean
     */
    public function addUser($data){
        $user = D('userinfo');
        $info = $_SESSION['login'];
        $result = $user->create($data);
        if(!$result){
            $this->error($user->getError());
        } else {
            $data['upwd'] = md5($data['upwd']);
            $data['utime'] = time();

            //添加oid
            if($info['otype'] == $user::TYPE_ADMIN){
                $data['oid']   = R('Server/UserServer/getExchangeID');
            } else {
                $data['oid'] = $info['uid'];
            }

            //生成随机邀请码
            $str = array_merge(range(0,9),range('a','z'),range('A','Z'));
            shuffle($str);
            $str = strtoupper(implode('',array_slice($str,0,8)));
            $data['code'] = $str.$data['uid'];

            //生成用户id编号
            $otype = array($user::TYPE_CENTER,$user::TYPE_COLLIGATE,$user::TYPE_MEMBER,$user::TYPE_AGENCY);
            if($info['otype'] == $user::TYPE_ADMIN){
                $pre = 'tq_';
                $data['unum'] = $pre.substr(uniqid(),6);
            } elseif(in_array($info['otype'],$otype)) {
                $comname1 = mb_substr($info['comname'],0,1,'utf-8');
                $comname2 = mb_substr($info['comname'],1,1,'utf-8');
                $z = strtolower(Getzimu($comname1));
                $m = strtolower(Getzimu($comname2));
                $pre = $z.$m.'_';
                $data['unum'] = $pre.substr(uniqid(),6);
            } else {
                $pre = 'cu_';
                $data['unum'] = $pre.substr(uniqid(),6);
            }
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
        $field = 'uid,username,nickname,utel,address,utime,oid,managername,lastlog,otype,ustatus,comname,rname,unum';
        $ulist = $user->field($field)->find($id);
        switch($ulist['otype']){
            case 1: $otype =  '交易所';break;
            case 2: $otype =  '运营中心';break;
            case 3: $otype =  '综合会员';break;
            case 4: $otype =  '经济会员';break;
            case 5: $otype =  '代理商';break;
            case 6: $otype =  '经纪人';break;
            case 7: $otype =  '客户';break;
        }

        if($ulist['otype'] == $user::TYPE_CUSTOMER){
            $top = M('userinfo')->where('uid='.$ulist['oid'])->getField('username');
        } else {
            $top = M('userinfo')->where('uid='.$ulist['oid'])->getField('comname');
        }
        $ulist['managename'] = $top;
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
    /*public function deleteUser($id,$arr){
        $user = D('userinfo');
        $result = $user->where('uid = '.$id)->save($arr);
        return $result;
    }*/

    /**
     * 切换状态
     * */
    public function statusChange($id){
        $user = D('userinfo');
        $status = $user->field('ustatus')->where('uid ='.$id)->find();
        $status = $status['ustatus'];
        $rs = $status == $user::STATUS_ON ? $user::STATUS_OFF : $user::STATUS_ON ;
        $result = $user->where('uid ='.$id)->save(array('ustatus' => $rs));
        return true;
    }

    /**
     * 获取交易所信息
     * @return string
     */
    public function getExchangeID(){
        $user = D('userinfo');
        $type = $user::TYPE_ADMIN;
        $data = $user->field('uid')->where('otype = '.$type)->find();
        return $data['uid'];
    }
}