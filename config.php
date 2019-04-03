<?php
if (!defined('IN_MADM')) exit();

/**
 * @brief: 配置可以登录的账户信息
 */
$config['account'] = array(
	'hsun' => 'richardsun',
	'admin' => 'admin'
);


$config['memcache'] = array(
	'cons' => array(
		array(
			'name' => "0001",
			'host' => '127.0.0.1',
			'port' => '11211',
			'ispcon' => '0',
			'timeout' => '1'
		)
	)
);
$config['memcache']['num'] = count($config['memcache']['cons']);

$config['memcache_pool'] = array(
	'num' => 0
);

// set the font and font-size in different languages
function set_font($t) {
	if ($t == 'body') {
		if ($_SESSION["MADM_SESSION_KEY"]['lang'] == 'zh-cn') {
			echo "font:'Courier New',Arial,sans-serif;font-size:13px;";
		} else {
			echo "font:'Courier New',Arial,sans-serif;font-size:13px;";
		} 
	} 
	if ($t == 'title') {
		if ($_SESSION["MADM_SESSION_KEY"]['lang'] == 'zh-cn') {
			echo "font:'Courier New',Arial,sans-serif;font-size:20px;font-weight:bold;";
		} else {
			echo "font:'Courier New',Arial,sans-serif;font-size:20px;font-weight:bold";
		} 
	} 
	if ($t == 'h1') {
		if ($_SESSION["MADM_SESSION_KEY"]['lang'] == 'zh-cn') {
			echo "font:'Courier New',Arial,sans-serif;font-size:14px;";
		} else {
			echo "font:'Courier New',Arial,sans-serif;font-size:14px;";
		} 
	} 
	if ($t == 'menu') {
		if ($_SESSION["MADM_SESSION_KEY"]['lang'] == 'zh-cn') {
			echo "font:'Courier New',Arial,sans-serif;font-size:14px;";
		} else {
			echo "font:'Courier New',Arial,sans-serif;font-size:14px;";
		} 
	} 
}
?>
