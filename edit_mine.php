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
  $updateSQL = sprintf("UPDATE mines SET mine=%s, branch=%s, shaft=%s, gps=%s, gps2=%s, locationID=%s WHERE mineID=%s",
                       GetSQLValueString($_POST['mine'], "text"),
                       GetSQLValueString($_POST['branch'], "text"),
                       GetSQLValueString($_POST['shaft'], "text"),
                       GetSQLValueString($_POST['gps'], "text"),
                       GetSQLValueString($_POST['gps2'], "text"),
                       GetSQLValueString($_POST['locationID'], "int"),
                       GetSQLValueString($_POST['mineID'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($updateSQL, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());

  $updateGoTo = "mines.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_mine = "-1";
if (isset($_GET['mineID'])) {
  $colname_mine = $_GET['mineID'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_mine = sprintf("SELECT * FROM mines WHERE mineID = %s", GetSQLValueString($colname_mine, "int"));
$mine = mysql_query($query_mine, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_mine = mysql_fetch_assoc($mine);
$totalRows_mine = mysql_num_rows($mine);

mysql_select_db($database_adhocConn, $adhocConn);
$query_locs = "SELECT * FROM locations ORDER BY location ASC";
$locs = mysql_query($query_locs, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_locs = mysql_fetch_assoc($locs);
$totalRows_locs = mysql_num_rows($locs);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
              <p>Edit Mine</p>
              <blockquote>
                <p>&nbsp;</p>
                
                <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                  <table align="center">
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">ID:</td>
                      <td><?php echo $row_mine['mineID']; ?></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Mine:</td>
                      <td><input name="mine" type="text" class="maintext" value="<?php echo htmlentities($row_mine['mine'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Division:</td>
                      <td><input name="branch" type="text" class="maintext" value="<?php echo htmlentities($row_mine['branch'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">GPS Code:</td>
                      <td><input name="shaft" type="text" class="maintext" value="<?php echo htmlentities($row_mine['shaft'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" nowrap="nowrap">GPS Latitude:</td>
                      <td><input name="gps" type="text" class="maintext" value="<?php echo htmlentities($row_mine['gps'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" nowrap="nowrap">GPS Longitude:</td>
                      <td><input name="gps2" type="text" class="maintext" value="<?php echo htmlentities($row_mine['gps2'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Location:</td>
                      <td><select name="locationID" class="maintext">
                          <?php 
do {  
?>
                          <option value="<?php echo $row_locs['locationID']?>" <?php if (!(strcmp($row_locs['locationID'], htmlentities($row_mine['locationID'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_locs['location']?></option>
                          <?php
} while ($row_locs = mysql_fetch_assoc($locs));
?>
                        </select>                      </td>
                    </tr>
                    
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">&nbsp;</td>
                      <td><input type="submit" class="maintext" value="Update record" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr valign="baseline">
                      <td colspan="2" align="right" nowrap="nowrap"><div align="center"><a href="delete_mine.php?mineID=<?php echo $_GET['mineID']; ?>">delete this mine</a></div></td>
                      </tr>
                  </table>
                  <input type="hidden" name="MM_update" value="form2" />
                  <input type="hidden" name="mineID" value="<?php echo $row_mine['mineID']; ?>" />
                </form>
                <p align="center"><a href="mines.php">Back to Mines</a></p>
              </blockquote>              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($mine);

mysql_free_result($locs);
?>
