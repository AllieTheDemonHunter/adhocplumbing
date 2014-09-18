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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO comments (callID, logtime, logged_by, `comment`) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['callID'], "int"),
                       GetSQLValueString($_POST['logtime'], "int"),
                       GetSQLValueString($_POST['logged_by'], "int"),
                       GetSQLValueString($_POST['comment'], "text"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($insertSQL, $adhocConn) or die(mysql_error());

  $insertGoTo = "despatch_vehicle.php?caseno=" . $_POST['callID'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
	mysql_select_db($database_adhocConn, $adhocConn);
	$query_nature = sprintf("SELECT * FROM nature_of_call WHERE nature = '%s'", $_POST['condition']);
	$nature = mysql_query($query_nature, $adhocConn) or die(mysql_error());
	$row_nature = mysql_fetch_assoc($nature);
	$totalRows_nature = mysql_num_rows($nature);
	$timereqd = $row_nature['timereqd'];
	mysql_free_result($nature);
	
	mysql_select_db($database_adhocConn, $adhocConn);
	$query_crew_out = sprintf("SELECT * FROM crews WHERE crewID = %s", $_POST['crew1']);
	$crew_out = mysql_query($query_crew_out, $adhocConn) or die(mysql_error());
	$row_crew_out = mysql_fetch_assoc($crew_out);
	$totalRows_crew_out = mysql_num_rows($crew_out);
	$out_until = $row_crew_out['booked_until'];
	mysql_free_result($crew_out);

	if ($out_until < time()) {
		$bookeduntil = time() + $timereqd;
	} else {
		$bookeduntil = $out_until + $timereqd;
	}
  
	$updateSQL = sprintf("UPDATE call_log SET dispatcher=%s, vehicle1=%s, v1crew1=%s, v1crew2=%s, notes=%s, call_status=%s, despatched=%s, est_fin_time=%s WHERE logID=%s",
                       GetSQLValueString($_COOKIE['MM_userID'], "int"),
                       GetSQLValueString($_POST['vehicle1'], "int"),
                       GetSQLValueString($_POST['crew1'], "int"),
                       GetSQLValueString($_POST['crew2'], "int"),
                       GetSQLValueString($_POST['notes'], "text"),
                       GetSQLValueString($_POST['call_status'], "int"),
                       GetSQLValueString(time(), "int"),
                       GetSQLValueString($bookeduntil, "int"),
                       GetSQLValueString($_POST['logID'], "int"));

	mysql_select_db($database_adhocConn, $adhocConn);
	$Result1 = mysql_query($updateSQL, $adhocConn) or die(__LINE__.mysql_error());
	
	$updateSQL = sprintf("UPDATE crews SET booked_until=%s WHERE crewID=%s",
					   GetSQLValueString($bookeduntil, "int"),
					   GetSQLValueString($_POST['crew1'], "int"));
	
	mysql_select_db($database_adhocConn, $adhocConn);
	$Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());
  
	$updateSQL = sprintf("UPDATE crews SET booked_until=%s WHERE crewID=%s",
					   GetSQLValueString($bookeduntil, "int"),
					   GetSQLValueString($_POST['crew2'], "int"));
	
	mysql_select_db($database_adhocConn, $adhocConn);
	$Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());
  
	$updateSQL = sprintf("UPDATE vehicles SET booked_until=%s WHERE vehicleID=%s",
					   GetSQLValueString($bookeduntil, "int"),
					   GetSQLValueString($_POST['vehicle1'], "int"));
	
	mysql_select_db($database_adhocConn, $adhocConn);
	$Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());

	if (($_POST['vehicle1'] != "GIVE AWAY")) {
		mysql_select_db($database_adhocConn, $adhocConn);
		$query_vehicle = sprintf("SELECT * FROM vehicles WHERE vehicleID = %s", $_POST['vehicle1']);
		$vehicle = mysql_query($query_vehicle, $adhocConn) or die(__LINE__.mysql_error());
		$row_vehicle = mysql_fetch_assoc($vehicle);
		$totalRows_vehicle = mysql_num_rows($vehicle);
		$v1name = $row_vehicle['vehicle'];
		mysql_free_result($vehicle);
		
		mysql_select_db($database_adhocConn, $adhocConn);
		$query_crew = sprintf("SELECT * FROM crews WHERE crewID = %s", $_POST['crew1']);
		$crew = mysql_query($query_crew, $adhocConn) or die(__LINE__.mysql_error());
		$row_crew = mysql_fetch_assoc($crew);
		$totalRows_crew = mysql_num_rows($crew);
		$cellno = $row_crew['cellno'];
		mysql_free_result($crew);
		
		mysql_select_db($database_adhocConn, $adhocConn);
		$query_addressdetails = sprintf("SELECT * FROM addresses WHERE addressID = %s", $_POST['address']);
		$addressdetails = mysql_query($query_addressdetails, $adhocConn) or die(mysql_error());
		$row_addressdetails = mysql_fetch_assoc($addressdetails);
		$totalRows_addressdetails = mysql_num_rows($addressdetails);
		$address = $row_addressdetails['unitno'] . " " . $row_addressdetails['complex'] . " " . $row_addressdetails['streetno'] . " " . $row_addressdetails['street'];

		mysql_select_db($database_adhocConn, $adhocConn);
		$query_subname = sprintf("SELECT * FROM suburbs WHERE suburbID = %s", $row_addressdetails['suburb']);
		$subname = mysql_query($query_subname, $adhocConn) or die(mysql_error());
		$row_subname = mysql_fetch_assoc($subname);
		$totalRows_subname = mysql_num_rows($subname);
		$address = $address . " " . $row_subname['suburb'];
		mysql_free_result($subname);
		
		$address = str_replace("&", "and", $address);
		mysql_free_result($addressdetails);
		
		$msg1 = "DESPATCH " . $_POST['logID'] . ": " . $_POST['condition'] . " - " . $address . " - vehicle " . $v1name . ".";

		mysql_select_db($database_adhocConn, $adhocConn);
		$query_details = sprintf("SELECT * FROM call_log WHERE logID = %s", $_POST['logID']);
		$details = mysql_query($query_details, $adhocConn) or die(mysql_error());
		$row_details = mysql_fetch_assoc($details);
		$totalRows_details = mysql_num_rows($details);
		if ($row_details['other']) { $msg1 = $msg1 . " (" . $row_details['other'] . ")."; }
		if ($row_details['access_amt'] > 0) { $msg1 = $msg1 . " Access Amt R" . $row_details['access_amt'] . " " . $row_details['access_pmt_method'] . "."; }
		if ($row_details['order_no']) { $msg1 = $msg1 . " O.No " . $row_details['order_no'] . "."; }
		if ($row_details['policy_no']) { $msg1 = $msg1 . " Pol.No " . $row_details['policy_no'] . "."; }
		if ($row_details['claim_no']) { $msg1 = $msg1 . " Cl.No " . $row_details['claim_no'] . "."; }
		if ($row_details['reference_no']) { $msg1 = $msg1 . " Ref.No " . $row_details['reference_no'] . "."; }
		
		mysql_select_db($database_adhocConn, $adhocConn);
		$query_client = sprintf("SELECT * FROM clients WHERE clientID = %s", $row_details['clientID']);
		$client = mysql_query($query_client, $adhocConn) or die(mysql_error());
		$row_client = mysql_fetch_assoc($client);
		$totalRows_client = mysql_num_rows($client);
		$surname = $row_client['surname'];
		
		mysql_select_db($database_adhocConn, $adhocConn);
		$query_category = sprintf("SELECT * FROM categories WHERE catID = %s", $row_client['category']);
		$category = mysql_query($query_category, $adhocConn) or die(mysql_error());
		$row_category = mysql_fetch_assoc($category);
		$totalRows_category = mysql_num_rows($category);
		$cat = $row_category['category'];
		$msg1 = $msg1 . " " . $cat . " - " . $surname . ". " . $row_client['paymethod'] . ".";
		mysql_free_result($category);

		mysql_free_result($client);
		
		mysql_free_result($details);
	  
		// send sms to vehicle
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://www.mymobileapi.com/api5/http5.aspx');
		curl_setopt ($ch, CURLOPT_POST, 1);
		$post_fields = "Type=sendparam&username=adhoc&password=admin1&numto=" . $cellno . "&data1=" . $msg1;
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_fields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response_string = curl_exec($ch);
		curl_close($ch);
		
	}
	$updateGoTo = "control_panel_jobs.php";
	header(sprintf("Location: %s", $updateGoTo));
}
?>
<?php require_once('inc_before.php'); ?>
<?php

