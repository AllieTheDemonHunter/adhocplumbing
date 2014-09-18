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
	$updateSQL = sprintf("UPDATE call_log SET dispatcher=%s, notes=%s, quote_amt=%s, quote_no=%s, call_status=%s WHERE logID=%s",
                       GetSQLValueString($_COOKIE['MM_userID'], "int"),
                       GetSQLValueString($_POST['notes'], "text"),
                       GetSQLValueString($_POST['quote_amt'], "text"),
                       GetSQLValueString($_POST['quote_no'], "text"),
                       GetSQLValueString($_POST['call_status'], "int"),
                       GetSQLValueString($_POST['logID'], "int"));

	mysql_select_db($database_adhocConn, $adhocConn);
	$Result1 = mysql_query($updateSQL, $adhocConn) or die(__LINE__.mysql_error());
  
	$updateGoTo = "control_panel.php";
	header(sprintf("Location: %s", $updateGoTo));
}

$colname_call = "-1";
if (isset($_GET['caseno'])) {
  $colname_call = $_GET['caseno'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_call = sprintf("SELECT * FROM call_log WHERE logID = %s", GetSQLValueString($colname_call, "int"));
$call = mysql_query($query_call, $adhocConn) or die(__LINE__.mysql_error());
$row_call = mysql_fetch_assoc($call);
$totalRows_call = mysql_num_rows($call);

mysql_select_db($database_adhocConn, $adhocConn);
$query_v1 = "SELECT vehicleID, vehicle FROM vehicles ORDER BY vehicle ASC";
$v1 = mysql_query($query_v1, $adhocConn) or die(__LINE__.mysql_error());
$row_v1 = mysql_fetch_assoc($v1);
$totalRows_v1 = mysql_num_rows($v1);

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

<body onload="MM_preloadImages('design/mouseovers_r1_c1.jpg','design/mouseovers_r3_c1.jpg','design/mouseovers_r2_c1.jpg','design/maintenance_over.jpg')">
<?php require_once('inc_before.php'); ?>
              <p>Decline Quote</p>
                <p align="center" class="logbutton">CASE NUMBER: <?php echo $row_call['logID']; ?></p>
                
                <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                  <table border="0" align="center" cellpadding="3" cellspacing="0">
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Address:</td>
                      <td colspan="4" rowspan="2"><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_call['addressID']);
						$address = mysql_query($query_address, $adhocConn) or die(mysql_error());
						$row_address = mysql_fetch_assoc($address);
						$totalRows_address = mysql_num_rows($address);
						if ($row_address['unitno']) {
							echo $row_address['unitno'] . " " . $row_address['complex'] . "<br>";
						}
						echo $row_address['streetno'] . " " . $row_address['street'] . "<br>";
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_suburb = sprintf("SELECT * FROM suburbs WHERE suburbID = %s", $row_address['suburb']);
						$suburb = mysql_query($query_suburb, $adhocConn) or die(mysql_error());
						$row_suburb = mysql_fetch_assoc($suburb);
						$totalRows_suburb = mysql_num_rows($suburb);
						echo $row_suburb['suburb'];
						mysql_free_result($suburb);
						mysql_free_result($address);
					  ?></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">&nbsp;</td>
                    </tr>

                    <tr valign="baseline">
                      <td align="right" valign="top" nowrap="nowrap">Notes:</td>
                      <td colspan="4"><textarea name="notes2" cols="50" rows="5" class="maintext"><?php echo htmlentities($row_call['notes'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Quote Amount:</td>
                      <td><input name="quote_amt" type="text" class="maintext" id="quote_amt" size="4" value="<?php echo htmlentities($row_call['quote_amt'], ENT_COMPAT, 'utf-8'); ?>" />
                        </td>
                      <td colspan="3">&nbsp;</td>
                    </tr>

                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Quote No:</td>
                      <td colspan="4"><input name="quote_no" type="text" class="maintext" id="quote_no" size="6" value="<?php echo htmlentities($row_call['quote_no'], ENT_COMPAT, 'utf-8'); ?>" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td colspan="2" align="right" nowrap="nowrap">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td colspan="2"><div align="right">
                        <input type="submit" class="logbutton" value="DECLINE QUOTE" />
                      </div></td>
                      </tr>
                  </table>
                  <input type="hidden" name="logtime" value="<?php echo htmlentities($row_call['logtime'], ENT_COMPAT, 'utf-8'); ?>" />
                  <input type="hidden" name="call_status" value="9" />
                  <input type="hidden" name="MM_update" value="form2" />
                  <input type="hidden" name="logID" value="<?php echo $row_call['logID']; ?>" />
                  <input type="hidden" name="dispatcher" value="<?php echo $_COOKIE['MM_userID']; ?>" />
                </form>
                <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($call);

mysql_free_result($v1);

mysql_free_result($v2);

mysql_free_result($v3);

mysql_free_result($v1crew1);
?>
