<?php require_once('Connections/adhocConn.php'); ?>
<?php
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
  $updateSQL = sprintf("UPDATE call_log SET give_away=%s, given_to=%s, reason=%s, auth_by=%s, notes=%s WHERE logID=%s",
                       GetSQLValueString($_POST['give_away'], "int"),
                       GetSQLValueString($_POST['given_to'], "text"),
                       GetSQLValueString($_POST['reason'], "text"),
                       GetSQLValueString($_POST['auth_by'], "int"),
                       GetSQLValueString($_POST['notes'], "text"),
                       GetSQLValueString($_POST['logID'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($updateSQL, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());

  $updateGoTo = "control_panel.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_log = "-1";
if (isset($_GET['caseno'])) {
  $colname_log = $_GET['caseno'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_log = sprintf("SELECT * FROM call_log WHERE logID = %s", GetSQLValueString($colname_log, "int"));
$log = mysql_query($query_log, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_log = mysql_fetch_assoc($log);
$totalRows_log = mysql_num_rows($log);

mysql_select_db($database_adhocConn, $adhocConn);
$query_users = "SELECT * FROM users WHERE accesslevel >= 3 AND accesslevel < 7 ORDER BY fullname ASC";
$users = mysql_query($query_users, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

if (!($_COOKIE['MM_UserGroup'])) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
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
              <p>Give Away</p>
              <p align="center" class="logbutton">CASE NUMBER: <?php echo $row_log['logID']; ?></p>
              <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                <table align="center">

                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Given to:</td>
                    <td><input name="given_to" type="text" class="maintext" value="<?php echo htmlentities($row_log['given_to'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Reason:</td>
                    <td><input name="reason" type="text" class="maintext" value="<?php echo htmlentities($row_log['reason'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Authorized by:</td>
                    <td><select name="auth_by" class="maintext" id="auth_by">
                      <?php
do {  
?>
                      <option value="<?php echo $row_users['userID']?>"><?php echo $row_users['fullname']?></option>
                      <?php
} while ($row_users = mysql_fetch_assoc($users));
  $rows = mysql_num_rows($users);
  if($rows > 0) {
      mysql_data_seek($users, 0);
	  $row_users = mysql_fetch_assoc($users);
  }
?>
                    </select></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right" valign="top">Notes:</td>
                    <td><textarea name="notes" cols="40" rows="5" class="maintext"><?php echo htmlentities($row_log['notes'], ENT_COMPAT, 'utf-8'); ?></textarea>                    </td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td><div align="right">
                      <input type="submit" class="logbutton" value="FINISH" />
                    </div></td>
                  </tr>
                </table>
                <input type="hidden" name="give_away" value="1" />
                <input type="hidden" name="MM_update" value="form2" />
                <input type="hidden" name="logID" value="<?php echo $row_log['logID']; ?>" />
              </form>
              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($log);

mysql_free_result($users);
?>
