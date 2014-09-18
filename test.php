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

if ($_COOKIE['MM_userID']) {
	mysql_select_db($database_adhocConn, $adhocConn);
	$query_my_region = sprintf("SELECT * FROM users WHERE userID = %s", $_COOKIE['MM_userID']);
	$my_region = mysql_query($query_my_region, $adhocConn) or die(mysql_error());
	$row_my_region = mysql_fetch_assoc($my_region);
	$totalRows_my_region = mysql_num_rows($my_region);
	if ($row_my_region['region']) {
		$myregionID = $row_my_region['region'];
	} else {
		$myregionID = -1;
	}
	mysql_select_db($database_adhocConn, $adhocConn);
	$query_regionname = sprintf("SELECT * FROM regions WHERE regionID = %s", $myregionID);
	$regionname = mysql_query($query_regionname, $adhocConn) or die(mysql_error());
	$row_regionname = mysql_fetch_assoc($regionname);
	$totalRows_regionname = mysql_num_rows($regionname);
	echo $row_regionname['region'];
	mysql_free_result($regionname);

	mysql_free_result($my_region);
}

mysql_select_db($database_adhocConn, $adhocConn);
$query_red = sprintf("SELECT * FROM call_log INNER JOIN addresses using (addressID) WHERE call_status = 6 AND invoice_no is null AND region = %s ORDER BY calltype ASC, logtime DESC", $myregionID);
$red = mysql_query($query_red, $adhocConn) or die(mysql_error());
$row_red = mysql_fetch_assoc($red);
$totalRows_red = mysql_num_rows($red);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="1" cellpadding="3" cellspacing="0">
  <tr>
    <td>logID</td>
    <td>job_no</td>
    <td>logtime</td>
    <td>caller</td>
    <td>dispatcher</td>
    <td>telno1</td>
    <td>telno2</td>
    <td>telno3</td>
    <td>addressID</td>
    <td>clientID</td>
    <td>location</td>
    <td>condition</td>
    <td>medaid</td>
    <td>medaidno</td>
    <td>vehicle1</td>
    <td>vehicle2</td>
    <td>vehicle3</td>
    <td>v1crew1</td>
    <td>v1crew2</td>
    <td>v1crew3</td>
    <td>v2crew1</td>
    <td>v2crew2</td>
    <td>v2crew3</td>
    <td>v3crew1</td>
    <td>v3crew2</td>
    <td>v3crew3</td>
    <td>service</td>
    <td>prf_no</td>
    <td>notes</td>
    <td>capturer</td>
    <td>calltype</td>
    <td>tfrtime</td>
    <td>medauthno</td>
    <td>medauthperson</td>
    <td>tfrfrom</td>
    <td>fromother</td>
    <td>wardfrom</td>
    <td>drfrom</td>
    <td>drfromtelno</td>
    <td>tfrto</td>
    <td>toother</td>
    <td>wardto</td>
    <td>drto</td>
    <td>drtotelno</td>
    <td>patient</td>
    <td>carelevel</td>
    <td>priority</td>
    <td>attachments</td>
    <td>medicine</td>
    <td>als_supervise</td>
    <td>call_status</td>
    <td>sms_sent</td>
    <td>give_away</td>
    <td>given_to</td>
    <td>reason</td>
    <td>auth_by</td>
    <td>quote_amt</td>
    <td>quote_no</td>
    <td>invoiced</td>
    <td>invoice_no</td>
    <td>inv_amt</td>
    <td>paid</td>
    <td>paiddate</td>
    <td>order_no</td>
    <td>policy_no</td>
    <td>claim_no</td>
    <td>reference_no</td>
    <td>despatched</td>
    <td>est_fin_time</td>
    <td>logged_by</td>
    <td>seq_no</td>
    <td>job_complete</td>
    <td>other</td>
    <td>jobcard_no</td>
    <td>diary</td>
    <td>read</td>
    <td>ins_receipt_no</td>
    <td>access_amt</td>
    <td>access_pmt_method</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_red['logID']; ?></td>
      <td><?php echo $row_red['job_no']; ?></td>
      <td><?php echo $row_red['logtime']; ?></td>
      <td><?php echo $row_red['caller']; ?></td>
      <td><?php echo $row_red['dispatcher']; ?></td>
      <td><?php echo $row_red['telno1']; ?></td>
      <td><?php echo $row_red['telno2']; ?></td>
      <td><?php echo $row_red['telno3']; ?></td>
      <td><?php echo $row_red['addressID']; ?></td>
      <td><?php echo $row_red['clientID']; ?></td>
      <td><?php echo $row_red['location']; ?></td>
      <td><?php echo $row_red['condition']; ?></td>
      <td><?php echo $row_red['medaid']; ?></td>
      <td><?php echo $row_red['medaidno']; ?></td>
      <td><?php echo $row_red['vehicle1']; ?></td>
      <td><?php echo $row_red['vehicle2']; ?></td>
      <td><?php echo $row_red['vehicle3']; ?></td>
      <td><?php echo $row_red['v1crew1']; ?></td>
      <td><?php echo $row_red['v1crew2']; ?></td>
      <td><?php echo $row_red['v1crew3']; ?></td>
      <td><?php echo $row_red['v2crew1']; ?></td>
      <td><?php echo $row_red['v2crew2']; ?></td>
      <td><?php echo $row_red['v2crew3']; ?></td>
      <td><?php echo $row_red['v3crew1']; ?></td>
      <td><?php echo $row_red['v3crew2']; ?></td>
      <td><?php echo $row_red['v3crew3']; ?></td>
      <td><?php echo $row_red['service']; ?></td>
      <td><?php echo $row_red['prf_no']; ?></td>
      <td><?php echo $row_red['notes']; ?></td>
      <td><?php echo $row_red['capturer']; ?></td>
      <td><?php echo $row_red['calltype']; ?></td>
      <td><?php echo $row_red['tfrtime']; ?></td>
      <td><?php echo $row_red['medauthno']; ?></td>
      <td><?php echo $row_red['medauthperson']; ?></td>
      <td><?php echo $row_red['tfrfrom']; ?></td>
      <td><?php echo $row_red['fromother']; ?></td>
      <td><?php echo $row_red['wardfrom']; ?></td>
      <td><?php echo $row_red['drfrom']; ?></td>
      <td><?php echo $row_red['drfromtelno']; ?></td>
      <td><?php echo $row_red['tfrto']; ?></td>
      <td><?php echo $row_red['toother']; ?></td>
      <td><?php echo $row_red['wardto']; ?></td>
      <td><?php echo $row_red['drto']; ?></td>
      <td><?php echo $row_red['drtotelno']; ?></td>
      <td><?php echo $row_red['patient']; ?></td>
      <td><?php echo $row_red['carelevel']; ?></td>
      <td><?php echo $row_red['priority']; ?></td>
      <td><?php echo $row_red['attachments']; ?></td>
      <td><?php echo $row_red['medicine']; ?></td>
      <td><?php echo $row_red['als_supervise']; ?></td>
      <td><?php echo $row_red['call_status']; ?></td>
      <td><?php echo $row_red['sms_sent']; ?></td>
      <td><?php echo $row_red['give_away']; ?></td>
      <td><?php echo $row_red['given_to']; ?></td>
      <td><?php echo $row_red['reason']; ?></td>
      <td><?php echo $row_red['auth_by']; ?></td>
      <td><?php echo $row_red['quote_amt']; ?></td>
      <td><?php echo $row_red['quote_no']; ?></td>
      <td><?php echo $row_red['invoiced']; ?></td>
      <td><?php echo $row_red['invoice_no']; ?></td>
      <td><?php echo $row_red['inv_amt']; ?></td>
      <td><?php echo $row_red['paid']; ?></td>
      <td><?php echo $row_red['paiddate']; ?></td>
      <td><?php echo $row_red['order_no']; ?></td>
      <td><?php echo $row_red['policy_no']; ?></td>
      <td><?php echo $row_red['claim_no']; ?></td>
      <td><?php echo $row_red['reference_no']; ?></td>
      <td><?php echo $row_red['despatched']; ?></td>
      <td><?php echo $row_red['est_fin_time']; ?></td>
      <td><?php echo $row_red['logged_by']; ?></td>
      <td><?php echo $row_red['seq_no']; ?></td>
      <td><?php echo $row_red['job_complete']; ?></td>
      <td><?php echo $row_red['other']; ?></td>
      <td><?php echo $row_red['jobcard_no']; ?></td>
      <td><?php echo $row_red['diary']; ?></td>
      <td><?php echo $row_red['read']; ?></td>
      <td><?php echo $row_red['ins_receipt_no']; ?></td>
      <td><?php echo $row_red['access_amt']; ?></td>
      <td><?php echo $row_red['access_pmt_method']; ?></td>
    </tr>
    <?php } while ($row_red = mysql_fetch_assoc($red)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($red);
?>
