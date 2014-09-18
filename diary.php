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

?>
<?php require_once('inc_before.php'); ?>
              <p><blockquote>Diary            </blockquote></p>
              
              <div align="center">
                <?php
				mysql_select_db($database_adhocConn, $adhocConn);
				$query_diary = sprintf("SELECT * FROM call_log INNER JOIN addresses using (addressID) WHERE diary = 1 and logtime > %s and logtime < %s AND region = %s ORDER BY logtime ASC", time(), time() + 86400, $myregionID);
				$diary = mysql_query($query_diary, $adhocConn) or die(mysql_error());
				$row_diary = mysql_fetch_assoc($diary);
				$totalRows_diary = mysql_num_rows($diary);
				 if ($totalRows_diary > 0) { // Show if recordset not empty ?>
                <table border="1" cellpadding="3" cellspacing="0">
                  <tr>
                    <td>date &amp; time</td>
                    <td>caller</td>
                    <td>tel no</td>
                    <td>address</td>
                    <td>client</td>
                    <td>location</td>
                    <td>notes</td>
                    <td>&nbsp;</td>
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
                        <td valign="top"><a href="mark_as_read.php?logID=<?php echo $row_diary['logID']; ?>">mark as read</a></td>
                      </tr>
                      <?php } while ($row_diary = mysql_fetch_assoc($diary)); ?>
                </table>
				<?php } // Show if recordset not empty ?>
                </div>
                <?php if ($totalRows_diary == 0) { // Show if recordset empty ?>
                    <p align="center">No records found</p>
                <?php } // Show if recordset empty ?>
                
                
                <?php 
						if ($_GET['amonth']) { $amonth = $_GET['amonth']; } else { $amonth = date("m",time()); }
						if ($_GET['ayear']) { $ayear = $_GET['ayear']; } else { $ayear = date("Y",time()); }
						$firstmonth = mktime(0,0,0,$amonth,1,$ayear);
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

					    $firstday = date("N", $settime-(86400*(date("d",$settime)-1)));
					    $dateoutput = 1 - $firstday;
					    $counter = 0;
						
						?>
                        <table border="0" align="center" cellpadding="10" cellspacing="0">
                          <tr>
                            <td valign="top"><table  border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="150" height="30" align="left"><a href="diary.php?settime=<?php echo $prevmo; ?>" class="attention">previous month</a></td>
                        <td align="center" class="subheader"><?php echo date("F Y", $settime); ?></td>
                        <td width="150" align="right"><a href="diary.php?settime=<?php echo $nextmo; ?>" class="attention">next month</a></td>
                      </tr>
      </table>
	  					      <table border="1" cellspacing="0" cellpadding="5" align="center">
					  <tr><td align="center" class="subheader" bgcolor="#94BEBA">S</td><td align="center" class="subheader">M</td><td align="center" class="subheader">T</td><td align="center" class="subheader">W</td>
					  <td align="center" class="subheader">T</td><td align="center" class="subheader">F</td><td align="center" class="subheader" bgcolor="#BBD7D3">S</td></tr><tr>
						<?php 

						$td = getdate(time()); 
						$td_y = $td[year];
						$increasedate = mktime(0,0,0,1,16,$td_y+1);
						$realtoday = getdate(time()); 
						$realtoday_d = $realtoday[mday];
						$realtoday_m = $realtoday[mon];
						$realtoday_y = $realtoday[year];
						$realtoday = mktime(0,0,0,$realtoday_m,$realtoday_d,$realtoday_y);
						do {
							if ($dateoutput > 0) {
								$ssd = getdate($settime+(86400*($dateoutput-1))); 
								$ssd_d = $ssd[mday];
								$ssd_m = $ssd[mon];
								$ssd_y = $ssd[year];
								$today = mktime(0,0,0,$ssd_m,$ssd_d,$ssd_y);
								$yearsdiff = floor(($today - $increasedate) / 31536000);
								$bgcolor = "#FFFFFF";
								$specialstatus = 2;
								mysql_select_db($database_adhocConn, $adhocConn);
								$query_diary = sprintf("SELECT * FROM call_log WHERE (diary = 1 and logtime > %s and logtime < %s) OR (logtime > %s and logtime > %s and logtime < %s) ORDER BY logtime ASC", $today, $today + 86400, $realtoday, $today, $today + 86400);
								$diary = mysql_query($query_diary, $adhocConn) or die(mysql_error());
								$row_diary = mysql_fetch_assoc($diary);
								$totalRows_diary = mysql_num_rows($diary);
								$linkflag = 0;
								$bgcolor = "#FFFFFF"; 
								if ($counter == 0) { 
									$bgcolor = "#94BEBA"; 
								}
								if ($counter == 6) { 
									$bgcolor = "#BBD7D3"; 
								}
								if ($totalRows_diary > 0) {
									$bgcolor = "#FFFF00"; 
									$linkflag = 1;
								}
								mysql_free_result($diary);
								if ($linkflag == 1) {
									?>
									<td bgcolor="<?php echo $bgcolor; ?>" align="center" class="subheader" width="40"><a href="diary_details.php?startdate=<?php echo $today; ?>"><?php echo $dateoutput; ?></a></td>
									<?php
								} else {
									?>
									<td bgcolor="<?php echo $bgcolor; ?>" align="center" class="subheader" width="40"><?php echo $dateoutput; ?></td>
									<?php
								}
							} else {
								?>
								<td class="subheader"><div align="center"></div></td>
                                <?php
							}
							$counter++;
							if ($counter == 7) {
								echo "</tr><tr>";
								$counter = 0;
							}
							$dateoutput++;
						} while ($dateoutput<=date("t", $settime));
						?>
					  </tr>
					</table>
                    
          <?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($diary);
?>
