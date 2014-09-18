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

mysql_select_db($database_adhocConn, $adhocConn);
$query_quotes = sprintf("SELECT * FROM call_log WHERE quote_amt is not null AND logtime >= %s and logtime < %s ORDER BY logtime ASC", $settime, $nextmo);
$quotes = mysql_query($query_quotes, $adhocConn) or die(mysql_error());
$row_quotes = mysql_fetch_assoc($quotes);
$totalRows_quotes = mysql_num_rows($quotes);

?>
<?php require_once('inc_before.php'); ?>
  <p>Quotes Report</p>
  <table border="0" align="center" cellpadding="10" cellspacing="0">
    <tr>
      <td><div align="left"><a href="report_quotes.php?settime=<?php echo $prevmo; ?>" class="attention">previous month</a></div></td>
      <td><div align="center"><?php echo date("F Y", $settime); ?></div></td>
      <td><div align="right"><a href="report_quotes.php?settime=<?php echo $nextmo; ?>" class="attention">next month</a></div></td>
    </tr>
  </table>
  <p>
    <table border="1" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td>logID</td>
        <td>date</td>
        <td>caller</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <?php 
		$pendingtotal = 0;
		$apptotal = 0;
		$decltotal = 0;
		$exptotal = 0;
		$total = 0;
	  do { 
		  $total = $total + $row_quotes['quote_amt']; 
		  if (($row_quotes['call_status'] < 4) && ($row_quotes['logtime'] >= time()-2592000)) {
		  	$pendingtotal = $pendingtotal + $row_quotes['quote_amt']; 
			$class = "maintext";
		  }
		  if ($row_quotes['call_status'] >= 8) {
		  	$decltotal = $decltotal + $row_quotes['quote_amt']; 
			$class = "redtext2";
		  }
		  if (($row_quotes['logtime'] < time()-2592000) && ($row_quotes['call_status'] < 4)){
		  	$exptotal = $exptotal + $row_quotes['quote_amt']; 
			$class = "redtext2";
		  }
		  if (($row_quotes['call_status'] >= 4) && ($row_quotes['call_status'] < 8)) {
		  	$apptotal = $apptotal + $row_quotes['quote_amt']; 
			$class = "greentext";
		  }
	  ?>
        <tr>
          <td><?php echo $row_quotes['logID']; ?></td>
          <td><?php echo date("d/m", $row_quotes['logtime']); ?></td>
          <td><?php echo $row_quotes['caller']; ?></td>
          <td><?php echo $row_quotes['condition']; ?></td>
          <td><?php echo $row_quotes['quote_no']; ?></td>
          <td align="right" class="<?php echo $class; ?>"><?php echo $row_quotes['quote_amt']; ?></td>
          <td class="<?php echo $class; ?>"><?php
				mysql_select_db($database_adhocConn, $adhocConn);
				$query_status = sprintf("SELECT * FROM call_statuses WHERE statusID = %s", $row_quotes['call_status']);
				$status = mysql_query($query_status, $adhocConn) or die(mysql_error());
				$row_status = mysql_fetch_assoc($status);
				$totalRows_status = mysql_num_rows($status);
				echo $row_status['status'];
				mysql_free_result($status);
		  ?></td>
          <td><a href="case_search.php?caseno=<?php echo $row_quotes['logID']; ?>"><img src="images/more.png" border="0" alt="MORE" title="MORE" hspace="1" /></a><a href="info.php?caseno=<?php echo $row_quotes['logID']; ?>" target="_blank"><img src="images/info.png" border="0" alt="INFO" title="INFO" hspace="1" /></a><a href="print_jobcard.php?caseno=<?php echo $row_quotes['logID']; ?>" target="_blank"><img src="images/jobcard.png" border="0" alt="JOBCARD" title="JOBCARD" hspace="1" /></a></td>
        </tr>
        <?php } while ($row_quotes = mysql_fetch_assoc($quotes)); ?>
    </table>
  </p>
  <table border="1" align="center" cellpadding="3" cellspacing="0">
    <tr>
      <td>Total:</td>
      <td align="right"><?php echo number_format($total,2); ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Approved:</td>
      <td align="right"><?php echo number_format($apptotal,2); ?></td>
      <td><?php echo number_format(($apptotal / $total)*100,1); ?>%</td>
    </tr>
    <tr>
      <td>Pending:</td>
      <td align="right"><?php echo number_format($pendingtotal,2); ?></td>
      <td><?php echo number_format(($pendingtotal / $total)*100,1); ?>%</td>
    </tr>
    <tr>
      <td>Expired:</td>
      <td align="right"><?php echo number_format($exptotal,2); ?></td>
      <td><?php echo number_format(($exptotal / $total)*100,1); ?>%</td>
    </tr>
    <tr>
      <td>Declined:</td>
      <td align="right"><?php echo number_format($decltotal,2); ?></td>
      <td><?php echo number_format(($decltotal / $total)*100,1); ?>%</td>
    </tr>
  </table>
  <?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($quotes);
?>
