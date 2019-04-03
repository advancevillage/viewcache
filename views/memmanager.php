<?php
if(!ini_get('session.auto_start'))
	session_start();
define('IN_MADM', true);
error_reporting(0);
require_once('../include/class/memmanager.class.php');
$memm = new MEMMANAGER();
if (!$memm -> is_login())
	exit("NoLogin");
if (!isset($_GET['type']) || !isset($_GET['num']) || $_GET['type'] != 'con' && $_GET['type'] != 'conp')
	exit;
if (isset($_GET['action']) && $_GET['action'] == 'showcon') {
	$type = $_GET['type'];
	$num = $_GET['num'];
	require_once('show_con.php');
}
if (isset($_GET['action']) && $_GET['action'] == 'constatus') {
	$type = $_GET['type'];
	$num = $_GET['num'];
	require_once('con_status.php');
}
if (isset($_GET['action']) && $_GET['action'] == 'memget') {
	$type = $_GET['type'];
	$num = $_GET['num'];
	require_once('mem_get.php');
}
if (isset($_GET['action']) && $_GET['action'] == 'filtertrav') {
	$type = $_GET['type'];
	$num = $_GET['num'];
	require_once('item_filtertrav.php');
}
?>