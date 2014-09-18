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

mysql_select_db($database_adhocConn, $adhocConn);
$query_my_region = sprintf("SELECT * FROM users WHERE userID = %s", $_COOKIE['MM_userID']);
$my_region = mysql_query($query_my_region, $adhocConn) or die(mysql_error());
$row_my_region = mysql_fetch_assoc($my_region);
$totalRows_my_region = mysql_num_rows($my_region);
$myregionID = $row_my_region['region'];

mysql_free_result($my_region);

mysql_select_db($database_adhocConn, $adhocConn);
$query_c_out = sprintf("SELECT * FROM crews WHERE booked_until > %s and crew is not null and regionID = %s ORDER BY crew ASC", time(), $myregionID);
$c_out = mysql_query($query_c_out, $adhocConn) or die(mysql_error());
$row_c_out = mysql_fetch_assoc($c_out);
$totalRows_c_out = mysql_num_rows($c_out);

mysql_select_db($database_adhocConn, $adhocConn);
$query_c_in = sprintf("SELECT * FROM crews WHERE booked_until < %s and crew is not null and regionID = %s ORDER BY crew ASC", time(), $myregionID);
$c_in = mysql_query($query_c_in, $adhocConn) or die(mysql_error());
$row_c_in = mysql_fetch_assoc($c_in);
$totalRows_c_in = mysql_num_rows($c_in);

?>
<?php require_once('inc_before.php'); ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="10">
                <tr>
                  <td rowspan="2" valign="top">Maintenance
                    <ul>
                      <li><a href="users.php">Users</a></li>
                      <li><a href="clients.php">Clients</a></li>
                      <li><a href="vehicles.php">Vehicles</a></li>
                      <li><a href="crews.php">Crew</a></li>
                      <li><a href="all_regions.php">All Regions</a></li>
                      <li><a href="subregions.php">Subregions</a></li>
                      <li><a href="insurance_companies.php">Insurance companies</a></li>
                      <li><a href="categories.php">Categories</a></li>
                      <li><a href="declined_quotes.php">Declined Quotes</a></li>
                      <li><a href="expired_quotes.php">Expired Quotes</a></li>
                      <li><a href="control_screen_jobs.php" target="_blank" class="greentext">CONTROL SCREEN</a></li>
                      <li><a href="report_quotes.php" class="redtext">Quotes Report</a></li>
                      <li><a href="monthly_detail_report.php" class="redtext">Jobs Report</a></li>
                  </ul></td>
                  <td valign="top">Crew Out
                        <table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#E3E4E8">
                        <tr>
                              <td class="fineprint">Crew</td>
                              <td class="fineprint">Job</td>
                              <td class="fineprint"><div align="right">Out Until</div></td>
                        </tr>
                            <?php 
							if ($totalRows_c_out > 0) {
							do { ?>
                          <tr>
                              <td class="fineprint"><?php echo $row_c_out['crew']; ?></td>
                              <td class="fineprint"><?php
									mysql_select_db($database_adhocConn, $adhocConn);
									$query_on_job = sprintf("SELECT * FROM call_log left join addresses using (addressID) left join suburbs on addresses.suburb = suburbs.suburbID left join subregions on suburbs.subregion = subregions.subID WHERE v1crew1 = %s OR v1crew2 = %s ORDER BY est_fin_time DESC", $row_c_out['crewID'], $row_c_out['crewID']);
									$on_job = mysql_query($query_on_job, $adhocConn) or die(mysql_error());
									$row_on_job = mysql_fetch_assoc($on_job);
									$totalRows_on_job = mysql_num_rows($on_job);
							  ?><a href="case_search.php?caseno=<?php echo $row_on_job['logID']; ?>"><?php echo $row_on_job['logID']; ?> - <?php echo $row_on_job['subregion']; ?></a>
                              <?php 
									mysql_free_result($on_job);
							  ?></td>
                              <td class="fineprint"><div align="right"><?php echo date("H:i", $row_c_out['booked_until']); ?></div></td>
                          </tr>
                              <?php } while ($row_c_out = mysql_fetch_assoc($c_out)); 
							} ?>
                  </table>                  </td>
                </tr>
                <tr>
                  <td valign="top">Crew In
                    <table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#E3E4E8">
                      <tr>
                        <td class="fineprint">Crew</td>
                          <td class="fineprint">Area</td>
                        <td class="fineprint"><div align="right">In Since</div></td>
                      </tr>
                      <?php 
							if ($totalRows_c_in > 0) {
							do { ?>
                      <tr>
                        <td class="fineprint"><?php echo $row_c_in['crew']; ?></td>
                          <td class="fineprint"><?php
								$sd = getdate(time()); 
								$sd_d = $sd[mday];
								$sd_m = $sd[mon];
								$sd_y = $sd[year];
								$sdate = mktime(7,0,0,$sd_m,$sd_d,$sd_y);
								
                                mysql_select_db($database_adhocConn, $adhocConn);
                                $query_on_job = sprintf("SELECT * FROM call_log left join addresses using (addressID) left join suburbs on addresses.suburb = suburbs.suburbID left join subregions on suburbs.subregion = subregions.subID WHERE (v1crew1 = %s OR v1crew2 = %s) AND est_fin_time > %s ORDER BY est_fin_time DESC", $row_c_in['crewID'], $row_c_in['crewID'], $sdate);
                                $on_job = mysql_query($query_on_job, $adhocConn) or die(mysql_error());
                                $row_on_job = mysql_fetch_assoc($on_job);
                                $totalRows_on_job = mysql_num_rows($on_job);
								if ($totalRows_on_job > 0) {
                          ?><?php echo $row_on_job['subregion']; ?>
                          <?php }
                                mysql_free_result($on_job);
                          ?></td>
                        <td class="fineprint"><div align="right"><?php echo date("d M H:i", $row_c_in['booked_until']); ?></div></td>
                      </tr>
                      <?php } while ($row_c_in = mysql_fetch_assoc($c_in)); 
							} ?>
                    </table></td>
                </tr>
              </table>
  
 <?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($c_out);
mysql_free_result($c_in);
?>