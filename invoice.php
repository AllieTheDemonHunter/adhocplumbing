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
	$updateSQL = sprintf("UPDATE call_log SET inv_amt=%s, invoice_no=%s, notes=%s, capturer=%s, call_status=6, invoiced=1 WHERE logID=%s",
                       GetSQLValueString($_POST['inv_amt'], "double"),
                       GetSQLValueString($_POST['invoice_no'], "text"),
                       GetSQLValueString($_POST['notes'], "text"),
                       GetSQLValueString($_POST['capturer'], "int"),
                       GetSQLValueString($_POST['logID'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($updateSQL, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
  
  $updateGoTo = "control_panel_accounts.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_call = "-1";
if (isset($_GET['caseno'])) {
  $colname_call = $_GET['caseno'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_call = sprintf("SELECT * FROM call_log WHERE logID = %s", GetSQLValueString($colname_call, "int"));
$call = mysql_query($query_call, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_call = mysql_fetch_assoc($call);
$totalRows_call = mysql_num_rows($call);

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
              <p align="center" class="logbutton">Case No: <?php echo $row_call['logID']; ?></p>
              <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                <table border="0" align="center" cellpadding="1" cellspacing="0">
                  
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Invoice No:</td>
                    <td><input type="text" name="invoice_no" value="<?php echo htmlentities($row_call['invoice_no'], ENT_COMPAT, 'utf-8'); ?>" size="12" class="maintext" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Invoice Amount:</td>
                    <td><input type="text" name="inv_amt" value="<?php echo htmlentities($row_call['inv_amt'], ENT_COMPAT, 'utf-8'); ?>" size="12" class="maintext" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" valign="top" nowrap="nowrap">Notes:</td>
                    <td><textarea name="notes" cols="40" rows="3" class="maintext"><?php echo htmlentities($row_call['notes'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td><div align="right">
                      <input type="submit" class="maintext" value="Update record" />
                    </div></td>
                    </tr>
                </table>
                <input type="hidden" name="capturer" value="<?php echo $_COOKIE['MM_userID']; ?>" />
                <input type="hidden" name="MM_update" value="form2" />
                <input type="hidden" name="logID" value="<?php echo $row_call['logID']; ?>" />
              </form>
              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($call);
?>
