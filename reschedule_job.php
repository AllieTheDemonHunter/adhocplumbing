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

if ($_COOKIE['MM_UserGroup'] >= 4) {
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "logcall")) {
		$sdate = mktime($_POST['sd_h'],$_POST['sd_i'],0,$_POST['sd_m'],$_POST['sd_d'],$_POST['sd_y']);
		$updateSQL = sprintf("UPDATE call_log SET est_fin_time=%s, logtime=%s, call_status=4, resched_reason=%s WHERE logID=%s",
						   GetSQLValueString(time()-1, "int"),
						   GetSQLValueString($sdate, "int"),
						   GetSQLValueString($_POST['reason'], "int"),
						   GetSQLValueString($_POST['logID'], "int"));
	
		mysql_select_db($database_adhocConn, $adhocConn);
		$Result1 = mysql_query($updateSQL, $adhocConn) or die(__LINE__.mysql_error());
		
		$updateSQL = sprintf("UPDATE crews SET booked_until=%s WHERE crewID=%s",
						   GetSQLValueString(time()-1, "int"),
						   GetSQLValueString($_POST['c1'], "int"));
		
		mysql_select_db($database_adhocConn, $adhocConn);
		$Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());
	  
		$updateSQL = sprintf("UPDATE crews SET booked_until=%s WHERE crewID=%s",
						   GetSQLValueString(time()-1, "int"),
						   GetSQLValueString($_POST['c2'], "int"));
		
		mysql_select_db($database_adhocConn, $adhocConn);
		$Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());
	  
		$updateSQL = sprintf("UPDATE vehicles SET booked_until=%s WHERE vehicleID=%s",
						   GetSQLValueString(time()-1, "int"),
						   GetSQLValueString($_POST['v1'], "int"));
		
		mysql_select_db($database_adhocConn, $adhocConn);
		$Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());
		$insertGoTo = "control_panel_jobs.php";
		header(sprintf("Location: %s", $insertGoTo));
	}
}

mysql_select_db($database_adhocConn, $adhocConn);
$query_notes = sprintf("SELECT * FROM comments WHERE callID = %s ORDER BY logtime ASC", $_GET['logID']);
$notes = mysql_query($query_notes, $adhocConn) or die(mysql_error());
$row_notes = mysql_fetch_assoc($notes);
$totalRows_notes = mysql_num_rows($notes);

