<?php
/**
 * MEMMANAGER class
 */
if (!defined('IN_MADM')) exit();
define('ROOT', str_replace("\\", '/', dirname(__FILE__)));
require_once("../include/func/memadmin.func.php");

class MEMMANAGER {
	/**
	 * memcache connection handle 
	 * 
	 * @var memcache_obj 
	 */
	private $memcache_obj = null;
	/**
	 * check the memcache module is loaded
	 */
	function LoadMem() {
		if (!extension_loaded('memcached')) {
			exit("Fail : no memcached support");
		} 
	} 
	/**
	 * check login
	 * 
	 * @return boolean 
	 */
	function is_login() {
		if (isset($_SESSION) && array_key_exists("MADM_SESSION_KEY", $_SESSION))
			return true;
		else
			return false;
	} 
	/**
	 * get connection information from session
	 * 
	 * @param string $type the connection type
	 * @param int $num the connection index
	 * @return array 
	 */
	function GetConFromSession($type, $num) {
		if ($type == 'con') {
			$list = getConsList();
			return $list['cons'][$num];
		} else {
			$list = getConpsList();
			return $list['conps'][$num];
		} 
	}
	/**
	 * create connection
	 * 
	 * @param string $type the connection type
	 * @param array $curcon the connection index
	 * @return boolean 
	 */
	function MemConnect($type, $curcon) {
		$this -> memcache_obj = new \Memcached();
		if ($type == 'con') {
			//关闭压缩功能
			$this->memcache_obj->setOption(Memcached::OPT_COMPRESSION, false);
			//使用binary二进制协议
			$this->memcache_obj->setOption(Memcached::OPT_BINARY_PROTOCOL, false);
			//重要，php memcached有个bug，当get的值不存在，有固定40ms延迟，开启这个参数，可以避免这个bug
			$this->memcache_obj->setOption(Memcached::OPT_TCP_NODELAY, true);
			//设置超时 2s
			$this->memcache_obj->setOption(Memcached::OPT_CONNECT_TIMEOUT, 2000);
			//添加实例地址及端口号
			$this->memcache_obj->addServer($curcon['host'], $curcon['port']);
		}else {
			return false;
		}
		return true;
	}
	/**
	 * get the settings information of the connection
	 *
	 * @param string $host hostname
	 * @param int $port port
	 * @return array
	 */
	function GetStats($host, $port) {
		$list = $this -> memcache_obj>getStats();
		$key = $host . ":" . $port;
		return $list[$key];
	}


	/**
	 * get some items
	 * 
	 * @param string $key key
	 * @return array 
	 */
     function MemGet($keylist) {
        $list = array();
        foreach ($keylist as $key ) {
			$list[$key] = $this->memcache_obj->get($key);
			if($list[$key]){
				continue;
			}else {
				$list[$key] = array();
			}
        }
		return $list;
	}
	function GetAllKeys($curcon){
		$file = "../cache/" . $curcon['host'] . $curcon['port'] . ".json";
		if (file_exists($file)) {
			$mtime = filemtime($file);
			if($mtime ){
				$curtime = time();
				$time_interval = 6 * 3600;
				if ( ($curtime - $mtime) <= $time_interval){
					$json = file_get_contents($file);
					$list = json_decode($json, true);
				}else {
					$list = $this->memcache_obj->getAllKeys();
					$json = json_encode($list);
					file_put_contents($file, $json);
				}
			} else {
				$list = array();
			}
		} else{
			$list = $this->memcache_obj->getAllKeys();
			$json = json_encode($list);
			file_put_contents($file, $json);
		}
		return $list;
	}

	function GetKeysByReg($regex, $curcon) {
		//判断空
		if(empty($regex)) return array();
		//添加模式
		$regex = substr( $regex, 0, 1 ) == '/' ? $regex : ("/" . $regex . "/");
		$keys = $this->GetAllKeys($curcon);
		$list = array();
		foreach ($keys as $index ){
			if (preg_match($regex, $index)){
				$list[] = $index;
			}else{
				continue;
			}
		}
		return $list;
	}

	function GetFileCreateTime($curcon) {
		$file = "../cache/" . $curcon['host'] . $curcon['port'] . ".json";
		if(file_exists($file)){
			$atime = filemtime($file);
			$atime = date('Y-m-d H:i:s',$atime);
		}else{
			$atime = "0000-00-00 00:00:00";
		}
		return $atime;
	}

	function GetFileLastUpdateTime($curcon){
		$file = "../cache/" . $curcon['host'] . $curcon['port'] . ".json";
		if(file_exists($file)){
			$mtime = fileatime($file);
			$mtime = date('Y-m-d H:i:s',$mtime);

		}else{
			$mtime = "0000-00-00 00:00:00";
		}
		return $mtime;
	}
} 

?>
