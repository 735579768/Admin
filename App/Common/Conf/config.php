<?php
return array(
	//'配置项'=>'配置值'
	//'PLUGIN_DIR'=>__ROOT__.'/Plugins',
    'AUTOLOAD_NAMESPACE'=>array(
           'Plugins'=> __ROOT__.'/Plugins',
            ),
	'SHOW_PAGE_TRACE' =>true,
		 // 允许访问的模块列表
    'MODULE_ALLOW_LIST'    => array('Home','Admin'),
    'DEFAULT_MODULE'     => 'Home',
    'MODULE_DENY_LIST'   => array('Common','User','Admin','Install'),
	    /* 数据库配置 */
    'DB_TYPE'   => 'mysqli', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'admin', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '',  // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'kl_', // 数据库表前缀
);