<?php
/**
 * return the traverse data after filtered
 */
require_once('./appCommon.php');
require_once('../config.php');

if (!isset($_GET['type']) || !isset($_GET['num']) || !isset($_POST['data']))
	exit('Fail');
$type = $_GET['type'];
$num = $_GET['num'];
$regex = $_POST['data'];
$memm = new MEMMANAGER();
$curcon = $memm -> GetConFromSession($type, $num);
$memm -> LoadMem();
if (!$memm -> is_login())
	exit("NoLogin");
if (!$memm -> MemConnect($type, $curcon))
	exit("ConnectFail");
if ($type == 'con') {
	$list = $memm -> GetKeysByReg($regex, $curcon);
	echo json_encode($list);
}

?>