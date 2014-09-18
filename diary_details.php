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

$ssd = getdate($settime+(86400*($dateoutput-1))); 
$ssd_d = $ssd[mday];
$ssd_m = $ssd[mon];
$ssd_y = $ssd[year];
$today = $_GET['startdate'];

$realtoday = getdate(time()); 
$realtoday_d = $realtoday[mday];
$realtoday_m = $realtoday[mon];
$realtoday_y = $realtoday[year];
$realtoday = mktime(0,0,0,$realtoday_m,$realtoday_d,$realtoday_y);

mysql_select_db($database_adhocConn, $adhocConn);
$query_diary = sprintf("SELECT * FROM call_log WHERE (diary = 1 and logtime > %s and logtime < %s) OR (logtime > %s and logtime > %s and logtime < %s) ORDER BY logtime ASC", $today, $today + 86400, $realtoday, $today, $today + 86400);
$diary = mysql_query($query_diary, $adhocConn) or die(mysql_error());
$row_diary = mysql_fetch_assoc($diary);
$totalRows_diary = mysql_num_rows($diary);
?>
<?php require_once('inc_before.php'); ?>
              <p><blockquote>Diary            </blockquote></p>
              
              <div align="center">
                <?php if ($totalRows_diary > 0) { // Show if recordset not empty ?>
                <table border="1" cellpadding="3" cellspacing="0">
                  <tr>
                    <td>date &amp; time</td>
                    <td>caller</td>
                    <td>tel no</td>
                    <td>address</td>
                    <td>client</td>
                    <td>location</td>
                    <td>notes</td>
                    <td>-</td>
                  </tr>
                  <?php do { ?>
                      <tr>
                        <td valign="top"><?php echo date("d M Y H:i", $row_diary['logtime']); ?></td>
                        <td valign="top"><?php echo $row_diary['caller']; ?></td>
                        <td valign="top"><?php echo $row_diary['telno1']; ?></td>
                        <td valign="top"><?php
						if ($row_diary['addressID']) {
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_diary['addressID']);
							$address = mysql_query($query_address, $adhocConn) or die(mysql_error());
							$row_address = mysql_fetch_assoc($address);
							$totalRows_address = mysql_num_rows($address);
							if ($row_address['unitno']) {
								echo $row_address['unitno'] . " " . $row_address['complex'] . "<br>";
							}
							echo $row_address['streetno'] . " " . $row_address['street'] . ", " . $row_address['suburb'];
							mysql_free_result($address);
						}
						?></td>
                        <td valign="top"><?php
						if ($row_diary['clientID']) {
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_client = sprintf("SELECT * FROM clients WHERE clientID = %s", $row_diary['clientID']);
							$client = mysql_query($query_client, $adhocConn) or die(mysql_error());
							$row_client = mysql_fetch_assoc($client);
							$totalRows_client = mysql_num_rows($client);
							echo $row_client['cname'] . " " . $row_client['surname'] . "<br>";
							echo $row_client['telno'];
							mysql_free_result($client);
						}
						?></td>
                        <td valign="top"><?php echo $row_diary['location']; ?></td>
                        <td valign="top"><?php echo $row_diary['notes']; ?></td>
                        <td valign="top" class="subtext"><div align="center" class="subtext"><a href="case_search.php?caseno=<?php echo $row_diary['logID']; ?>"><img src="images/more.png" border="0" alt="MORE" title="MORE" hspace="1" /></a><a href="info.php?caseno=<?php echo $row_diary['logID']; ?>" target="_blank"><img src="images/info.png" border="0" alt="INFO" title="INFO" hspace="1" /></a><a href="print_jobcard.php?caseno=<?php echo $row_diary['logID']; ?>" target="_blank"><img src="images/jobcard.png" border="0" alt="JOBCARD" title="JOBCARD" hspace="1" /></a></div></td>
                      </tr>
                      <?php } while ($row_diary = mysql_fetch_assoc($diary)); ?>
                </table>
				<?php } // Show if recordset not empty ?>
              </div>
                <?php if ($totalRows_diary == 0) { // Show if recordset empty ?>
                    <p align="center">No records found</p>
                <?php } // Show if recordset empty ?>
                    <p align="center"><a href="diary.php">Back to Diary</a></p>
                
                
                    
          <?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($diary);
?>
