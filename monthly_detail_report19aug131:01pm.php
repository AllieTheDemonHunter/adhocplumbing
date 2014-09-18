<?php require_once('Connections/adhocConn.php'); ?>
<?php require_once('inc_before.php'); ?>
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

$sd = getdate(time()); 
$sd_m = $sd[mon];
$sd_y = $sd[year];

$firstmonth = mktime(0,0,0,$sd_m,1,$sd_y);
if (isset($_GET['settime'])) {
	$settime = $_GET['settime'];
} else {
	$settime = $firstmonth;
}
$ssd = getdate($settime); 
$ssd_d = $ssd[mday];
$ssd_m = $ssd[mon];
$ssd_y = $ssd[year];
if ($ssd_m == 1) {
	$prevmo = mktime(0,0,0,12,1,$ssd_y-1);
	$nextmo = mktime(0,0,0,2,1,$ssd_y);
} else {
	if ($ssd_m == 12) {
		$prevmo = mktime(0,0,0,11,1,$ssd_y);
		$nextmo = mktime(0,0,0,1,1,$ssd_y+1);
	} else {
		$prevmo = mktime(0,0,0,$ssd_m-1,1,$ssd_y);
		$nextmo = mktime(0,0,0,$ssd_m+1,1,$ssd_y);
	}
}

$colname_calls = "-1";
if (isset($_GET['logtime'])) {
  $colname_calls = $_GET['logtime'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_calls = sprintf("SELECT * FROM call_log INNER JOIN addresses using (addressID) WHERE logtime > %s AND logtime <= %s AND region = %s ORDER BY logtime ASC", $settime, $nextmo, $myregionID);
$calls = mysql_query($query_calls, $adhocConn) or die(mysql_error());
$row_calls = mysql_fetch_assoc($calls);
$totalRows_calls = mysql_num_rows($calls);
?>
&nbsp;
<p>Monthly Report</p>
<table border="0" align="center" cellpadding="10" cellspacing="0">
  <tr>
    <td><div align="left"><a href="monthly_detail_report.php?settime=<?php echo $prevmo; ?>" class="attention">previous month</a></div></td>
    <td><div align="center"><?php echo date("F Y", $settime); ?></div></td>
    <td><div align="right"><a href="monthly_detail_report.php?settime=<?php echo $nextmo; ?>" class="attention">next month</a></div></td>
  </tr>
</table>
<br />
<table border="1" cellpadding="3" cellspacing="0">
  <tr>
    <td class="fineprintplain">logID</td>
    <td class="fineprintplain">logged</td>
    <td class="fineprintplain">job no</td>
    <td class="fineprintplain">status</td>
    <td class="fineprintplain">quote amt</td>
    <td class="fineprintplain">quote no</td>
    <td class="fineprintplain">invoiced</td>
    <td class="fineprintplain">invoice no</td>
    <td class="fineprintplain">invoice amt</td>
    <td class="fineprintplain">paid</td>
    <td class="fineprintplain">paiddate</td>
    <td class="fineprintplain">complete</td>
    <td class="fineprintplain">jobcard no</td>
    <td class="fineprintplain">insurance recpt no</td>
    <td class="fineprintplain">access amt</td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="fineprintplain"><?php echo $row_calls['logID']; ?></td>
      <td class="fineprintplain"><?php echo date("d M Y", $row_calls['logtime']); ?></td>
      <td class="fineprintplain"><?php echo $row_calls['job_no']; ?></td>
      <td class="fineprintplain"><?php 
			mysql_select_db($database_adhocConn, $adhocConn);
			$query_status = sprintf("SELECT * FROM call_statuses WHERE statusID = %s", $row_calls['call_status']);
			$status = mysql_query($query_status, $adhocConn) or die(mysql_error());
			$row_status = mysql_fetch_assoc($status);
			$totalRows_status = mysql_num_rows($status);
			echo $row_status['status'];
			mysql_free_result($status);
	  ?></td>
      <td class="fineprintplain"><?php echo number_format($row_calls['quote_amt'],2); ?></td>
      <td class="fineprintplain"><?php echo $row_calls['quote_no']; ?></td>
      <td class="fineprintplain"><?php if ($row_calls['invoiced'] == 1) { echo "YES"; } ?></td>
      <td class="fineprintplain"><?php echo $row_calls['invoice_no']; ?></td>
      <td class="fineprintplain"><?php echo number_format($row_calls['inv_amt'],2); ?></td>
      <td class="fineprintplain"><?php if ($row_calls['paid'] == 1) { echo "PD"; } ?></td>
      <td class="fineprintplain"><?php if ($row_calls['paiddate']) { echo date("d M Y", $row_calls['paiddate']); } ?></td>
      <td class="fineprintplain"><?php if ($row_calls['job_complete'] == 1) { echo "YES"; } ?></td>
      <td class="fineprintplain"><?php echo $row_calls['jobcard_no']; ?></td>
      <td class="fineprintplain"><?php echo $row_calls['ins_receipt_no']; ?></td>
      <td class="fineprintplain"><?php echo $row_calls['access_amt']; ?></td>
    </tr>
    <?php } while ($row_calls = mysql_fetch_assoc($calls)); ?>
</table>
<?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($calls);
?>
