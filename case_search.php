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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO comments (callID, logtime, logged_by, `comment`) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['callID'], "int"),
                       GetSQLValueString($_POST['logtime'], "int"),
                       GetSQLValueString($_POST['logged_by'], "int"),
                       GetSQLValueString($_POST['comment'], "text"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($insertSQL, $adhocConn) or die(mysql_error());

  $insertGoTo = "case_search.php?caseno=" . $_POST['callID'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_adhocConn, $adhocConn);
$query_notes = sprintf("SELECT * FROM comments WHERE callID = %s ORDER BY logtime ASC", $_GET['caseno']);
$notes = mysql_query($query_notes, $adhocConn) or die(mysql_error());
$row_notes = mysql_fetch_assoc($notes);
$totalRows_notes = mysql_num_rows($notes);

$colname_case = "-1";
if (isset($_POST['caseno'])) {
  $colname_case = $_POST['caseno'];
} else {
	if (isset($_GET['caseno'])) {
	  $colname_case = $_GET['caseno'];
	}
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_case = sprintf("SELECT * FROM call_log INNER JOIN clients using (clientID) WHERE logID = %s", GetSQLValueString($colname_case, "int"));
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
                      <td><?php echo date("d M Y H:i", $row_case['logtime']); ?>
                        <table border="0" align="right" cellpadding="2" cellspacing="0">
                          <tr>
                      <?php if ($row_case['est_fin_time'] > time()) { ?>
                            <td><img src="images/in_process.gif" width="70" height="20" border="0" /></td>
                            <td><a href="add_time.php?logID=<?php echo $colname_case; ?>&c1=<?php echo $row_case['v1crew1']; ?>&c2=<?php echo $row_case['v1crew2']; ?>&v1=<?php echo $row_case['vehicle1']; ?>"><img src="images/add_more_time.jpg" width="96" height="20" border="0" /></a></td>
                            <td><a href="job_completed.php?logID=<?php echo $colname_case; ?>&c1=<?php echo $row_case['v1crew1']; ?>&c2=<?php echo $row_case['v1crew2']; ?>&v1=<?php echo $row_case['vehicle1']; ?>"><img src="images/job_complete.jpg" width="96" height="20" border="0" /></a></td>
                            <td><a href="reschedule_job.php?logID=<?php echo $colname_case; ?>&c1=<?php echo $row_case['v1crew1']; ?>&c2=<?php echo $row_case['v1crew2']; ?>&v1=<?php echo $row_case['vehicle1']; ?>"><img src="images/reschedule_job.jpg" width="100" height="20" border="0" /></a></td>
                      <?php } else { ?>
                            <td><a href="reschedule_job.php?logID=<?php echo $colname_case; ?>&c1=<?php echo $row_case['v1crew1']; ?>&c2=<?php echo $row_case['v1crew2']; ?>&v1=<?php echo $row_case['vehicle1']; ?>"><img src="images/reschedule_job.jpg" width="100" height="20" border="0" /></a></td>
                      <?php } ?>
                      		<?php if ($row_case['comeback'] == 0) { ?>
                            <td><a href="mark_comeback.php?logID=<?php echo $colname_case; ?>&c1=<?php echo $row_case['v1crew1']; ?>&c2=<?php echo $row_case['v1crew2']; ?>&v1=<?php echo $row_case['vehicle1']; ?>"><img src="images/mark_comeback.jpg" width="100" height="20" border="0" /></a></td>
                      		<?php } else { ?>
                            <td><a href="not_comeback.php?logID=<?php echo $colname_case; ?>&c1=<?php echo $row_case['v1crew1']; ?>&c2=<?php echo $row_case['v1crew2']; ?>&v1=<?php echo $row_case['vehicle1']; ?>"><img src="images/not_comeback.jpg" width="100" height="20" border="0" /></a></td>
                      		<?php } ?>
                          </tr>
                        </table>
                      <?php if ($row_case['call_status'] == 5) { ?>
                        <table border="0" align="right" cellpadding="2" cellspacing="0">
                          <tr>
                            <td><a href="move_back_to_red.php?logID=<?php echo $colname_case; ?>&c1=<?php echo $row_case['v1crew1']; ?>&c2=<?php echo $row_case['v1crew2']; ?>&v1=<?php echo $row_case['vehicle1']; ?>"><img src="images/back_to_red.jpg" width="70" height="20" border="0" /></a></td>
                          </tr>
                        </table>
                      <?php } ?></td>
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
                      <td>Email Address</td>
                      <td><a href="mailto:<?php echo $row_case['cemail']; ?>"><?php echo $row_case['cemail']; ?></a></td>
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
						if (($row_address['unitno']) || ($row_address['complex'])) {
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
                      <td>Actual Job</td>
                      <td><?php echo $row_case['actual_job']; ?></td>
                    </tr>
                    <tr>
                      <td>Access Amount</td>
                      <td>R<?php echo htmlentities($row_call['access_amt'], ENT_COMPAT, 'utf-8'); ?> <?php echo htmlentities($row_call['access_pmt_method'], ENT_COMPAT, 'utf-8'); ?></td>
                    </tr>
                    <tr>
                      <td>Call Status</td>
                      <?php
					  $link = "";
					  if ($row_case['call_status'] == 1) { 
						  $bgcolor = "FF0000"; 
						  //$link = "<a href=\"despatch.php?caseno=" . $colname_case . "\">DESPATCH QUOTER</a>";
						  $link = "<a href=\"capture_quote.php?caseno=" . $colname_case . "\">CAPTURE QUOTE</a>";
						  $status = "NEW";
					  }
					  if ($row_case['call_status'] == 2) { 
						  $bgcolor = "6666FF"; 
						  $link = "<a href=\"capture_quote.php?caseno=" . $colname_case . "\">CAPTURE QUOTE</a>";
						  $status = "DESPATCHED QUOTER";
					  }
					  if ($row_case['call_status'] == 3) { 
						  $bgcolor = "FF9900"; 
						  $link = "<a href=\"accept.php?caseno=" . $colname_case . "\">ACCEPT QUOTE</a> / <a href=\"decline.php?caseno=" . $colname_case . "\">DECLINE QUOTE</a>";
						  $status = "CAPTURED QUOTE";
					  }
					  if ($row_case['call_status'] == 4) { 
						  $bgcolor = "00CCFF"; 
						  $link = "<a href=\"despatch_vehicle.php?caseno=" . $colname_case . "\">DESPATCH VEHICLE</a>";
						  $status = "READY FOR DESPATCH";
					  }
					  if (($row_case['call_status'] >= 5) && ((!($row_case['jobcard_no'])) || ($row_case['jobcard_no'] == ""))) { 
						  $bgcolor = "00CCFF"; 
						  $link = "<a href=\"capture.php?caseno=" . $colname_case . "\">ENTER JOBCARD NO</a> | ";
						  $status = "DESPATCHED VEHICLE";
					  }
					  if (($row_case['call_status'] == 5) && ($row_case['job_complete'] != 1)) { 
						  $bgcolor = "00CCFF"; 
						  $link = $link . "<a href=\"job_completed.php?logID=" . $colname_case . "\">MARK AS COMPLETED</a>";
						  $status = "DESPATCHED VEHICLE";
					  }
					  if (($row_case['call_status'] == 5) && ($row_case['job_complete'] == 1)) { 
						  $bgcolor = "00CCFF"; 
						  $link = $link . "<a href=\"invoice.php?caseno=" . $colname_case . "\">ENTER INVOICE NO</a>";
						  $status = "JOB COMPLETED";
					  }
					  if (($row_case['call_status'] == 6) && ($row_case['job_complete'] == 1) && ($row_case['invoiced'] == 0)) { 
						  $bgcolor = "00CCFF"; 
						  $link = $link . "<a href=\"invoice.php?caseno=" . $colname_case . "\">ENTER INVOICE NO</a>";
						  $status = "JOB COMPLETED, WAITING FOR INVOICE";
					  }
					  if (($row_case['call_status'] == 6) && ($row_case['job_complete'] != 1)) { 
						  $bgcolor = "00CCFF"; 
						  $link = $link . "<a href=\"job_completed.php?logID=" . $colname_case . "\">MARK AS COMPLETED</a>";
						  $status = "JOB INCOMPLETE";
					  }
					  if (($row_case['call_status'] == 6) && ($row_case['job_complete'] == 1) && ($row_case['invoiced'] == 1)) { 
						  $bgcolor = "00CCFF"; 
						  $link = $link . "<a href=\"sign_off.php?caseno=" . $colname_case . "\">MARK AS PAID AND ARCHIVE</a>";
						  $status = "INVOICED";
					  }
					  if ($row_case['call_status'] == 7) { 
						  $bgcolor = "FFFFFF"; 
						  $status = "PAYMENT RECEIVED";
					  }
					  if ($row_case['call_status'] == 8) { 
						  $bgcolor = "FFFFFF"; 
						  $status = "EXPIRED";
					  }
					  if ($row_case['call_status'] == 9) { 
						  $bgcolor = "FFFFFF"; 
						  $status = "DECLINED";
					  }
					  ?>
                      <td bgcolor="#<?php echo $bgcolor; ?>"><?php
							echo $status;
					  ?> - <?php echo $link; ?></td>
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
                        <span class="redtext2">
                        <?php
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_logger = sprintf("SELECT * FROM users WHERE userID = %s", $row_notes['logged_by']);
							$logger = mysql_query($query_logger, $adhocConn) or die(mysql_error());
							$row_logger = mysql_fetch_assoc($logger);
							$totalRows_logger = mysql_num_rows($logger);
							echo $row_logger['uname'];
							mysql_free_result($logger);
						  ?>
                        </span>                          <span class="smalltext"> (<?php echo date("d M Y H:i", $row_notes['logtime']); 
						  ?>):</span><br />
                      <span class="smalltextindent"><?php echo nl2br($row_notes['comment']); ?></span><br />
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
                            <input type="hidden" name="callID" value="<?php echo $colname_case; ?>" />
                            <input type="hidden" name="logtime" value="<?php echo time(); ?>" />
                            <input type="hidden" name="logged_by" value="<?php echo $_COOKIE['MM_userID']; ?>" />
                            <input type="hidden" name="MM_insert" value="form1" />
                          </form>
                          <br />                      </td>
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
