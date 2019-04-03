<?php
/**
 * get command
 */
require_once('./appCommon.php');
require_once('../config.php');
if (!isset($_GET['type']) || !isset($_GET['num']) || !isset($_POST['data']))
	exit('Fail');
if(!isset($_GET['charset']))
	$cs='UTF-8';
else
	$cs=$_GET['charset'];
$type = $_GET['type'];
$num = $_GET['num'];
$data = $_POST['data'];
$memm = new MEMMANAGER();
$curcon = $memm -> GetConFromSession($type, $num);
$memm -> LoadMem();
if (!$memm -> is_login())
	exit("NoLogin");
if (!$memm -> MemConnect($type, $curcon))
	exit("ConnectFail");
$thekey = str_replace("_ _rd", "'", $data[0]['key']);
$thekey = str_replace("_ _rx", "\\", $thekey);
$thekey = trim($thekey);
$keylist = explode(" ", $thekey);
$list = $memm -> MemGet($keylist);
echo array2json($list,$cs);
?>