<?php
	if(!defined('IN_MADM')) exit();
	require_once("../langs/".$_SESSION["MADM_SESSION_KEY"]['lang'].".php");	
	require_once('../config.php');
	global $config;
	$curcon=$memm->GetConFromSession($type,$num);
	$memm->LoadMem();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	if(strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 8.0"))
		echo "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=EmulateIE7\" />";
?>
<title>Search</title>
<script type="text/javascript" src="../include/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../include/js/jquery.md5.js"></script>
<script type="text/javascript" src="../include/js/item_filtertrav.js"></script>
<link rel="stylesheet" href="../include/css/item_filtertrav.css" />
<style type="text/css">
body{<?php set_font('body');?>}
</style>
<script language="javascript">
var nonum="<?php echo $langs['itemt_nonum'];?>";
var delconfirm="<?php echo $langs['memg_delconfirm'];?>";
var unserfail="<?php echo $langs['memg_unserfail'];?>";
var numonly="<?php echo $langs['itemt_numonly'];?>";
var numwrong="<?php echo $langs['itemt_numwrong'];?>";
var getres="<?php echo $langs['itemt_getres'];?>";
var resnot="<?php echo $langs['memg_resnot'];?>";
var noexist="<?php echo $langs['itemt_notexist'];?>";
var sert="<?php echo $langs['memg_ser'];?>";
var unsert="<?php echo $langs['memg_unser'];?>";
var del="<?php echo $langs['con_del'];?>";
var valuefail="<?php echo $langs['memg_geterror'];?>";
var conpnoexist="<?php echo $langs['itemt_conpgeterror'];?>";
var novaluetime="<?php echo $langs['itemt_novaluetime'];?>";
var valuetypetit="<?php echo $langs['itemt_valuetype'];?>";
var loading="<?php echo $langs['itemt_loading'];?>";
var prepage="<?php echo $langs['itemt_prepage'];?>";
var nexpage="<?php echo $langs['itemt_nexpage'];?>";
var pagenumno="<?php echo $langs['itemt_pagenumno'];?>";
var nofiltercheck="<?php echo $langs['itemft_nofiltercheck'];?>";
var keyfilteremp="<?php echo $langs['itemft_filterkeyemp'];?>";
var valuefilteremp="<?php echo $langs['itemft_filtervalueemp'];?>";
var keyfilterfail="<?php echo $langs['itemft_keyfilterfail'];?>";
var valuefilterfail="<?php echo $langs['itemft_valuefilterfail'];?>";
var nofilterret="<?php echo $langs['itemft_noreturn'];?>";
var conpcannotfilter="<?php echo $langs['itemft_conpcannotfilter'];?>";
var thetnum="<?php echo $langs['memg_tnum'];?>";
var pagingerr="<?php echo $langs['itemt_pagingerr'];?>";
var updatetit="<?php echo $langs['memg_updateres'];?>";
var type="<?php echo $type;?>";
var num="<?php echo $num;?>";
var moreinfo="<?php echo $langs['itemt_moreinfo'];?>";
var moreclose="<?php echo $langs['itemt_closemore'];?>";
var itemsize="<?php echo $langs['itemt_size'];?>";
var noexpire="<?php echo $langs['itemt_expiretime'];?>";
var charset="<?php echo $langs['itemt_charsettit'];?>";
var recharnot="<?php echo $langs['memg_reget'];?>";
</script>
</head>

<body>
    <div id="top">
    <?php
        echo $langs['itemft_tit'];
    ?>
    </div>
    <?php
    if($type=='con') {
        if (!$memm->MemConnect($type, $curcon))
            echo "<div id=\"confail\">" . $langs['confail'] . "</div>";
        else {
            $list = $memm->GetAllKeys($curcon);
            $create_time = $memm->GetFileCreateTime($curcon);
            $last_update_time = $memm->GetFileLastUpdateTime($curcon);
        }
    }
    ?>
<div class="layoutfixed">
    <div id="itemstit"><span><?php echo $curcon['host']." : ".$curcon['port'];?></span></div>
    <div id="totalnum"><?php echo $langs['itemt_totalnum'];?><span id="totalnumvalue"><?php echo " " .count($list);?></span></span></div>
    <div id="createdtime"><span><?php echo $langs['createdtime'];?><span id="createdtimevalue"><?php echo ": ".$create_time;?></span></span></div>
    <div id="lastupdatetime"><span><?php echo $langs['lastupdatetime'];?><span id="lastupdatetimevalue"><?php echo ": ".$last_update_time;?></span></span></div>
    <div id="filterdemo"><a id="showdemobut" href="javascript:;"><?php echo $langs['itemft_demo'];?></a></div>
    <div id="travmenu">
        <div class="layoutfixed">
            <div id="totalmenu">
                <span id="keyfilterinputtit"><?php echo $langs['itemft_filter'];?></span><input id="keyfilterin" name="keyfilterin" type="text" />
                <input id="gotrav" class="but" name="gotrav" type="button" value="<?php echo $langs['itemft_tit_search'];?>"/>
                <select name='selcharset' id="selcharset" style="margin-left: 30px;">
                    <option id="UTF-8" value="UTF-8">UTF-8</option>
                    <option id="GBK" value="GBK">GBK</option>
                    <option id="GB2312" value="GB2312">GB2312</option>
                    <option id="GB18030" value="GB18030">GB18030</option>
                    <option id="Latin-1" value="Latin-1">Latin-1</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div id="showres"></div>
<div id="pages"></div>
<div id="showdemo">
<div id="showdemotit"><?php echo $langs['itemft_demo'];?><a id="closedemo" title="<?php echo $langs['itemft_close'];?>" href="javascript:;">X</a></div>
<table id="demotable"  cellpadding="2" cellspacing="1" >
<tr><td><?php echo $langs['itemft_demo1'];?></td><td>/abc/</td></tr>
<tr><td><?php echo $langs['itemft_demo2'];?></td><td>/abc/i</td></tr>
<tr><td><?php echo $langs['itemft_demo3'];?></td><td>/^abc/</td></tr>
<tr><td><?php echo $langs['itemft_demo4'];?></td><td>/abc$/</td></tr>
<tr><td><?php echo $langs['itemft_demo5'];?></td><td>/[0-9]$/</td></tr>
<tr><td><?php echo $langs['itemft_demo6'];?></td><td>/^[^ab]*$/</td></tr>
</table>
</div>
</body>
</html>