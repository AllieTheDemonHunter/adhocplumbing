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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO call_log (logtime, casename, caller, dispatcher, telno1, telno2, telno3, `address`, mine, `location`, `condition`, `notes`, medaid, medaidno, calltype, call_status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString(time(), "text"),
                       GetSQLValueString($_POST['casename'], "text"),
                       GetSQLValueString($_POST['caller'], "text"),
                       GetSQLValueString($_POST['dispatcher'], "int"),
                       GetSQLValueString($_POST['telno1'], "text"),
                       GetSQLValueString($_POST['telno2'], "text"),
                       GetSQLValueString($_POST['telno3'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['mine'], "int"),
                       GetSQLValueString($_POST['location'], "int"),
                       GetSQLValueString($_POST['condition'], "text"),
                       GetSQLValueString($_POST['notes'], "text"),
                       GetSQLValueString($_POST['medaid'], "int"),
                       GetSQLValueString($_POST['medaidno'], "text"),
                       GetSQLValueString($_POST['calltype'], "int"),
                       GetSQLValueString($_POST['call_status'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($insertSQL, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());

  $insertGoTo = "control_panel.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_adhocConn, $adhocConn);
$query_location = "SELECT * FROM locations ORDER BY location ASC";
$location = mysql_query($query_location, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_location = mysql_fetch_assoc($location);
$totalRows_location = mysql_num_rows($location);

mysql_select_db($database_adhocConn, $adhocConn);
$query_mines = "SELECT * FROM mines ORDER BY mine ASC";
$mines = mysql_query($query_mines, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_mines = mysql_fetch_assoc($mines);
$totalRows_mines = mysql_num_rows($mines);

mysql_select_db($database_adhocConn, $adhocConn);
$query_aids = "SELECT * FROM med_aids ORDER BY aidname ASC";
$aids = mysql_query($query_aids, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_aids = mysql_fetch_assoc($aids);
$totalRows_aids = mysql_num_rows($aids);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ad Hoc Plumbers Admin Panel</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 18px;
	color: #000000;
}
body {
	background-color: #CCCCCC;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script type="text/javascript" language="javascript">
    function convertEnterToTab() {
      if(event.keyCode==13) {
        event.keyCode = 9;
      }
    }
    document.onkeydown = convertEnterToTab;    
</script>
<script type="text/javascript">
<!--
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

<body onload="MM_preloadImages('design/mouseovers_r1_c1.jpg','design/mouseovers_r3_c1.jpg','design/mouseovers_r2_c1.jpg')">
<?php require_once('inc_before.php'); ?>
<span class="logbutton">Log Primary Call</span><br /><br />
              <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                <table align="center" cellpadding="0" cellspacing="0">
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Case Name:</td>
                    <td colspan="3"><input name="casename" type="text" class="maintext" id="casename" value="" size="32" maxlength="45" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Caller:</td>
                    <td colspan="3"><input name="caller" type="text" class="maintext" value="" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Tel no:</td>
                    <td colspan="3"><input name="telno1" type="text" class="maintext" value="" size="12" /> 
                      / 
                        <input name="telno2" type="text" class="maintext" value="" size="12" /> 
                        /                       <input name="telno3" type="text" class="maintext" value="" size="12" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right" valign="top">Condition:</td>
                    <td colspan="3"><select name="condition" class="maintext" id="condition">
                      <option value="Medical">Medical</option>
                      <option value="Trauma">Trauma</option>
                    </select>                    </td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right" valign="top">Notes:</td>
                    <td colspan="3"><textarea name="notes" cols="50" rows="3" class="maintext" id="notes"></textarea></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right" valign="top">Mine:</td>
                    <td colspan="3"><select name="mine" class="maintext" id="mine">
                      <option value="0">not applicable</option>
                      <?php
do {  
?>
                      <option value="<?php echo $row_mines['mineID']?>"><?php echo $row_mines['mine']?> - <?php echo $row_mines['branch']; ?> - <?php echo $row_mines['shaft']; ?></option>
                      <?php
} while ($row_mines = mysql_fetch_assoc($mines));
  $rows = mysql_num_rows($mines);
  if($rows > 0) {
      mysql_data_seek($mines, 0);
	  $row_mines = mysql_fetch_assoc($mines);
  }
?>
                    </select></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right" valign="top">Location:</td>
                    <td colspan="3"><select name="location" class="maintext" id="location">
                      <?php
do {  
?>
                      <option value="<?php echo $row_location['locationID']?>"><?php echo $row_location['location']?></option>
                      <?php
} while ($row_location = mysql_fetch_assoc($location));
  $rows = mysql_num_rows($location);
  if($rows > 0) {
      mysql_data_seek($location, 0);
	  $row_location = mysql_fetch_assoc($location);
  }
?>
                    </select></td>
                    </tr>
                  <tr valign="baseline">
                    <td align="right" valign="top" nowrap="nowrap">Address:</td>
                    <td colspan="3"><textarea name="address" cols="20" rows="3" class="maintext"></textarea>                    </td>
                    </tr>
                  
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Med aid:</td>
                    <td><select name="medaid" class="maintext" id="medaid">
                      <?php
do {  
?>
                      <option value="<?php echo $row_aids['aidID']?>"><?php echo $row_aids['aidname']?></option>
                      <?php
} while ($row_aids = mysql_fetch_assoc($aids));
  $rows = mysql_num_rows($aids);
  if($rows > 0) {
      mysql_data_seek($aids, 0);
	  $row_aids = mysql_fetch_assoc($aids);
  }
?>
                    </select></td>
                    <td colspan="2" rowspan="2" valign="bottom"><div align="right">
                      <input type="submit" class="logbutton" value="LOG CALL" />
                    </div></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Med aid no:</td>
                    <td><input name="medaidno" type="text" class="maintext" value="" size="15" /></td>
                    </tr>
                </table>
                <input type="hidden" name="dispatcher" value="<?php echo $_COOKIE['MM_userID']; ?>" />
                <input type="hidden" name="calltype" value="1" />
                <input type="hidden" name="call_status" value="1" />
                <input type="hidden" name="MM_insert" value="form2" />
              </form>
              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($location);

mysql_free_result($mines);

mysql_free_result($aids);
?>
