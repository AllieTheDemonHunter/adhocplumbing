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
?>
<?php require_once('inc_before.php'); ?>
<?php
mysql_select_db($database_adhocConn, $adhocConn);
$query_red = sprintf("SELECT * FROM call_log INNER JOIN addresses using (addressID) WHERE call_status = 1 AND region = %s ORDER BY calltype ASC, logtime DESC", $myregionID);
$red = mysql_query($query_red, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_red = mysql_fetch_assoc($red);
$totalRows_red = mysql_num_rows($red);

mysql_select_db($database_adhocConn, $adhocConn);
$query_orange = sprintf("SELECT * FROM call_log INNER JOIN addresses using (addressID) WHERE call_status = 3 AND region = %s ORDER BY calltype ASC, logtime DESC", $myregionID);
$orange = mysql_query($query_orange, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_orange = mysql_fetch_assoc($orange);
$totalRows_orange = mysql_num_rows($orange);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td bgcolor="#66FFFF" colspan="8" align="center" height="30">QUOTES</td>
	</tr>
                <?php 
				if ($totalRows_red > 0) {
				do { 
				$logtime = $row_red['logtime'];
				?>
                  <tr>
                  <td width="35">
				  <?php if ($logtime >= time() - 172800) { ?>
                  	<img src="design/red.jpg" width="29" height="29" />
				  <?php } else { ?>
                  	<img src="design/red.gif" width="29" height="29" />
				  <?php 
					if ($row_red['sms_sent'] == 0) {
						// send sms
						$msg = "ALERT: Quote not logged in allocated 48 hours: Case No " . $row_red['logID'] . ".";
						$cellno = 27764767111;
						// send otp
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, 'http://www.mymobileapi.com/api5/http5.aspx');
						curl_setopt ($ch, CURLOPT_POST, 1);
						$post_fields = "Type=sendparam&username=adhoc&password=admin1&numto=" . $cellno . "&data1=" . $msg;
						curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_fields);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$response_string = curl_exec($ch);
						curl_close($ch);
						// update call log
						$updateSQL = sprintf("UPDATE call_log SET sms_sent=1 WHERE logID=%s", $row_red['logID']);
						mysql_select_db($database_adhocConn, $adhocConn);
						$Result1 = mysql_query($updateSQL, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
					}
				  
				  } ?></td>
                  <td bgcolor="#FCE0E0"><div align="center"><?php echo $row_red['logID']; ?></div></td>
                  <td bgcolor="#FCE0E0"><div align="center"><?php echo date("d M Y", $logtime); ?></div></td>
                  <td bgcolor="#FCE0E0"><div align="center"><?php echo date("H:i", $logtime); ?></div></td>
                  <td bgcolor="#FCE0E0"><div align="left"><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_red['addressID']);
						$address = mysql_query($query_address, $adhocConn) or die(mysql_error());
						$row_address = mysql_fetch_assoc($address);
						$totalRows_address = mysql_num_rows($address);
						if ($row_address['unitno']) {
							echo $row_address['unitno'] . " " . $row_address['complex'] . "<br>";
						}
						echo $row_address['streetno'] . " " . $row_address['street'];
						mysql_free_result($address);
				  ?></div></td>
                  <td bgcolor="#FCE0E0"><div align="center"><?php
				  	if ($row_red['location']) {
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_locs = sprintf("SELECT * FROM locations WHERE locationID = %s", $row_red['location']);
						$locs = mysql_query($query_locs, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
						$row_locs = mysql_fetch_assoc($locs);
						$totalRows_locs = mysql_num_rows($locs);
						echo strtoupper(substr($row_locs['location'],0,3));
						mysql_free_result($locs);
					}
				  ?></div></td>
                  <td bgcolor="#FCE0E0"><div align="left"><?php echo $row_red['condition']; ?></div></td>
                  <td bgcolor="#FCE0E0" class="subtext"><div align="center" class="subtext"><a href="case_search.php?caseno=<?php echo $row_red['logID']; ?>">MORE</a></div></td>
                </tr>
                  <?php } while ($row_red = mysql_fetch_assoc($red)); 
				  }
				  ?>
                <?php 
				if ($totalRows_orange > 0) {
				do { 
				$logtime = $row_orange['logtime'];
				?>
                  <tr>
                  <td width="35"><img src="design/amber.jpg" width="29" height="29" /></td>
                  <td bgcolor="#FFECCC"><div align="center"><?php echo $row_orange['logID']; ?></div></td>
                  <td bgcolor="#FFECCC"><div align="center"><?php echo date("d M Y", $logtime); ?></div></td>
                  <td bgcolor="#FFECCC"><div align="center"><?php echo date("H:i", $logtime); ?></div></td>
                  <td bgcolor="#FFECCC"><div align="left"><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_orange['addressID']);
						$address = mysql_query($query_address, $adhocConn) or die(mysql_error());
						$row_address = mysql_fetch_assoc($address);
						$totalRows_address = mysql_num_rows($address);
						if ($row_address['unitno']) {
							echo $row_address['unitno'] . " " . $row_address['complex'] . "<br>";
						}
						echo $row_address['streetno'] . " " . $row_address['street'];
						mysql_free_result($address);
				  ?></div></td>
                  <td bgcolor="#FFECCC"><div align="center"><?php
				  	if ($row_orange['location']) {
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_locs = sprintf("SELECT * FROM locations WHERE locationID = %s", $row_orange['location']);
						$locs = mysql_query($query_locs, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
						$row_locs = mysql_fetch_assoc($locs);
						$totalRows_locs = mysql_num_rows($locs);
						echo strtoupper(substr($row_locs['location'],0,3));
						mysql_free_result($locs);
					}
				  ?></div></td>
                  <td bgcolor="#FFECCC"><div align="left"><?php echo $row_orange['condition']; ?></div></td>
                  <td bgcolor="#FFECCC" class="subtext"><div align="center" class="subtext"><a href="case_search.php?caseno=<?php echo $row_orange['logID']; ?>">MORE</a></div></td>
                </tr>
                  <?php } while ($row_orange = mysql_fetch_assoc($orange)); 
				  }
				  ?>
            </table><?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($red);
mysql_free_result($orange);
mysql_free_result($green);
?>
