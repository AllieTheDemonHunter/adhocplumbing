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

if ($_COOKIE['MM_UserGroup'] < 5) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
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
$query_primary = sprintf("SELECT casename FROM call_log WHERE logtime > %s AND logtime < %s AND `condition` = 'Medical' AND calltype = 1", $settime, $nextmo);
$primary = mysql_query($query_primary, $adhocConn) or die(mysql_error());
$row_primary = mysql_fetch_assoc($primary);
$totalRows_primary = mysql_num_rows($primary);

mysql_select_db($database_adhocConn, $adhocConn);
$query_transfer = sprintf("SELECT casename FROM call_log WHERE logtime > %s AND logtime < %s AND `condition` = 'Trauma' AND calltype = 1", $settime, $nextmo);
$transfer = mysql_query($query_transfer, $adhocConn) or die(mysql_error());
$row_transfer = mysql_fetch_assoc($transfer);
$totalRows_transfer = mysql_num_rows($transfer);
?>

<?php require_once('inc_before.php'); ?>
              <p>Medical / Trauma Summary</p>
              <table border="0" align="center" cellpadding="10" cellspacing="0">
                <tr>
                  <td><div align="left"><a href="report_med_trauma.php?settime=<?php echo $prevmo; ?>" class="attention">previous month</a></div></td>
                  <td><div align="center"><?php echo date("F Y", $settime); ?></div></td>
                  <td><div align="right"><a href="report_med_trauma.php?settime=<?php echo $nextmo; ?>" class="attention">next month</a></div></td>
                </tr>
              </table>
              <br />
              <table border="0" align="center" cellpadding="5" cellspacing="0">
                <tr>
                  <td><div align="right">Medical:</div></td>
                  <td><div align="left"><?php echo $totalRows_primary; ?></div></td>
                  </tr>
                <tr>
                  <td><div align="right">Trauma:</div></td>
                  <td><div align="left"><?php echo $totalRows_transfer; ?></div></td>
                  </tr>
              </table>
              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($primary);
mysql_free_result($transfer);
?>
