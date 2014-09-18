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
<?php require_once('inc_before_acc.php'); ?>
<?php
mysql_select_db($database_adhocConn, $adhocConn);
$query_red = sprintf("SELECT * FROM call_log INNER JOIN addresses using (addressID) WHERE call_status = 6 AND invoice_no is null AND region = %s ORDER BY calltype ASC, logtime DESC", $myregionID);
$red = mysql_query($query_red, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_red = mysql_fetch_assoc($red);
$totalRows_red = mysql_num_rows($red);

mysql_select_db($database_adhocConn, $adhocConn);
$query_orange = sprintf("SELECT * FROM call_log INNER JOIN addresses using (addressID) WHERE call_status = 6 AND invoice_no is not null AND region = %s ORDER BY calltype ASC, logtime DESC", $myregionID);
$orange = mysql_query($query_orange, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_orange = mysql_fetch_assoc($orange);
$totalRows_orange = mysql_num_rows($orange);

mysql_select_db($database_adhocConn, $adhocConn);
$query_green = sprintf("SELECT * FROM call_log INNER JOIN addresses using (addressID) WHERE call_status = 7 AND region = %s ORDER BY calltype ASC, logtime DESC", $myregionID);
$green = mysql_query($query_green, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_green = mysql_fetch_assoc($green);
$totalRows_green = mysql_num_rows($green);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
				  <?php } ?></td>
                  <td bgcolor="#FCE0E0"><div align="center"><?php if ($row_red['job_no']) { echo $row_red['job_no']; } else { echo $row_red['logID']; } ?></div></td>
                  <td bgcolor="#FCE0E0" nowrap="nowrap"><div align="center"><?php echo date("d M Y", $logtime); ?></div></td>
                  <td bgcolor="#FCE0E0"><div align="center"><?php echo date("H:i", $logtime); ?></div></td>
                  <td bgcolor="#FCE0E0"><div align="left">&nbsp;&nbsp;<?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_red['addressID']);
						$address = mysql_query($query_address, $adhocConn) or die(mysql_error());
						$row_address = mysql_fetch_assoc($address);
						$totalRows_address = mysql_num_rows($address);
						if ($row_address['unitno']) {
							echo $row_address['unitno'] . " " . $row_address['complex'] . "<br>&nbsp;&nbsp;";
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
                  <td bgcolor="#FCE0E0" class="subtext" nowrap="nowrap"><div align="center" class="subtext"><a href="case_search.php?caseno=<?php echo $row_red['logID']; ?>"><img src="images/more.png" border="0" alt="MORE" title="MORE" hspace="1" /></a><a href="info.php?caseno=<?php echo $row_red['logID']; ?>" target="_blank"><img src="images/info.png" border="0" alt="INFO" title="INFO" hspace="1" /></a><a href="print_jobcard.php?caseno=<?php echo $row_red['logID']; ?>" target="_blank"><img src="images/jobcard.png" border="0" alt="JOBCARD" title="JOBCARD" hspace="1" /></a></div></td>
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
                  <td width="35">
				  <?php if ($logtime >= time() - 172800) { ?>
                  	<img src="design/amber.jpg" width="29" height="29" />
				  <?php } else { ?>
                  	<img src="design/amber.gif" width="29" height="29" />
				  <?php 
				  } ?></td>
                  <td bgcolor="#FFECCC"><div align="center"><?php if ($row_orange['job_no']) { echo $row_orange['job_no']; } else { echo $row_orange['logID']; } ?></div></td>
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
                  <td bgcolor="#FFECCC" class="subtext"><div align="center" class="subtext"><a href="case_search.php?caseno=<?php echo $row_orange['logID']; ?>"><img src="images/more.png" border="0" alt="MORE" title="MORE" hspace="1" /></a><a href="info.php?caseno=<?php echo $row_orange['logID']; ?>" target="_blank"><img src="images/info.png" border="0" alt="INFO" title="INFO" hspace="1" /></a><a href="print_jobcard.php?caseno=<?php echo $row_orange['logID']; ?>" target="_blank"><img src="images/jobcard.png" border="0" alt="JOBCARD" title="JOBCARD" hspace="1" /></a></div></td>
                </tr>
                  <?php } while ($row_orange = mysql_fetch_assoc($orange)); 
				  }
				  ?>
                <?php 
				/*if ($totalRows_green > 0) {
				do { 
				$logtime = $row_green['logtime'];
				?>
                  <tr>
                  <td width="35"><img src="design/green.jpg" width="29" height="29" /></td>
                  <td bgcolor="#CBF3CD"><div align="center"><?php if ($row_green['job_no']) { echo $row_green['job_no']; } else { echo $row_green['logID']; } ?></div></td>
                  <td bgcolor="#CBF3CD"><div align="center"><?php echo date("d M Y", $logtime); ?></div></td>
                  <td bgcolor="#CBF3CD"><div align="center"><?php echo date("H:i", $logtime); ?></div></td>
                  <td bgcolor="#CBF3CD"><div align="left"><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_client = sprintf("SELECT * FROM clients WHERE clientID = %s", $row_green['clientID']);
						$client = mysql_query($query_client, $adhocConn) or die(mysql_error());
						$row_client = mysql_fetch_assoc($client);
						$totalRows_client = mysql_num_rows($client);
						echo $row_client['cname'] . " " . $row_client['surname'];
						mysql_free_result($client);
				  ?></div></td>
                  <td bgcolor="#CBF3CD"><div align="center"><?php
				  	if ($row_green['location']) {
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_locs = sprintf("SELECT * FROM locations WHERE locationID = %s", $row_green['location']);
						$locs = mysql_query($query_locs, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
						$row_locs = mysql_fetch_assoc($locs);
						$totalRows_locs = mysql_num_rows($locs);
						echo strtoupper(substr($row_locs['location'],0,3));
						mysql_free_result($locs);
					}
				  ?></div></td>
                  <td bgcolor="#CBF3CD"><div align="left"><?php echo $row_green['condition']; ?></div></td>
                  <td bgcolor="#CBF3CD" class="subtext"><div align="center" class="subtext"><a href="case_search.php?caseno=<?php echo $row_green['logID']; ?>"><img src="images/more.png" border="0" alt="MORE" title="MORE" hspace="1" /></a><a href="info.php?caseno=<?php echo $row_green['logID']; ?>" target="_blank"><img src="images/info.png" border="0" alt="INFO" title="INFO" hspace="1" /></a><a href="print_jobcard.php?caseno=<?php echo $row_green['logID']; ?>" target="_blank"><img src="images/jobcard.png" border="0" alt="JOBCARD" title="JOBCARD" hspace="1" /></a></div></td>
                </tr>
                  <?php } while ($row_green = mysql_fetch_assoc($green)); 
				  }*/
				  ?>
            </table><?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($red);
mysql_free_result($orange);
mysql_free_result($green);
?>