mysql_select_db($database_adhocConn, $adhocConn);
$query_case = sprintf("SELECT * FROM call_log INNER JOIN clients using (clientID) WHERE logID = %s", $_GET['logID']);
$case = mysql_query($query_case, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_case = mysql_fetch_assoc($case);
$totalRows_case = mysql_num_rows($case);

if (!($_COOKIE['MM_UserGroup'])) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>

<?php require_once('inc_before.php'); ?>
              <p class="logbutton">Case Number <?php echo $colname_case; ?></p>
              <blockquote>
                <?php if ($totalRows_case > 0) { // Show if recordset not empty ?>
                  <table width="100%" border="1" cellspacing="0" cellpadding="5">
                    <tr>
                      <td class="maintext">Logged</td>
                      <td><?php echo date("d M Y H:i", $row_case['logtime']); ?>                      </td>
                    </tr>
                    <tr>
                      <td>Contact Person</td>
                      <td><?php echo $row_case['caller']; ?></td>
                    </tr>
                    <tr>
                      <td>Contact No</td>
                      <td><?php echo $row_case['telno1']; ?></td>
                    </tr>
                    <tr>
                      <td>Dispatcher</td>
                      <td><?php if ($row_case['dispatcher']) {
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_disp = sprintf("SELECT * FROM users WHERE userID = %s", $row_case['dispatcher']);
							$disp = mysql_query($query_disp, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
							$row_disp = mysql_fetch_assoc($disp);
							$totalRows_disp = mysql_num_rows($disp);
							echo $row_disp['uname'];
							mysql_free_result($disp);
							}
					  ?></td>
                    </tr>
                    <tr>
                      <td>Address</td>
                      <td><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_case['addressID']);
						$address = mysql_query($query_address, $adhocConn) or die(mysql_error());
						$row_address = mysql_fetch_assoc($address);
						$totalRows_address = mysql_num_rows($address);
						if ($row_address['unitno']) {
							echo $row_address['unitno'] . " " . $row_address['complex'] . "<br>";
						}
						echo $row_address['streetno'] . " " . $row_address['street'] . "<br>";
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_suburb = sprintf("SELECT * FROM suburbs WHERE suburbID = %s", $row_address['suburb']);
						$suburb = mysql_query($query_suburb, $adhocConn) or die(mysql_error());
						$row_suburb = mysql_fetch_assoc($suburb);
						$totalRows_suburb = mysql_num_rows($suburb);
						echo $row_suburb['suburb'];
						mysql_free_result($suburb);
						mysql_free_result($address);
					  ?></td>
                    </tr>
                    <tr>
                      <td>Nature</td>
                      <td><?php echo $row_case['condition']; ?></td>
                    </tr>
                    <tr>
                      <td>Call Status</td>
                      <td><?php
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_status = sprintf("SELECT * FROM call_statuses WHERE statusID = %s", $row_case['call_status']);
							$status = mysql_query($query_status, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
							$row_status = mysql_fetch_assoc($status);
							$totalRows_status = mysql_num_rows($status);
							echo $row_status['status'];
							mysql_free_result($status);
					  ?></td>
                    </tr>
                    <tr>
                      <td>Category</td>
                      <td><?php
					  	if ($row_case['category']) {
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_category = sprintf("SELECT * FROM categories WHERE catID = %s", $row_case['category']);
							$category = mysql_query($query_category, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
							$row_category = mysql_fetch_assoc($category);
							$totalRows_category = mysql_num_rows($category);
							echo $row_category['category'];
							mysql_free_result($category);
						}
					  ?></td>
                    </tr>
                    <tr>
                      <td valign="top">Notes</td>
                      <td><?php 
					  if ($totalRows_notes > 0) {
					    do { ?>
                          <span class="smalltext"><?php
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_logger = sprintf("SELECT * FROM users WHERE userID = %s", $row_notes['logged_by']);
							$logger = mysql_query($query_logger, $adhocConn) or die(mysql_error());
							$row_logger = mysql_fetch_assoc($logger);
							$totalRows_logger = mysql_num_rows($logger);
							echo $row_logger['uname'];
							mysql_free_result($logger);
						  ?> (<?php echo date("d M Y H:i", $row_notes['logtime']); 
						  ?>):</span> <span class="smalltext"><?php echo $row_notes['comment']; ?></span><br />
                          <?php } while ($row_notes = mysql_fetch_assoc($notes)); 
					  } ?>                      </td>
                    </tr>
            <tr>
              <td>Reschedule Job:</td>
              <td><?php 
			$sd = getdate(time()+(60*60*24)); 
			$sd_d = $sd[mday];
			$sd_m = $sd[mon];
			$sd_y = $sd[year];
			$sd_h = 8;
			$sd_i = $sd[minutes];
			?>
          <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
            <p>
              <select name="sd_d" class="maintext" id="sd_d">
                <option <?php if ($sd_d == 1) { echo "SELECTED"; } ?>>1</option>
                <option <?php if ($sd_d == 2) { echo "SELECTED"; } ?>>2</option>
                <option <?php if ($sd_d == 3) { echo "SELECTED"; } ?>>3</option>
                <option <?php if ($sd_d == 4) { echo "SELECTED"; } ?>>4</option>
                <option <?php if ($sd_d == 5) { echo "SELECTED"; } ?>>5</option>
                <option <?php if ($sd_d == 6) { echo "SELECTED"; } ?>>6</option>
                <option <?php if ($sd_d == 7) { echo "SELECTED"; } ?>>7</option>
                <option <?php if ($sd_d == 8) { echo "SELECTED"; } ?>>8</option>
                <option <?php if ($sd_d == 9) { echo "SELECTED"; } ?>>9</option>
                <option <?php if ($sd_d == 10) { echo "SELECTED"; } ?>>10</option>
                <option <?php if ($sd_d == 11) { echo "SELECTED"; } ?>>11</option>
                <option <?php if ($sd_d == 12) { echo "SELECTED"; } ?>>12</option>
                <option <?php if ($sd_d == 13) { echo "SELECTED"; } ?>>13</option>
                <option <?php if ($sd_d == 14) { echo "SELECTED"; } ?>>14</option>
                <option <?php if ($sd_d == 15) { echo "SELECTED"; } ?>>15</option>
                <option <?php if ($sd_d == 16) { echo "SELECTED"; } ?>>16</option>
                <option <?php if ($sd_d == 17) { echo "SELECTED"; } ?>>17</option>
                <option <?php if ($sd_d == 18) { echo "SELECTED"; } ?>>18</option>
                <option <?php if ($sd_d == 19) { echo "SELECTED"; } ?>>19</option>
                <option <?php if ($sd_d == 20) { echo "SELECTED"; } ?>>20</option>
                <option <?php if ($sd_d == 21) { echo "SELECTED"; } ?>>21</option>
                <option <?php if ($sd_d == 22) { echo "SELECTED"; } ?>>22</option>
                <option <?php if ($sd_d == 23) { echo "SELECTED"; } ?>>23</option>
                <option <?php if ($sd_d == 24) { echo "SELECTED"; } ?>>24</option>
                <option <?php if ($sd_d == 25) { echo "SELECTED"; } ?>>25</option>
                <option <?php if ($sd_d == 26) { echo "SELECTED"; } ?>>26</option>
                <option <?php if ($sd_d == 27) { echo "SELECTED"; } ?>>27</option>
                <option <?php if ($sd_d == 28) { echo "SELECTED"; } ?>>28</option>
                <option <?php if ($sd_d == 29) { echo "SELECTED"; } ?>>29</option>
                <option <?php if ($sd_d == 30) { echo "SELECTED"; } ?>>30</option>
                <option <?php if ($sd_d == 31) { echo "SELECTED"; } ?>>31</option>
              </select>
              <select name="sd_m" class="maintext" id="sd_m">
                <option <?php if ($sd_m == 1) { echo "SELECTED"; } ?> value="1">January</option>
                <option <?php if ($sd_m == 2) { echo "SELECTED"; } ?> value="2">February</option>
                <option <?php if ($sd_m == 3) { echo "SELECTED"; } ?> value="3">March</option>
                <option <?php if ($sd_m == 4) { echo "SELECTED"; } ?> value="4">April</option>
                <option <?php if ($sd_m == 5) { echo "SELECTED"; } ?> value="5">May</option>
                <option <?php if ($sd_m == 6) { echo "SELECTED"; } ?> value="6">June</option>
                <option <?php if ($sd_m == 7) { echo "SELECTED"; } ?> value="7">July</option>
                <option <?php if ($sd_m == 8) { echo "SELECTED"; } ?> value="8">August</option>
                <option <?php if ($sd_m == 9) { echo "SELECTED"; } ?> value="9">September</option>
                <option <?php if ($sd_m == 10) { echo "SELECTED"; } ?> value="10">October</option>
                <option <?php if ($sd_m == 11) { echo "SELECTED"; } ?> value="11">November</option>
                <option <?php if ($sd_m == 12) { echo "SELECTED"; } ?> value="12">December</option>
                </select>
                <select name="sd_y" class="maintext" id="sd_y">
                  <option <?php if ($sd_y == "2012") {echo "SELECTED";} ?>>2012</option>
                  <option <?php if ($sd_y == "2013") {echo "SELECTED";} ?>>2013</option>
                  <option <?php if ($sd_y == "2014") {echo "SELECTED";} ?>>2014</option>
                  </select>
              at
              <select name="sd_h" class="maintext" id="sd_h">
                <option <?php if ($sd_h == 0) { echo "SELECTED"; } ?>>0</option>
                <option <?php if ($sd_h == 1) { echo "SELECTED"; } ?>>1</option>
                <option <?php if ($sd_h == 2) { echo "SELECTED"; } ?>>2</option>
                <option <?php if ($sd_h == 3) { echo "SELECTED"; } ?>>3</option>
                <option <?php if ($sd_h == 4) { echo "SELECTED"; } ?>>4</option>
                <option <?php if ($sd_h == 5) { echo "SELECTED"; } ?>>5</option>
                <option <?php if ($sd_h == 6) { echo "SELECTED"; } ?>>6</option>
                <option <?php if ($sd_h == 7) { echo "SELECTED"; } ?>>7</option>
                <option <?php if ($sd_h == 8) { echo "SELECTED"; } ?>>8</option>
                <option <?php if ($sd_h == 9) { echo "SELECTED"; } ?>>9</option>
                <option <?php if ($sd_h == 10) { echo "SELECTED"; } ?>>10</option>
                <option <?php if ($sd_h == 11) { echo "SELECTED"; } ?>>11</option>
                <option <?php if ($sd_h == 12) { echo "SELECTED"; } ?>>12</option>
                <option <?php if ($sd_h == 13) { echo "SELECTED"; } ?>>13</option>
                <option <?php if ($sd_h == 14) { echo "SELECTED"; } ?>>14</option>
                <option <?php if ($sd_h == 15) { echo "SELECTED"; } ?>>15</option>
                <option <?php if ($sd_h == 16) { echo "SELECTED"; } ?>>16</option>
                <option <?php if ($sd_h == 17) { echo "SELECTED"; } ?>>17</option>
                <option <?php if ($sd_h == 18) { echo "SELECTED"; } ?>>18</option>
                <option <?php if ($sd_h == 19) { echo "SELECTED"; } ?>>19</option>
                <option <?php if ($sd_h == 20) { echo "SELECTED"; } ?>>20</option>
                <option <?php if ($sd_h == 21) { echo "SELECTED"; } ?>>21</option>
                <option <?php if ($sd_h == 22) { echo "SELECTED"; } ?>>22</option>
                <option <?php if ($sd_h == 23) { echo "SELECTED"; } ?>>23</option>
              </select>
              :
              <input name="sd_i" type="text" size="2" maxlength="2" class="maintext" value="00" />
              <input type="hidden" name="MM_update" value="logcall" />
              <input name="logID" type="hidden" id="logID" value="<?php echo $_GET['logID']; ?>" />
              <input name="c1" type="hidden" id="c1" value="<?php echo $_GET['c1']; ?>" />
              <input name="c2" type="hidden" id="c2" value="<?php echo $_GET['c2']; ?>" />
              <input name="v1" type="hidden" id="v1" value="<?php echo $_GET['v1']; ?>" />
              <br />
              Reason:
              <input name="reason" type="text" class="maintext" id="reason" size="40" />
            </p>
            <p>
              <input name="button" type="submit" class="maintext" id="button" value="Submit" />
              </p>
          </form>          </td>
            </tr>
                  </table>
                  <?php } // Show if recordset not empty ?>
</blockquote>              
              
              <?php if ($totalRows_case == 0) { // Show if recordset empty ?>
                <p align="center">Case number not found. Please try again.</p>
                <?php } // Show if recordset empty ?>
              <?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($notes);
?>

</body>
</html>
<?php
mysql_free_result($case);
?>
