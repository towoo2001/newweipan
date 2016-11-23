<?php
namespace Admin\Model;
use Think\Model;
class UserinfoModel extends Model {
    //ustatus
    const STATUS_ON = 0;    //激活
    const STATUS_OFF = 1;   //冻结
    //vertus
    const VERTUS_ON = 1;    //通过
    const VERTUS_OFF = 0;   //未通过
    //otype
    const TYPE_ADMIN     = 1;   //超级管理员、交易所
    const TYPE_CENTER    = 2;   //运营中心
    const TYPE_COLLIGATE = 3;   //综合会员单位
    const TYPE_MEMBER    = 4;   //经济会员
    const TYPE_AGENCY    = 5;   //代理商
    const TYPE_AGENT     = 6;   //经纪人
    const TYPE_CUSTOMER  = 7;   //客户

	/**
     * 自动验证
     */
	protected $_validate = array(
        array('username', 'require', '用户名不能为空！'), //默认情况下用正则进行验证
        array('username', '', '该用户名已被注册！', 0, 'unique', 1), // 在新增的时候验证name字段是否唯一
        array('utel', '', '该手机号码已被占用', 0, 'unique', 1), // 新增的时候mobile字段是否唯一
        //array('utel', '/^1[34578]\d{9}$/', '手机号码格式不正确', 0), // 正则表达式验证手机号码
        // 正则验证密码 [需包含字母数字以及@*#中的一种,长度为6-22位]
        array('upwd', '/^([a-zA-Z0-9@*#]{6,22})$/', '密码格式不正确,请重新输入！', 1),
        array('reupwd', 'upwd', '确认密码不正确', 0, 'confirm'), // 验证确认密码是否和密码一致
	);
	
    /**
     * 自动完成
     */
     protected $_auto = array (
        array('upwd', 'md5', 3, 'function') , // 对password字段在新增和编辑的时候使md5函数处理
        array('regdate', 'time', 1, 'function'), // 对regdate字段在新增的时候写入当前时间戳
        array('regip', 'get_client_ip', 1, 'function'), // 对regip字段在新增的时候写入当前注册ip地址
    );
}