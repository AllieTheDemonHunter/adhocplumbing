<?php require_once('Connections/adhocConn.php'); ?>
<?php
if (!($_COOKIE['MM_UserGroup'])) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_adhocConn, $adhocConn);
$query_red = "SELECT * FROM call_log WHERE call_status = 1 ORDER BY calltype ASC, logtime DESC";
$red = mysql_query($query_red, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_red = mysql_fetch_assoc($red);
$totalRows_red = mysql_num_rows($red);

mysql_select_db($database_adhocConn, $adhocConn);
$query_orange = "SELECT * FROM call_log WHERE call_status = 2 ORDER BY calltype ASC, logtime DESC";
$orange = mysql_query($query_orange, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_orange = mysql_fetch_assoc($orange);
$totalRows_orange = mysql_num_rows($orange);

mysql_select_db($database_adhocConn, $adhocConn);
$query_green = "SELECT * FROM call_log WHERE call_status = 3 ORDER BY calltype ASC, logtime DESC";
$green = mysql_query($query_green, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_green = mysql_fetch_assoc($green);
$totalRows_green = mysql_num_rows($green);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ad Hoc Plumbers Admin Panel</title>

<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<link href="styles.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Refresh" content="15" />
</head>

<body>
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<body onLoad="MM_preloadImages('design/mouseovers_r3_c1.jpg','design/mouseovers_r2_c1.jpg','design/mouseovers_r1_c1.jpg','design/home_screen_over.jpg')"><table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
    <td height="613" valign="top" background="design/bg_controlscreen.jpg"><table width="950" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="160" height="613" valign="middle"><table border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td><div align="center" class="loginbutton"><?php echo date("d", time()); ?></div></td>
          </tr>
          <tr>
            <td><div align="center" class="loginbutton"><?php echo date("M", time()); ?></div></td>
          </tr>
          <tr>
            <td><div align="center" class="loginbutton"><?php echo date("Y", time()); ?></div></td>
          </tr>
          <tr>
            <td><div align="center" class="maintext">&nbsp;</div></td>
          </tr>
          <tr>
            <td><div align="center" class="loginbutton"><?php echo date("H:i", time()); ?></div></td>
          </tr>
        </table></td>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="15">
          <tr>
            <td valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php 
				if ($totalRows_red > 0) {
				do { 
				$logtime = $row_red['logtime'];
				if ($row_red['calltype'] == 2) {
					$logtime = $row_red['tfrtime'];
				}
				?>
                  <tr>
                  <td width="35">
				  <?php if ($logtime >= time() - 172800) { ?>
                  	<img src="design/red.jpg" width="29" height="29" />
				  <?php } else { ?>
                  	<img src="design/red.gif" width="29" height="29" />
				  <?php 
					if ($row_red['sms_sent'] == 0) {
						// send sms
						$msg = "ALERT: Quote not logged in allocated 8 hours: Case No " . $row_red['logID'] . ".";
						$cellno = 27764767111;
						// send otp
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, 'http://www.mymobileapi.com/api5/http5.aspx');
						curl_setopt ($ch, CURLOPT_POST, 1);
						$post_fields = "Type=sendparam&username=adhoc&password=admin1&numto=" . $cellno . "&data1=" . $msg;
						curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_fields);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$response_string = curl_exec($ch);
						curl_close($ch);
						// update call log
						$updateSQL = sprintf("UPDATE call_log SET sms_sent=1 WHERE logID=%s", $row_red['logID']);
						mysql_select_db($database_adhocConn, $adhocConn);
						$Result1 = mysql_query($updateSQL, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
					}
				  
				  } ?></td>
                  <td bgcolor="#FCE0E0"><div align="center"><?php echo $row_red['logID']; ?></div></td>
                  <td bgcolor="#FCE0E0"><div align="center"><?php echo date("d M Y", $logtime); ?></div></td>
                  <td bgcolor="#FCE0E0"><div align="center"><?php echo date("H:i", $logtime); ?></div></td>
                  <td bgcolor="#FCE0E0"><div align="center"><?php
				  	if ($row_red['location']) {
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_locs = sprintf("SELECT * FROM locations WHERE locationID = %s", $row_red['location']);
						$locs = mysql_query($query_locs, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
						$row_locs = mysql_fetch_assoc($locs);
						$totalRows_locs = mysql_num_rows($locs);
						echo $row_locs['location'];
						mysql_free_result($locs);
					}
				  ?></div></td>
                  <td bgcolor="#FCE0E0"><div align="center"><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_ctype = sprintf("SELECT * FROM call_types WHERE typeID = %s", $row_red['calltype']);
						$ctype = mysql_query($query_ctype, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
						$row_ctype = mysql_fetch_assoc($ctype);
						$totalRows_ctype = mysql_num_rows($ctype);
						echo $row_ctype['calltype'];
						mysql_free_result($ctype);
				  ?></div></td>
                  </tr>
                  <?php } while ($row_red = mysql_fetch_assoc($red)); 
				  }
				  ?>
                <?php 
				if ($totalRows_orange > 0) {
				do { 
				$logtime = $row_orange['logtime'];
				if ($row_orange['calltype'] == 2) {
					$logtime = $row_orange['tfrtime'];
				}
				?>
                  <tr>
                  <td width="35"><img src="design/amber.jpg" width="29" height="29" /></td>
                  <td bgcolor="#FFECCC"><div align="center"><?php echo $row_orange['logID']; ?></div></td>
                  <td bgcolor="#FFECCC"><div align="center"><?php echo date("d M Y", $logtime); ?></div></td>
                  <td bgcolor="#FFECCC"><div align="center"><?php echo date("H:i", $logtime); ?></div></td>
                  <td bgcolor="#FFECCC"><div align="center"><?php
				  	if ($row_orange['location']) {
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_locs = sprintf("SELECT * FROM locations WHERE locationID = %s", $row_orange['location']);
						$locs = mysql_query($query_locs, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
						$row_locs = mysql_fetch_assoc($locs);
						$totalRows_locs = mysql_num_rows($locs);
						echo $row_locs['location'];
						mysql_free_result($locs);
					}
				  ?></div></td>
                  <td bgcolor="#FFECCC"><div align="center"><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_ctype = sprintf("SELECT * FROM call_types WHERE typeID = %s", $row_orange['calltype']);
						$ctype = mysql_query($query_ctype, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
						$row_ctype = mysql_fetch_assoc($ctype);
						$totalRows_ctype = mysql_num_rows($ctype);
						echo $row_ctype['calltype'];
						mysql_free_result($ctype);
				  ?></div></td>
                  </tr>
                  <?php } while ($row_orange = mysql_fetch_assoc($orange)); 
				  }
				  ?>
                <?php 
				if ($totalRows_green > 0) {
				do { 
				$logtime = $row_green['logtime'];
				if ($row_green['calltype'] == 2) {
					$logtime = $row_green['tfrtime'];
				}
				?>
                  <tr>
                  <td width="35"><img src="design/green.jpg" width="29" height="29" /></td>
                  <td bgcolor="#CBF3CD"><div align="center"><?php echo $row_green['logID']; ?></div></td>
                  <td bgcolor="#CBF3CD"><div align="center"><?php echo date("d M Y", $logtime); ?></div></td>
                  <td bgcolor="#CBF3CD"><div align="center"><?php echo date("H:i", $logtime); ?></div></td>
                  <td bgcolor="#CBF3CD"><div align="center"><?php
				  	if ($row_green['location']) {
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_locs = sprintf("SELECT * FROM locations WHERE locationID = %s", $row_green['location']);
						$locs = mysql_query($query_locs, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
						$row_locs = mysql_fetch_assoc($locs);
						$totalRows_locs = mysql_num_rows($locs);
						echo $row_locs['location'];
						mysql_free_result($locs);
					}
				  ?></div></td>
                  <td bgcolor="#CBF3CD"><div align="center"><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_ctype = sprintf("SELECT * FROM call_types WHERE typeID = %s", $row_green['calltype']);
						$ctype = mysql_query($query_ctype, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
						$row_ctype = mysql_fetch_assoc($ctype);
						$totalRows_ctype = mysql_num_rows($ctype);
						echo $row_ctype['calltype'];
						mysql_free_result($ctype);
				  ?></div></td>
                  </tr>
                  <?php } while ($row_green = mysql_fetch_assoc($green)); 
				  }
				  ?>
            </table>
<?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($red);
mysql_free_result($orange);
mysql_free_result($green);
?>