mysql_select_db($database_adhocConn, $adhocConn);
$query_crew1 = sprintf("SELECT * FROM crews WHERE regionID = %s ORDER BY crew ASC", $myregionID);
$crew1 = mysql_query($query_crew1, $adhocConn) or die(mysql_error());
$row_crew1 = mysql_fetch_assoc($crew1);
$totalRows_crew1 = mysql_num_rows($crew1);

mysql_select_db($database_adhocConn, $adhocConn);
$query_crew2 = sprintf("SELECT * FROM crews WHERE regionID = %s ORDER BY crew ASC", $myregionID);
$crew2 = mysql_query($query_crew2, $adhocConn) or die(mysql_error());
$row_crew2 = mysql_fetch_assoc($crew2);
$totalRows_crew2 = mysql_num_rows($crew2);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_call = "-1";
if (isset($_GET['caseno'])) {
  $colname_call = $_GET['caseno'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_call = sprintf("SELECT * FROM call_log WHERE logID = %s", GetSQLValueString($colname_call, "int"));
$call = mysql_query($query_call, $adhocConn) or die(__LINE__.mysql_error());
$row_call = mysql_fetch_assoc($call);
$totalRows_call = mysql_num_rows($call);

mysql_select_db($database_adhocConn, $adhocConn);
$query_v1 = sprintf("SELECT * FROM vehicles where regionID = %s ORDER BY vehicle ASC", $myregionID);
$v1 = mysql_query($query_v1, $adhocConn) or die(__LINE__.mysql_error());
$row_v1 = mysql_fetch_assoc($v1);
$totalRows_v1 = mysql_num_rows($v1);

mysql_select_db($database_adhocConn, $adhocConn);
$query_notes = sprintf("SELECT * FROM comments WHERE callID = %s ORDER BY logtime ASC", $_GET['caseno']);
$notes = mysql_query($query_notes, $adhocConn) or die(mysql_error());
$row_notes = mysql_fetch_assoc($notes);
$totalRows_notes = mysql_num_rows($notes);

$colname_client = "-1";
if (isset($_GET['clientID'])) {
  $colname_client = $_GET['clientID'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_client = sprintf("SELECT * FROM clients WHERE clientID = %s", GetSQLValueString($colname_client, "int"));
$client = mysql_query($query_client, $adhocConn) or die(mysql_error());
$row_client = mysql_fetch_assoc($client);
$totalRows_client = mysql_num_rows($client);

if (!($_COOKIE['MM_UserGroup'])) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>
              <p>Despatch Vehicle</p>
                <p align="center" class="logbutton">CASE NUMBER: <?php echo $row_call['logID']; ?></p>
                
                  <table border="0" align="center" cellpadding="3" cellspacing="0">

                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Despatcher:</td>
                      <td colspan="4"><?php
					  	if ($row_call['dispatcher']) {
							$desp = $row_call['dispatcher'];
						} else {
							$desp = $_COOKIE['MM_userID'];
						}
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_despatcher = sprintf("SELECT * FROM users WHERE userID = %s", $desp);
						$despatcher = mysql_query($query_despatcher, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
						$row_despatcher = mysql_fetch_assoc($despatcher);
						$totalRows_despatcher = mysql_num_rows($despatcher);
						echo $row_despatcher['fullname'];
						mysql_free_result($despatcher);
					  ?></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Address:</td>
                      <td colspan="4" rowspan="2"><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_call['addressID']);
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
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">&nbsp;</td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" valign="top" nowrap="nowrap">Logged:</td>
                      <td colspan="4"><?php echo date("d M Y H:i", htmlentities($row_call['logtime'], ENT_COMPAT, 'utf-8')); ?></td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" valign="top" nowrap="nowrap">Contact:</td>
                      <td colspan="4"><?php echo htmlentities($row_call['caller'], ENT_COMPAT, 'utf-8'); ?> - <?php echo htmlentities($row_call['telno1'], ENT_COMPAT, 'utf-8'); ?></td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" valign="top" nowrap="nowrap">Access Amount:</td>
                      <td colspan="4">R<?php echo htmlentities($row_call['access_amt'], ENT_COMPAT, 'utf-8'); ?> <?php echo htmlentities($row_call['access_pmt_method'], ENT_COMPAT, 'utf-8'); ?></td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" valign="top" nowrap="nowrap">Nature of call:</td>
                      <td colspan="4"><?php echo htmlentities($row_call['condition'], ENT_COMPAT, 'utf-8'); ?> [ <?php echo htmlentities($row_call['other'], ENT_COMPAT, 'utf-8'); ?> ]</td>
                    </tr>

                    <tr valign="baseline">
                      <td align="right" valign="top" nowrap="nowrap">Notes:</td>
                      <td colspan="4"><?php 
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
					  } ?>
                          <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                            <table align="left">
                              <tr valign="baseline">
                                <td><textarea name="comment" cols="50" rows="5" class="smalltext"></textarea>                                </td>
                              </tr>
                              <tr valign="baseline">
                                <td><input type="submit" class="maintext" value="Add Note" /></td>
                              </tr>
                            </table>
                            <input type="hidden" name="callID" value="<?php echo $_GET['caseno']; ?>" />
                            <input type="hidden" name="logtime" value="<?php echo time(); ?>" />
                            <input type="hidden" name="logged_by" value="<?php echo $_COOKIE['MM_userID']; ?>" />
                            <input type="hidden" name="MM_insert" value="form1" />
                          </form></td>
                    </tr></table>
            <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                  <table border="0" align="center" cellpadding="3" cellspacing="0">
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Vehicle:</td>
                      <td><select name="vehicle1" class="maintext">
                          <?php 
do {  
?>
                          <option value="<?php echo $row_v1['vehicleID']?>"><?php echo $row_v1['vehicle'];
							$sd = getdate(time()); 
							$sd_d = $sd[mday];
							$sd_m = $sd[mon];
							$sd_y = $sd[year];
							$sdate = mktime(7,0,0,$sd_m,$sd_d,$sd_y);
							
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_crewdetails = sprintf("SELECT * FROM call_log left join addresses using (addressID) left join suburbs on addresses.suburb = suburbs.suburbID left join subregions on suburbs.subregion = subregions.subID WHERE vehicle1 = %s AND est_fin_time > %s ORDER BY est_fin_time DESC", $row_v1['vehicleID'], $sdate);
							$crewdetails = mysql_query($query_crewdetails, $adhocConn) or die(mysql_error());
							$row_crewdetails = mysql_fetch_assoc($crewdetails);
							$totalRows_crewdetails = mysql_num_rows($crewdetails);
							if ($totalRows_crewdetails > 0) {
								echo " - " . $row_crewdetails['subregion'] . " until " . date("H:i", $row_crewdetails['est_fin_time']);
							}
							mysql_free_result($crewdetails);
						  ?></option>
                          <?php
} while ($row_v1 = mysql_fetch_assoc($v1));
?>
                        </select>                      </td>
                      <td colspan="3">&nbsp;</td>
                    </tr>

                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Crew:</td>
                      <td colspan="4">1
                        <select name="crew1" class="maintext" id="crew1">
                        <?php
do {  
?>
                        <option value="<?php echo $row_crew1['crewID']?>"><?php echo $row_crew1['crew']; 
							$sd = getdate(time()); 
							$sd_d = $sd[mday];
							$sd_m = $sd[mon];
							$sd_y = $sd[year];
							$sdate = mktime(7,0,0,$sd_m,$sd_d,$sd_y);
							
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_crewdetails = sprintf("SELECT * FROM call_log left join addresses using (addressID) left join suburbs on addresses.suburb = suburbs.suburbID left join subregions on suburbs.subregion = subregions.subID WHERE (v1crew1 = %s OR v1crew2 = %s) AND est_fin_time > %s ORDER BY est_fin_time DESC", $row_crew1['crewID'], $row_crew1['crewID'], $sdate);
							$crewdetails = mysql_query($query_crewdetails, $adhocConn) or die(mysql_error());
							$row_crewdetails = mysql_fetch_assoc($crewdetails);
							$totalRows_crewdetails = mysql_num_rows($crewdetails);
							if ($totalRows_crewdetails > 0) {
								echo " - " . $row_crewdetails['subregion'] . " until " . date("H:i", $row_crewdetails['est_fin_time']);
							}
							mysql_free_result($crewdetails);
						?></option>
                        <?php
} while ($row_crew1 = mysql_fetch_assoc($crew1));
  $rows = mysql_num_rows($crew1);
  if($rows > 0) {
      mysql_data_seek($crew1, 0);
	  $row_crew1 = mysql_fetch_assoc($crew1);
  }
?>
                      </select><br />
                        2
                        <select name="crew2" class="maintext" id="crew2">
  <?php
do {  
?>
  <option value="<?php echo $row_crew2['crewID']?>"><?php echo $row_crew2['crew'];
							$sd = getdate(time()); 
							$sd_d = $sd[mday];
							$sd_m = $sd[mon];
							$sd_y = $sd[year];
							$sdate = mktime(7,0,0,$sd_m,$sd_d,$sd_y);
							
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_crewdetails = sprintf("SELECT * FROM call_log left join addresses using (addressID) left join suburbs on addresses.suburb = suburbs.suburbID left join subregions on suburbs.subregion = subregions.subID WHERE (v1crew1 = %s OR v1crew2 = %s) AND est_fin_time > %s ORDER BY est_fin_time DESC", $row_crew2['crewID'], $row_crew2['crewID'], $sdate);
							$crewdetails = mysql_query($query_crewdetails, $adhocConn) or die(mysql_error());
							$row_crewdetails = mysql_fetch_assoc($crewdetails);
							$totalRows_crewdetails = mysql_num_rows($crewdetails);
							if ($totalRows_crewdetails > 0) {
								echo " - " . $row_crewdetails['subregion'] . " until " . date("H:i", $row_crewdetails['est_fin_time']);
							}
							mysql_free_result($crewdetails);
  ?></option>
  <?php
} while ($row_crew2 = mysql_fetch_assoc($crew2));
  $rows = mysql_num_rows($crew2);
  if($rows > 0) {
      mysql_data_seek($crew2, 0);
	  $row_crew2 = mysql_fetch_assoc($crew2);
  }
?>
</select> 
(crew 1 gets notification sms)</td>
                    </tr>
                    <?php if ($row_call['logtime'] > time()) { ?>
                    <tr valign="baseline">
                      <td colspan="5" align="right" nowrap="nowrap"><div align="center" class="redtext">Too early to despatch this call.<br />
                      This call can only be despatched after <?php echo date("d M Y H:i", $row_call['logtime']); ?></div></td>
                    </tr>
                    <?php } else { ?>
                    <tr valign="baseline">
                      <td colspan="2" align="right" nowrap="nowrap"><div align="left"><a href="print_jobcard.php?caseno=<?php echo $row_call['logID']; ?>" target="_blank">PRINT JOB CARD</a></div></td>
                      <td>&nbsp;</td>
                      <td colspan="2"><div align="right">
                        <input type="submit" class="logbutton" value="DESPATCH" />
                      </div></td>
                      </tr>
                    <?php } ?>
                  </table>
                  <input type="hidden" name="logtime" value="<?php echo htmlentities($row_call['logtime'], ENT_COMPAT, 'utf-8'); ?>" />
                  <input type="hidden" name="location" value="<?php echo htmlentities($row_call['location'], ENT_COMPAT, 'utf-8'); ?>" />
                  <input type="hidden" name="address" value="<?php echo htmlentities($row_call['addressID'], ENT_COMPAT, 'utf-8'); ?>" />
                  <input type="hidden" name="mine" value="<?php echo htmlentities($row_call['mine'], ENT_COMPAT, 'utf-8'); ?>" />
                  <input type="hidden" name="condition" value="<?php echo htmlentities($row_call['condition'], ENT_COMPAT, 'utf-8'); ?>" />
                  <input type="hidden" name="call_status" value="5" />
                  <input type="hidden" name="MM_update" value="form2" />
                  <input type="hidden" name="logID" value="<?php echo $row_call['logID']; ?>" />
                  <input type="hidden" name="dispatcher" value="<?php echo $_COOKIE['MM_userID']; ?>" />
                </form>
                <?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($crew1);

mysql_free_result($crew2);
?>

</body>
</html>
<?php
mysql_free_result($call);

mysql_free_result($v1);

mysql_free_result($v2);

mysql_free_result($v3);

mysql_free_result($v1crew1);

mysql_free_result($notes);

mysql_free_result($client);
?>
