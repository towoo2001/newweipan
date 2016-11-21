<?php
return array(
	//'配置项'=>'配置值'
	 /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'weipanbao',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'wp_',    // 数据库表前缀
    'DB_FIELDTYPE_CHECK'    =>  false,       // 是否进行字段类型检查
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           =>  '', // 指定从服务器序号
    'DB_SQL_BUILD_CACHE'    =>  false, // 数据库查询的SQL创建缓存
    'DB_SQL_BUILD_QUEUE'    =>  'file',   // SQL缓存队列的缓存方式 支持 file xcache和apc
    'DB_SQL_BUILD_LENGTH'   =>  20, // SQL缓存的队列长度
    'DB_SQL_LOG'            =>  false, // SQL执行日志记录
    'DB_BIND_PARAM'         =>  false, // 数据库写入数据自动参数绑定
	'WEIXINPAY_CONFIG'      => array(
		'APPID'             => 'wx073b4f54182001f2', // 微信支付APPID
		'MCHID'             => '1384630702', // 微信支付MCHID 商户收款账号
		'KEY'               => 'ZH123456ZH123456ZH123456ZH123456', // 微信支付KEY
		'APPSECRET'         => 'd2a26aca83a818e8f5cfc859bfc13d76',  //公众帐号secert
		'NOTIFY_URL'        => 'http://'.$_SERVER['HTTP_HOST'].'/Home/Weixin/notify/', // 接收支付状态的连接
	),
	'SMS'					=> array(
		'user2'				=> 'ronmei',
		'pwd'				=> 'rmkj@bj'
	),

);
