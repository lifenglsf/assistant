<?php
ini_set("display_errors", "On");
date_default_timezone_set('Asia/Shanghai');
//报告运行时错误
error_reporting(E_ALL);
//error_reporting(1);
define('ROOT', dirname($_SERVER['DOCUMENT_ROOT']));
define('LIB_PATH', ROOT . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR);
if (!defined("ROOT_PATH")) {
	define('ROOT_PATH', ROOT . DIRECTORY_SEPARATOR);
}
set_include_path(get_include_path() . PATH_SEPARATOR . LIB_PATH . PATH_SEPARATOR . ROOT_PATH);
//自动加载类
function wshp_autoLoad($classname) {
	$classname = str_replace("\\", "/", $classname);
	if (file_exists(LIB_PATH . $classname . ".class.php") || file_exists(ROOT_PATH . $classname . ".class.php")) {
		include_once $classname . ".class.php";
	}
}
spl_autoload_register('wshp_autoLoad');

define('MYSQL_HOST', 'db1.winsan.cn');
define('REDIS_HOST', 'cache.winsan.cn');
define('MONGO_HOST', 'mongo.winsan.cn');
define('PAGESIZE', 10);

//缓存服务器配置
$cacheconfig = array(
	'type' => 'redis',
	'host' => REDIS_HOST,
	'port' => 6379,
	'timeout' => false,
	'persistent' => true,
	'expire' => 14400,
	'prefix' => 'winsan_hp_',
);
//数据库连接配置
$pdoconfig = array(
	'type' => 'mysql', // 数据库类型
	'hostname' => MYSQL_HOST, // 服务器地址
	'database' => 'db_wshp_op', // 数据库名
	'username' => 'opdb_user', // 用户名
	'password' => 'O16gRvbl+1thyZ', // 密码
	'hostport' => '3306', // 端口
	'dsn' => '', //
	'params' => array(PDO::ATTR_PERSISTENT => false), // 数据库连接参数
	'charset' => 'utf8', // 数据库编码默认采用utf8
	'prefix' => '', // 数据库表前缀
);

$memberconfig = array(
	'type' => 'mysql', // 数据库类型
	'hostname' => MYSQL_HOST, // 服务器地址
	'database' => 'db_wshp_member', // 数据库名
	'username' => 'wshp_member', // 用户名
	'password' => '98kgKskSl+1t2ky4', // 'O16gRvbl+1thyZ',          // 密码
	'hostport' => '3306', // 端口
	'dsn' => '', //
	'params' => array(PDO::ATTR_PERSISTENT => false), // 数据库连接参数
	'charset' => 'utf8', // 数据库编码默认采用utf8
	'prefix' => '', // 数据库表前缀
);

//模板配置信息
$tplconfig = array(
	'tpl_dir' => ROOT_PATH . 'tpl' . DIRECTORY_SEPARATOR,
	'tpl_compile_dir' => ROOT_PATH . 'compile' . DIRECTORY_SEPARATOR,
	'tpl_cache_dir' => ROOT_PATH . 'cache' . DIRECTORY_SEPARATOR,
);

// cookie默认设置
$cookieconfig = array(
	// cookie 名称前缀
	'prefix' => '',
	'path' => '', // cookie 保存路径
	'domain' => '360ys.cn', //cookie 有效域名
	'isencrypt' => false, //是否加密
);

/**
 * 转义 $_POST $_GET $COOKIE 值
 * @param mixed $value
 * @return mixed
 */
function filterValue($value) {
	$value = is_array($value) ? array_map('filterValue', $value) : addslashes($value);
	return $value;
}

$_POST = array_map('filterValue', $_POST);
$_GET = array_map('filterValue', $_GET);
$_COOKIE = array_map('filterValue', $_COOKIE);

/**
 * 验证登录，验证访问权限
 * @return null
 */
function validLogin() {
	global $cache;

	$flag = true;

	if (!$flag) {
		header("content-type:text/html;charset=UTF-8");
		die('您没有权限访问此页面，请联系管理员');
	}

}

lib\Main::init();

validLogin();
