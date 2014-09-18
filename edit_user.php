<?php require_once('Connections/adhocConn.php'); ?>
<?php
if ($_COOKIE['MM_UserGroup'] < 5) {
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE users SET fullname=%s, uname=%s, pword=%s, uemail=%s, ucell=%s, accesslevel=%s, status=%s, mo_f=%s, mo_t=%s, tu_f=%s, tu_t=%s, we_f=%s, we_t=%s, th_f=%s, th_t=%s, fr_f=%s, fr_t=%s, sa_f=%s, sa_t=%s, su_f=%s, su_t=%s, region=%s WHERE userID=%s",
                       GetSQLValueString($_POST['fullname'], "text"),
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['pword'], "text"),
                       GetSQLValueString($_POST['uemail'], "text"),
                       GetSQLValueString($_POST['ucell'], "text"),
                       GetSQLValueString($_POST['accesslevel'], "int"),
                       GetSQLValueString($_POST['status'], "int"),
                       GetSQLValueString($_POST['mo_f'], "int"),
                       GetSQLValueString($_POST['mo_t'], "int"),
                       GetSQLValueString($_POST['tu_f'], "int"),
                       GetSQLValueString($_POST['tu_t'], "int"),
                       GetSQLValueString($_POST['we_f'], "int"),
                       GetSQLValueString($_POST['we_t'], "int"),
                       GetSQLValueString($_POST['th_f'], "int"),
                       GetSQLValueString($_POST['th_t'], "int"),
                       GetSQLValueString($_POST['fr_f'], "int"),
                       GetSQLValueString($_POST['fr_t'], "int"),
                       GetSQLValueString($_POST['sa_f'], "int"),
                       GetSQLValueString($_POST['sa_t'], "int"),
                       GetSQLValueString($_POST['su_f'], "int"),
                       GetSQLValueString($_POST['su_t'], "int"),
                       GetSQLValueString($_POST['region'], "int"),
                       GetSQLValueString($_POST['userID'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($updateSQL, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());

  $updateGoTo = "users.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_edituser = "-1";
if (isset($_GET['userID'])) {
  $colname_edituser = $_GET['userID'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_edituser = sprintf("SELECT * FROM users WHERE userID = %s", GetSQLValueString($colname_edituser, "int"));
$edituser = mysql_query($query_edituser, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_edituser = mysql_fetch_assoc($edituser);
$totalRows_edituser = mysql_num_rows($edituser);

mysql_select_db($database_adhocConn, $adhocConn);
$query_alevels = "SELECT * FROM accesslevels ORDER BY accesslevelID ASC";
$alevels = mysql_query($query_alevels, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_alevels = mysql_fetch_assoc($alevels);
$totalRows_alevels = mysql_num_rows($alevels);

mysql_select_db($database_adhocConn, $adhocConn);
$query_statuses = "SELECT * FROM statuses ORDER BY statusID ASC";
$statuses = mysql_query($query_statuses, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_statuses = mysql_fetch_assoc($statuses);
$totalRows_statuses = mysql_num_rows($statuses);

mysql_select_db($database_adhocConn, $adhocConn);
$query_regions = "SELECT * FROM regions WHERE active = 1 ORDER BY region ASC";
$regions = mysql_query($query_regions, $adhocConn) or die(mysql_error());
$row_regions = mysql_fetch_assoc($regions);
$totalRows_regions = mysql_num_rows($regions);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ad Hoc Plumbers Admin Panel</title>

<script type="text/javascript" language="javascript">
    function convertEnterToTab() {
      if(event.keyCode==13) {
        event.keyCode = 9;
      }
    }
    document.onkeydown = convertEnterToTab;    
</script>
<script type="text/javascript"><!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>

<body onload="MM_preloadImages('design/mouseovers_r1_c1.jpg','design/mouseovers_r3_c1.jpg','design/mouseovers_r2_c1.jpg','design/maintenance_over.jpg')">
<?php require_once('inc_before.php'); ?>
              <p>Edit User</p>
              <blockquote>
                <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                  <table align="center">
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Name:</td>
                      <td><input name="fullname" type="text" class="maintext" value="<?php echo htmlentities($row_edituser['fullname'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Username:</td>
                      <td><input name="uname" type="text" class="maintext" value="<?php echo htmlentities($row_edituser['uname'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Password:</td>
                      <td><input name="pword" type="password" class="maintext" value="<?php echo htmlentities($row_edituser['pword'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Email:</td>
                      <td><input name="uemail" type="text" class="maintext" value="<?php echo htmlentities($row_edituser['uemail'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Cell:</td>
                      <td><input name="ucell" type="text" class="maintext" value="<?php echo htmlentities($row_edituser['ucell'], ENT_COMPAT, 'utf-8'); ?>" size="11" maxlength="11" />
                        <br />
                        eg. 27823456789</td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Access level:</td>
                      <td><select name="accesslevel" class="maintext">
                          <?php 
do {  
?>
                          <option value="<?php echo $row_alevels['accesslevelID']?>" <?php if (!(strcmp($row_alevels['accesslevelID'], htmlentities($row_edituser['accesslevel'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_alevels['accesslevel']?></option>
                          <?php
} while ($row_alevels = mysql_fetch_assoc($alevels));
?>
                        </select>                      </td>
                    </tr>
                    
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Status:</td>
                      <td><select name="status" class="maintext">
                          <?php 
do {  
?>
                          <option value="<?php echo $row_statuses['statusID']?>" <?php if (!(strcmp($row_statuses['statusID'], htmlentities($row_edituser['status'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_statuses['status']?></option>
                          <?php
} while ($row_statuses = mysql_fetch_assoc($statuses));
?>
                        </select>                      </td>
                    </tr>
                    
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Region:</td>
                      <td><select name="region" class="maintext" id="region">
                        <?php
do {  
?>
                        <option value="<?php echo $row_regions['regionID']?>"<?php if (!(strcmp($row_regions['regionID'], $row_edituser['region']))) {echo "selected=\"selected\"";} ?>><?php echo $row_regions['region']?></option>
                        <?php
} while ($row_regions = mysql_fetch_assoc($regions));
  $rows = mysql_num_rows($regions);
  if($rows > 0) {
      mysql_data_seek($regions, 0);
	  $row_regions = mysql_fetch_assoc($regions);
  }
?>
                      </select></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Access:</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Monday:</td>
                      <td><select name="mo_f" class="maintext" id="mo_f">
                        <option value="0" <?php if (!(strcmp(0, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>0</option>
                        <option value="1" <?php if (!(strcmp(1, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>1</option>
                        <option value="2" <?php if (!(strcmp(2, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>2</option>
                        <option value="3" <?php if (!(strcmp(3, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>3</option>
                        <option value="4" <?php if (!(strcmp(4, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>4</option>
                        <option value="5" <?php if (!(strcmp(5, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>5</option>
                        <option value="6" <?php if (!(strcmp(6, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>6</option>
                        <option value="7" <?php if (!(strcmp(7, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>7</option>
                        <option value="8" <?php if (!(strcmp(8, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>8</option>
                        <option value="9" <?php if (!(strcmp(9, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>9</option>
                        <option value="10" <?php if (!(strcmp(10, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>10</option>
                        <option value="11" <?php if (!(strcmp(11, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>11</option>
                        <option value="12" <?php if (!(strcmp(12, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>12</option>
                        <option value="13" <?php if (!(strcmp(13, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>13</option>
                        <option value="14" <?php if (!(strcmp(14, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>14</option>
                        <option value="15" <?php if (!(strcmp(15, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>15</option>
                        <option value="16" <?php if (!(strcmp(16, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>16</option>
                        <option value="17" <?php if (!(strcmp(17, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>17</option>
                        <option value="18" <?php if (!(strcmp(18, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>18</option>
                        <option value="19" <?php if (!(strcmp(19, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>19</option>
                        <option value="20" <?php if (!(strcmp(20, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>20</option>
                        <option value="21" <?php if (!(strcmp(21, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>21</option>
                        <option value="22" <?php if (!(strcmp(22, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>22</option>
                        <option value="23" <?php if (!(strcmp(23, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>23</option>
                        <option value="25" <?php if (!(strcmp(25, $row_edituser['mo_f']))) {echo "selected=\"selected\"";} ?>>NONE</option>
                        </select>
                        :00 
                        to
                        <select name="mo_t" class="maintext" id="mo_t">
                          <option value="0" <?php if (!(strcmp(0, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>0</option>
                          <option value="1" <?php if (!(strcmp(1, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>1</option>
                          <option value="2" <?php if (!(strcmp(2, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>2</option>
                          <option value="3" <?php if (!(strcmp(3, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>3</option>
                          <option value="4" <?php if (!(strcmp(4, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>4</option>
                          <option value="5" <?php if (!(strcmp(5, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>5</option>
                          <option value="6" <?php if (!(strcmp(6, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>6</option>
                          <option value="7" <?php if (!(strcmp(7, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>7</option>
                          <option value="8" <?php if (!(strcmp(8, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>8</option>
                          <option value="9" <?php if (!(strcmp(9, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>9</option>
                          <option value="10" <?php if (!(strcmp(10, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>10</option>
                          <option value="11" <?php if (!(strcmp(11, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>11</option>
                          <option value="12" <?php if (!(strcmp(12, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>12</option>
                          <option value="13" <?php if (!(strcmp(13, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>13</option>
                          <option value="14" <?php if (!(strcmp(14, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>14</option>
                          <option value="15" <?php if (!(strcmp(15, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>15</option>
                          <option value="16" <?php if (!(strcmp(16, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>16</option>
                          <option value="17" <?php if (!(strcmp(17, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>17</option>
                          <option value="18" <?php if (!(strcmp(18, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>18</option>
                          <option value="19" <?php if (!(strcmp(19, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>19</option>
                          <option value="20" <?php if (!(strcmp(20, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>20</option>
                          <option value="21" <?php if (!(strcmp(21, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>21</option>
                          <option value="22" <?php if (!(strcmp(22, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>22</option>
                          <option value="23" <?php if (!(strcmp(23, $row_edituser['mo_t']))) {echo "selected=\"selected\"";} ?>>23</option>
                        </select>
                        :00 </td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Tuesday:</td>
                      <td><select name="tu_f" class="maintext" id="tu_f">
                          <option value="0" <?php if (!(strcmp(0, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>0</option>
                          <option value="1" <?php if (!(strcmp(1, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>1</option>
                          <option value="2" <?php if (!(strcmp(2, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>2</option>
                          <option value="3" <?php if (!(strcmp(3, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>3</option>
                          <option value="4" <?php if (!(strcmp(4, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>4</option>
                          <option value="5" <?php if (!(strcmp(5, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>5</option>
                          <option value="6" <?php if (!(strcmp(6, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>6</option>
                          <option value="7" <?php if (!(strcmp(7, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>7</option>
                          <option value="8" <?php if (!(strcmp(8, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>8</option>
                          <option value="9" <?php if (!(strcmp(9, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>9</option>
                          <option value="10" <?php if (!(strcmp(10, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>10</option>
                          <option value="11" <?php if (!(strcmp(11, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>11</option>
                          <option value="12" <?php if (!(strcmp(12, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>12</option>
                          <option value="13" <?php if (!(strcmp(13, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>13</option>
                          <option value="14" <?php if (!(strcmp(14, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>14</option>
                          <option value="15" <?php if (!(strcmp(15, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>15</option>
                          <option value="16" <?php if (!(strcmp(16, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>16</option>
                          <option value="17" <?php if (!(strcmp(17, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>17</option>
                          <option value="18" <?php if (!(strcmp(18, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>18</option>
                          <option value="19" <?php if (!(strcmp(19, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>19</option>
                          <option value="20" <?php if (!(strcmp(20, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>20</option>
                          <option value="21" <?php if (!(strcmp(21, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>21</option>
                          <option value="22" <?php if (!(strcmp(22, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>22</option>
                          <option value="23" <?php if (!(strcmp(23, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>23</option>
                          <option value="25" <?php if (!(strcmp(25, $row_edituser['tu_f']))) {echo "selected=\"selected\"";} ?>>NONE</option>
                        </select>
                        :00 
                        to
                        <select name="tu_t" class="maintext" id="tu_t">
                          <option value="0" <?php if (!(strcmp(0, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>0</option>
                          <option value="1" <?php if (!(strcmp(1, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>1</option>
                          <option value="2" <?php if (!(strcmp(2, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>2</option>
                          <option value="3" <?php if (!(strcmp(3, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>3</option>
                          <option value="4" <?php if (!(strcmp(4, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>4</option>
                          <option value="5" <?php if (!(strcmp(5, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>5</option>
                          <option value="6" <?php if (!(strcmp(6, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>6</option>
                          <option value="7" <?php if (!(strcmp(7, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>7</option>
                          <option value="8" <?php if (!(strcmp(8, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>8</option>
                          <option value="9" <?php if (!(strcmp(9, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>9</option>
                          <option value="10" <?php if (!(strcmp(10, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>10</option>
                          <option value="11" <?php if (!(strcmp(11, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>11</option>
                          <option value="12" <?php if (!(strcmp(12, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>12</option>
                          <option value="13" <?php if (!(strcmp(13, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>13</option>
                          <option value="14" <?php if (!(strcmp(14, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>14</option>
                          <option value="15" <?php if (!(strcmp(15, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>15</option>
                          <option value="16" <?php if (!(strcmp(16, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>16</option>
                          <option value="17" <?php if (!(strcmp(17, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>17</option>
                          <option value="18" <?php if (!(strcmp(18, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>18</option>
                          <option value="19" <?php if (!(strcmp(19, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>19</option>
                          <option value="20" <?php if (!(strcmp(20, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>20</option>
                          <option value="21" <?php if (!(strcmp(21, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>21</option>
                          <option value="22" <?php if (!(strcmp(22, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>22</option>
                          <option value="23" <?php if (!(strcmp(23, $row_edituser['tu_t']))) {echo "selected=\"selected\"";} ?>>23</option>
                        </select>
                        :00 </td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Wednesday:</td>
                      <td><select name="we_f" class="maintext" id="we_f">
                          <option value="0" <?php if (!(strcmp(0, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>0</option>
                          <option value="1" <?php if (!(strcmp(1, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>1</option>
                          <option value="2" <?php if (!(strcmp(2, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>2</option>
                          <option value="3" <?php if (!(strcmp(3, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>3</option>
                          <option value="4" <?php if (!(strcmp(4, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>4</option>
                          <option value="5" <?php if (!(strcmp(5, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>5</option>
                          <option value="6" <?php if (!(strcmp(6, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>6</option>
                          <option value="7" <?php if (!(strcmp(7, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>7</option>
                          <option value="8" <?php if (!(strcmp(8, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>8</option>
                          <option value="9" <?php if (!(strcmp(9, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>9</option>
                          <option value="10" <?php if (!(strcmp(10, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>10</option>
                          <option value="11" <?php if (!(strcmp(11, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>11</option>
                          <option value="12" <?php if (!(strcmp(12, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>12</option>
                          <option value="13" <?php if (!(strcmp(13, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>13</option>
                          <option value="14" <?php if (!(strcmp(14, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>14</option>
                          <option value="15" <?php if (!(strcmp(15, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>15</option>
                          <option value="16" <?php if (!(strcmp(16, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>16</option>
                          <option value="17" <?php if (!(strcmp(17, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>17</option>
                          <option value="18" <?php if (!(strcmp(18, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>18</option>
                          <option value="19" <?php if (!(strcmp(19, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>19</option>
                          <option value="20" <?php if (!(strcmp(20, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>20</option>
                          <option value="21" <?php if (!(strcmp(21, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>21</option>
                          <option value="22" <?php if (!(strcmp(22, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>22</option>
                          <option value="23" <?php if (!(strcmp(23, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>23</option>
                          <option value="25" <?php if (!(strcmp(25, $row_edituser['we_f']))) {echo "selected=\"selected\"";} ?>>NONE</option>
                        </select>
                        :00 
                        to
                        <select name="we_t" class="maintext" id="we_t">
                          <option value="0" <?php if (!(strcmp(0, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>0</option>
                          <option value="1" <?php if (!(strcmp(1, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>1</option>
                          <option value="2" <?php if (!(strcmp(2, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>2</option>
                          <option value="3" <?php if (!(strcmp(3, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>3</option>
                          <option value="4" <?php if (!(strcmp(4, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>4</option>
                          <option value="5" <?php if (!(strcmp(5, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>5</option>
                          <option value="6" <?php if (!(strcmp(6, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>6</option>
                          <option value="7" <?php if (!(strcmp(7, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>7</option>
                          <option value="8" <?php if (!(strcmp(8, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>8</option>
                          <option value="9" <?php if (!(strcmp(9, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>9</option>
                          <option value="10" <?php if (!(strcmp(10, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>10</option>
                          <option value="11" <?php if (!(strcmp(11, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>11</option>
                          <option value="12" <?php if (!(strcmp(12, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>12</option>
                          <option value="13" <?php if (!(strcmp(13, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>13</option>
                          <option value="14" <?php if (!(strcmp(14, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>14</option>
                          <option value="15" <?php if (!(strcmp(15, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>15</option>
                          <option value="16" <?php if (!(strcmp(16, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>16</option>
                          <option value="17" <?php if (!(strcmp(17, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>17</option>
                          <option value="18" <?php if (!(strcmp(18, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>18</option>
                          <option value="19" <?php if (!(strcmp(19, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>19</option>
                          <option value="20" <?php if (!(strcmp(20, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>20</option>
                          <option value="21" <?php if (!(strcmp(21, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>21</option>
                          <option value="22" <?php if (!(strcmp(22, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>22</option>
                          <option value="23" <?php if (!(strcmp(23, $row_edituser['we_t']))) {echo "selected=\"selected\"";} ?>>23</option>
                        </select>
                        :00 </td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Thursday</td>
                      <td><select name="th_f" class="maintext" id="th_f">
                          <option value="0" <?php if (!(strcmp(0, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>0</option>
                          <option value="1" <?php if (!(strcmp(1, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>1</option>
                          <option value="2" <?php if (!(strcmp(2, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>2</option>
                          <option value="3" <?php if (!(strcmp(3, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>3</option>
                          <option value="4" <?php if (!(strcmp(4, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>4</option>
                          <option value="5" <?php if (!(strcmp(5, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>5</option>
                          <option value="6" <?php if (!(strcmp(6, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>6</option>
                          <option value="7" <?php if (!(strcmp(7, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>7</option>
                          <option value="8" <?php if (!(strcmp(8, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>8</option>
                          <option value="9" <?php if (!(strcmp(9, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>9</option>
                          <option value="10" <?php if (!(strcmp(10, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>10</option>
                          <option value="11" <?php if (!(strcmp(11, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>11</option>
                          <option value="12" <?php if (!(strcmp(12, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>12</option>
                          <option value="13" <?php if (!(strcmp(13, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>13</option>
                          <option value="14" <?php if (!(strcmp(14, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>14</option>
                          <option value="15" <?php if (!(strcmp(15, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>15</option>
                          <option value="16" <?php if (!(strcmp(16, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>16</option>
                          <option value="17" <?php if (!(strcmp(17, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>17</option>
                          <option value="18" <?php if (!(strcmp(18, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>18</option>
                          <option value="19" <?php if (!(strcmp(19, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>19</option>
                          <option value="20" <?php if (!(strcmp(20, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>20</option>
                          <option value="21" <?php if (!(strcmp(21, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>21</option>
                          <option value="22" <?php if (!(strcmp(22, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>22</option>
                          <option value="23" <?php if (!(strcmp(23, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>23</option>
                          <option value="25" <?php if (!(strcmp(25, $row_edituser['th_f']))) {echo "selected=\"selected\"";} ?>>NONE</option>
                        </select>
                        :00 
                        to
                        <select name="th_t" class="maintext" id="th_t">
                          <option value="0" <?php if (!(strcmp(0, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>0</option>
                          <option value="1" <?php if (!(strcmp(1, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>1</option>
                          <option value="2" <?php if (!(strcmp(2, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>2</option>
                          <option value="3" <?php if (!(strcmp(3, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>3</option>
                          <option value="4" <?php if (!(strcmp(4, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>4</option>
                          <option value="5" <?php if (!(strcmp(5, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>5</option>
                          <option value="6" <?php if (!(strcmp(6, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>6</option>
                          <option value="7" <?php if (!(strcmp(7, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>7</option>
                          <option value="8" <?php if (!(strcmp(8, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>8</option>
                          <option value="9" <?php if (!(strcmp(9, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>9</option>
                          <option value="10" <?php if (!(strcmp(10, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>10</option>
                          <option value="11" <?php if (!(strcmp(11, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>11</option>
                          <option value="12" <?php if (!(strcmp(12, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>12</option>
                          <option value="13" <?php if (!(strcmp(13, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>13</option>
                          <option value="14" <?php if (!(strcmp(14, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>14</option>
                          <option value="15" <?php if (!(strcmp(15, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>15</option>
                          <option value="16" <?php if (!(strcmp(16, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>16</option>
                          <option value="17" <?php if (!(strcmp(17, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>17</option>
                          <option value="18" <?php if (!(strcmp(18, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>18</option>
                          <option value="19" <?php if (!(strcmp(19, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>19</option>
                          <option value="20" <?php if (!(strcmp(20, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>20</option>
                          <option value="21" <?php if (!(strcmp(21, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>21</option>
                          <option value="22" <?php if (!(strcmp(22, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>22</option>
                          <option value="23" <?php if (!(strcmp(23, $row_edituser['th_t']))) {echo "selected=\"selected\"";} ?>>23</option>
                        </select>
                        :00 </td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Friday</td>
                      <td><select name="fr_f" class="maintext" id="fr_f">
                          <option value="0" <?php if (!(strcmp(0, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>0</option>
                          <option value="1" <?php if (!(strcmp(1, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>1</option>
                          <option value="2" <?php if (!(strcmp(2, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>2</option>
                          <option value="3" <?php if (!(strcmp(3, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>3</option>
                          <option value="4" <?php if (!(strcmp(4, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>4</option>
                          <option value="5" <?php if (!(strcmp(5, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>5</option>
                          <option value="6" <?php if (!(strcmp(6, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>6</option>
                          <option value="7" <?php if (!(strcmp(7, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>7</option>
                          <option value="8" <?php if (!(strcmp(8, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>8</option>
                          <option value="9" <?php if (!(strcmp(9, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>9</option>
                          <option value="10" <?php if (!(strcmp(10, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>10</option>
                          <option value="11" <?php if (!(strcmp(11, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>11</option>
                          <option value="12" <?php if (!(strcmp(12, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>12</option>
                          <option value="13" <?php if (!(strcmp(13, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>13</option>
                          <option value="14" <?php if (!(strcmp(14, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>14</option>
                          <option value="15" <?php if (!(strcmp(15, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>15</option>
                          <option value="16" <?php if (!(strcmp(16, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>16</option>
                          <option value="17" <?php if (!(strcmp(17, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>17</option>
                          <option value="18" <?php if (!(strcmp(18, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>18</option>
                          <option value="19" <?php if (!(strcmp(19, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>19</option>
                          <option value="20" <?php if (!(strcmp(20, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>20</option>
                          <option value="21" <?php if (!(strcmp(21, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>21</option>
                          <option value="22" <?php if (!(strcmp(22, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>22</option>
                          <option value="23" <?php if (!(strcmp(23, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>23</option>
                          <option value="25" <?php if (!(strcmp(25, $row_edituser['fr_f']))) {echo "selected=\"selected\"";} ?>>NONE</option>
                        </select>
                        :00 
                        to
                        <select name="fr_t" class="maintext" id="fr_t">
                          <option value="0" <?php if (!(strcmp(0, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>0</option>
                          <option value="1" <?php if (!(strcmp(1, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>1</option>
                          <option value="2" <?php if (!(strcmp(2, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>2</option>
                          <option value="3" <?php if (!(strcmp(3, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>3</option>
                          <option value="4" <?php if (!(strcmp(4, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>4</option>
                          <option value="5" <?php if (!(strcmp(5, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>5</option>
                          <option value="6" <?php if (!(strcmp(6, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>6</option>
                          <option value="7" <?php if (!(strcmp(7, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>7</option>
                          <option value="8" <?php if (!(strcmp(8, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>8</option>
                          <option value="9" <?php if (!(strcmp(9, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>9</option>
                          <option value="10" <?php if (!(strcmp(10, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>10</option>
                          <option value="11" <?php if (!(strcmp(11, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>11</option>
                          <option value="12" <?php if (!(strcmp(12, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>12</option>
                          <option value="13" <?php if (!(strcmp(13, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>13</option>
                          <option value="14" <?php if (!(strcmp(14, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>14</option>
                          <option value="15" <?php if (!(strcmp(15, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>15</option>
                          <option value="16" <?php if (!(strcmp(16, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>16</option>
                          <option value="17" <?php if (!(strcmp(17, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>17</option>
                          <option value="18" <?php if (!(strcmp(18, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>18</option>
                          <option value="19" <?php if (!(strcmp(19, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>19</option>
                          <option value="20" <?php if (!(strcmp(20, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>20</option>
                          <option value="21" <?php if (!(strcmp(21, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>21</option>
                          <option value="22" <?php if (!(strcmp(22, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>22</option>
                          <option value="23" <?php if (!(strcmp(23, $row_edituser['fr_t']))) {echo "selected=\"selected\"";} ?>>23</option>
                        </select>
                        :00 </td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Saturday</td>
                      <td><select name="sa_f" class="maintext" id="sa_f">
                          <option value="0" <?php if (!(strcmp(0, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>0</option>
                          <option value="1" <?php if (!(strcmp(1, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>1</option>
                          <option value="2" <?php if (!(strcmp(2, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>2</option>
                          <option value="3" <?php if (!(strcmp(3, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>3</option>
                          <option value="4" <?php if (!(strcmp(4, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>4</option>
                          <option value="5" <?php if (!(strcmp(5, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>5</option>
                          <option value="6" <?php if (!(strcmp(6, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>6</option>
                          <option value="7" <?php if (!(strcmp(7, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>7</option>
                          <option value="8" <?php if (!(strcmp(8, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>8</option>
                          <option value="9" <?php if (!(strcmp(9, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>9</option>
                          <option value="10" <?php if (!(strcmp(10, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>10</option>
                          <option value="11" <?php if (!(strcmp(11, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>11</option>
                          <option value="12" <?php if (!(strcmp(12, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>12</option>
                          <option value="13" <?php if (!(strcmp(13, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>13</option>
                          <option value="14" <?php if (!(strcmp(14, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>14</option>
                          <option value="15" <?php if (!(strcmp(15, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>15</option>
                          <option value="16" <?php if (!(strcmp(16, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>16</option>
                          <option value="17" <?php if (!(strcmp(17, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>17</option>
                          <option value="18" <?php if (!(strcmp(18, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>18</option>
                          <option value="19" <?php if (!(strcmp(19, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>19</option>
                          <option value="20" <?php if (!(strcmp(20, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>20</option>
                          <option value="21" <?php if (!(strcmp(21, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>21</option>
                          <option value="22" <?php if (!(strcmp(22, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>22</option>
                          <option value="23" <?php if (!(strcmp(23, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>23</option>
                          <option value="25" <?php if (!(strcmp(25, $row_edituser['sa_f']))) {echo "selected=\"selected\"";} ?>>NONE</option>
                        </select>
                        :00 
                        to
                        <select name="sa_t" class="maintext" id="sa_t">
                          <option value="0" <?php if (!(strcmp(0, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>0</option>
                          <option value="1" <?php if (!(strcmp(1, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>1</option>
                          <option value="2" <?php if (!(strcmp(2, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>2</option>
                          <option value="3" <?php if (!(strcmp(3, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>3</option>
                          <option value="4" <?php if (!(strcmp(4, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>4</option>
                          <option value="5" <?php if (!(strcmp(5, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>5</option>
                          <option value="6" <?php if (!(strcmp(6, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>6</option>
                          <option value="7" <?php if (!(strcmp(7, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>7</option>
                          <option value="8" <?php if (!(strcmp(8, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>8</option>
                          <option value="9" <?php if (!(strcmp(9, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>9</option>
                          <option value="10" <?php if (!(strcmp(10, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>10</option>
                          <option value="11" <?php if (!(strcmp(11, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>11</option>
                          <option value="12" <?php if (!(strcmp(12, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>12</option>
                          <option value="13" <?php if (!(strcmp(13, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>13</option>
                          <option value="14" <?php if (!(strcmp(14, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>14</option>
                          <option value="15" <?php if (!(strcmp(15, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>15</option>
                          <option value="16" <?php if (!(strcmp(16, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>16</option>
                          <option value="17" <?php if (!(strcmp(17, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>17</option>
                          <option value="18" <?php if (!(strcmp(18, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>18</option>
                          <option value="19" <?php if (!(strcmp(19, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>19</option>
                          <option value="20" <?php if (!(strcmp(20, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>20</option>
                          <option value="21" <?php if (!(strcmp(21, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>21</option>
                          <option value="22" <?php if (!(strcmp(22, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>22</option>
                          <option value="23" <?php if (!(strcmp(23, $row_edituser['sa_t']))) {echo "selected=\"selected\"";} ?>>23</option>
                        </select>
                        :00 </td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Sunday</td>
                      <td><select name="su_f" class="maintext" id="su_f">
                          <option value="0" <?php if (!(strcmp(0, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>0</option>
                          <option value="1" <?php if (!(strcmp(1, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>1</option>
                          <option value="2" <?php if (!(strcmp(2, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>2</option>
                          <option value="3" <?php if (!(strcmp(3, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>3</option>
                          <option value="4" <?php if (!(strcmp(4, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>4</option>
                          <option value="5" <?php if (!(strcmp(5, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>5</option>
                          <option value="6" <?php if (!(strcmp(6, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>6</option>
                          <option value="7" <?php if (!(strcmp(7, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>7</option>
                          <option value="8" <?php if (!(strcmp(8, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>8</option>
                          <option value="9" <?php if (!(strcmp(9, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>9</option>
                          <option value="10" <?php if (!(strcmp(10, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>10</option>
                          <option value="11" <?php if (!(strcmp(11, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>11</option>
                          <option value="12" <?php if (!(strcmp(12, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>12</option>
                          <option value="13" <?php if (!(strcmp(13, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>13</option>
                          <option value="14" <?php if (!(strcmp(14, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>14</option>
                          <option value="15" <?php if (!(strcmp(15, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>15</option>
                          <option value="16" <?php if (!(strcmp(16, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>16</option>
                          <option value="17" <?php if (!(strcmp(17, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>17</option>
                          <option value="18" <?php if (!(strcmp(18, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>18</option>
                          <option value="19" <?php if (!(strcmp(19, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>19</option>
                          <option value="20" <?php if (!(strcmp(20, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>20</option>
                          <option value="21" <?php if (!(strcmp(21, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>21</option>
                          <option value="22" <?php if (!(strcmp(22, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>22</option>
                          <option value="23" <?php if (!(strcmp(23, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>23</option>
                          <option value="25" <?php if (!(strcmp(25, $row_edituser['su_f']))) {echo "selected=\"selected\"";} ?>>NONE</option>
                        </select>
                        :00 
                        to
                        <select name="su_t" class="maintext" id="su_t">
                          <option value="0" <?php if (!(strcmp(0, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>0</option>
                          <option value="1" <?php if (!(strcmp(1, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>1</option>
                          <option value="2" <?php if (!(strcmp(2, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>2</option>
                          <option value="3" <?php if (!(strcmp(3, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>3</option>
                          <option value="4" <?php if (!(strcmp(4, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>4</option>
                          <option value="5" <?php if (!(strcmp(5, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>5</option>
                          <option value="6" <?php if (!(strcmp(6, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>6</option>
                          <option value="7" <?php if (!(strcmp(7, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>7</option>
                          <option value="8" <?php if (!(strcmp(8, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>8</option>
                          <option value="9" <?php if (!(strcmp(9, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>9</option>
                          <option value="10" <?php if (!(strcmp(10, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>10</option>
                          <option value="11" <?php if (!(strcmp(11, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>11</option>
                          <option value="12" <?php if (!(strcmp(12, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>12</option>
                          <option value="13" <?php if (!(strcmp(13, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>13</option>
                          <option value="14" <?php if (!(strcmp(14, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>14</option>
                          <option value="15" <?php if (!(strcmp(15, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>15</option>
                          <option value="16" <?php if (!(strcmp(16, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>16</option>
                          <option value="17" <?php if (!(strcmp(17, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>17</option>
                          <option value="18" <?php if (!(strcmp(18, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>18</option>
                          <option value="19" <?php if (!(strcmp(19, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>19</option>
                          <option value="20" <?php if (!(strcmp(20, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>20</option>
                          <option value="21" <?php if (!(strcmp(21, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>21</option>
                          <option value="22" <?php if (!(strcmp(22, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>22</option>
                          <option value="23" <?php if (!(strcmp(23, $row_edituser['su_t']))) {echo "selected=\"selected\"";} ?>>23</option>
                        </select>
                        :00 </td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">&nbsp;</td>
                      <td><input type="submit" class="maintext" value="Update user" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr valign="baseline">
                      <td colspan="2" align="right" nowrap="nowrap"><div align="center"><a href="delete_user.php?userID=<?php echo $row_edituser['userID']; ?>">click here to delete this user</a></div></td>
                      </tr>
                  </table>
                  <input type="hidden" name="MM_update" value="form2" />
                  <input type="hidden" name="userID" value="<?php echo $row_edituser['userID']; ?>" />
                </form>
                <p align="center"><a href="users.php">Back to Users</a></p>
              </blockquote>              <?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($regions);
?>

</body>
</html>
<?php
mysql_free_result($edituser);

mysql_free_result($alevels);

mysql_free_result($statuses);
?>
