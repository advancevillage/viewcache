<?php
if(!defined('IN_MADM')) exit();
require_once('./config.php');
global $config;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login></title>
<script type="text/javascript" src="include/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="include/js/login.js"></script>
<link type="text/css" href="include/css/login.css" rel="stylesheet" />
<link rel="shortcut icon" href="images/favicon.ico">
<style type="text/css">
    body {
        background: lightseagreen
    }
    #l_but {
        width: 260px;
        height: 30px;
    }
    #l_main {
        text-align: center;
        margin-top: 15%;
    }
</style>
</head>
<body>
<div id="l_main">
	<div id="nojs">
		To Login you need JavaScript 
	</div>
  <div id="l_login">
    <div id="l_in">
      <p class="l_in_p"><span>Username：</span>
        <input id="l_in_user" name="user" type="text">
      </p>
      <p class="l_in_p"><span>Password：</span>
        <input id="l_in_pass" name="passwd" type="password">
      </p>
      <p>
        <input id="l_but" name="but" type="button" value="LOGIN">
      </p>
      <div id="l_show_callbak"></div>
    </div>
  </div>
</div>
</body>
</html>