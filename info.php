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
  $insertSQL = sprintf("INSERT INTO correspondence (callID, logtime, logged_by, `comment`) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['callID'], "int"),
                       GetSQLValueString($_POST['logtime'], "int"),
                       GetSQLValueString($_POST['logged_by'], "int"),
                       GetSQLValueString($_POST['comment'], "text"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($insertSQL, $adhocConn) or die(mysql_error());

  $insertGoTo = "info.php?caseno=" . $_POST['callID'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_adhocConn, $adhocConn);
$query_correspondence = sprintf("SELECT * FROM correspondence WHERE callID = %s ORDER BY logtime ASC", $_GET['caseno']);
$correspondence = mysql_query($query_correspondence, $adhocConn) or die(mysql_error());
$row_correspondence = mysql_fetch_assoc($correspondence);
$totalRows_correspondence = mysql_num_rows($correspondence);
?>
<?php
$colname_call = "-1";
if (isset($_GET['caseno'])) {
  $colname_call = $_GET['caseno'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_call = sprintf("SELECT * FROM call_log inner join clients using (clientID) WHERE logID = %s", GetSQLValueString($colname_call, "int"));
$call = mysql_query($query_call, $adhocConn) or die(__LINE__.mysql_error());
$row_call = mysql_fetch_assoc($call);
$totalRows_call = mysql_num_rows($call);

mysql_select_db($database_adhocConn, $adhocConn);
$query_notes = sprintf("SELECT * FROM comments WHERE callID = %s ORDER BY logtime ASC", $_GET['caseno']);
$notes = mysql_query($query_notes, $adhocConn) or die(mysql_error());
$row_notes = mysql_fetch_assoc($notes);
$totalRows_notes = mysql_num_rows($notes);

mysql_select_db($database_adhocConn, $adhocConn);
$query_album = sprintf("SELECT * FROM photos WHERE logID = %s ORDER BY filename ASC", $_GET['caseno']);
$album = mysql_query($query_album, $adhocConn) or die(mysql_error());
$row_album = mysql_fetch_assoc($album);
$totalRows_album = mysql_num_rows($album);

if (!($_COOKIE['MM_UserGroup'])) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Adhoc_info</title>
</head>

<body>
<link href="styles.css" rel="stylesheet" type="text/css">

              <table width="700" border="3" align="center" cellpadding="10" cellspacing="0">
                <tr>
                  <td bgcolor="#FFFFFF"><p align="center" class="logbutton">CASE NUMBER: <?php echo $row_call['logID']; ?></p>
                    <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                      <table border="0" align="center" cellpadding="3" cellspacing="0">
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Logged:</td>
                          <td colspan="4"><?php echo date("d M Y H:i", htmlentities($row_call['logtime'], ENT_COMPAT, 'utf-8')) , " by "; 
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_logger = sprintf("SELECT * FROM users WHERE userID = %s", $row_call['logged_by']);
							$logger = mysql_query($query_logger, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
							$row_logger = mysql_fetch_assoc($logger);
							$totalRows_logger = mysql_num_rows($logger);
							echo $row_logger['fullname'];
						  ?></td>
                        </tr>
                        
                        <tr valign="baseline">
                          <td nowrap="nowrap" align="right">Address:</td>
                          <td colspan="4"><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_call['addressID']);
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
                        
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Contact:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['caller'], ENT_COMPAT, 'utf-8'); ?> - <?php echo htmlentities($row_call['telno1'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Nature of call:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['condition'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Actual job:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['actual_job'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
						<tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Patchwork:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['patch_work'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
						
						<tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Consequential Damage:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['cons_damage'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
						<tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Geyser:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['geyser'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
						<tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Job card No:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['jobcard_no'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
						<tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Invoice No:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['invoice_no'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
						 <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Insurance Receipt No:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['ins_receipt_no'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Access Amt:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['access_amt'], ENT_COMPAT, 'utf-8'); ?> <?php echo htmlentities($row_call['access_pmt_method'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Other:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['other'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Order No:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['order_no'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Policy No:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['policy_no'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Claim No:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['claim_no'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Reference No:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['reference_no'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Payment Method:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['paymethod'], ENT_COMPAT, 'utf-8'); ?></td>
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
					  } ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td nowrap="nowrap" align="right">Despatched:</td>
                          <td colspan="4"><?php 
						  if (($row_call['despatched']) && ($row_call['despatched'] != 0)) {
						    echo date("d M Y H:i", $row_call['despatched']) . " by ";
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_despatcher = sprintf("SELECT * FROM users WHERE userID = %s", $row_call['dispatcher']);
							$despatcher = mysql_query($query_despatcher, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
							$row_despatcher = mysql_fetch_assoc($despatcher);
							$totalRows_despatcher = mysql_num_rows($despatcher);
							echo $row_despatcher['fullname'];
							mysql_free_result($despatcher);
						  }
					  ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Vehicle despatched:</td>
                          <td colspan="4"><?php
						  	if ($row_call['vehicle1']) {
								mysql_select_db($database_adhocConn, $adhocConn);
								$query_veh = sprintf("SELECT * FROM vehicles WHERE vehicleID = %s", $row_call['vehicle1']);
								$veh = mysql_query($query_veh, $adhocConn) or die(mysql_error());
								$row_veh = mysql_fetch_assoc($veh);
								$totalRows_veh = mysql_num_rows($veh);
								echo $row_veh['vehicle'];
								mysql_free_result($veh);
							}
						  ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Crew despatched:</td>
                          <td colspan="4"><?php
						  	if ($row_call['v1crew1']) {
								mysql_select_db($database_adhocConn, $adhocConn);
								$query_crew = sprintf("SELECT * FROM crews WHERE crewID = %s", $row_call['v1crew1']);
								$crew = mysql_query($query_crew, $adhocConn) or die(mysql_error());
								$row_crew = mysql_fetch_assoc($crew);
								$totalRows_crew = mysql_num_rows($crew);
								echo $row_crew['crew'] . "<br>";
								mysql_free_result($crew);
							}
						  	if ($row_call['v1crew2']) {
								mysql_select_db($database_adhocConn, $adhocConn);
								$query_crew = sprintf("SELECT * FROM crews WHERE crewID = %s", $row_call['v1crew2']);
								$crew = mysql_query($query_crew, $adhocConn) or die(mysql_error());
								$row_crew = mysql_fetch_assoc($crew);
								$totalRows_crew = mysql_num_rows($crew);
								echo $row_crew['crew'];
								mysql_free_result($crew);
							}
						  ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Jobcard:</td>
                          <td colspan="4"><?php
						  	$fileexists = 'docs/' . $row_call['logID'] . "jobcard.pdf"; 
							if (file_exists($fileexists)) { 
								?><a href="<?php echo $fileexists; ?>">download</a>
                          <?php 
							} else {
							?><a href="upload.php?case_no=<?php echo $row_call['logID']; ?>" target="_blank">upload jobcard</a> (new window)
                          <?php 
							}
							?><br /><a href="upload_pdf.php?case_no=<?php echo $row_call['logID']; ?>" target="_blank">upload PDF</a> (new window)<br />
                            <?php
								mysql_select_db($database_adhocConn, $adhocConn);
								$query_pdfs = sprintf("SELECT * FROM pdfs WHERE case_no = %s ORDER BY pdfID ASC", $row_call['logID']);
								$pdfs = mysql_query($query_pdfs, $adhocConn) or die(mysql_error());
								$row_pdfs = mysql_fetch_assoc($pdfs);
								$totalRows_pdfs = mysql_num_rows($pdfs);
								if ($totalRows_pdfs > 0) {
									?><ul><?php
									do {
										?><li><a href="<?php echo $row_pdfs['pdfname']; ?>" target="_blank"><?php echo $row_pdfs['pdfname']; ?></a> [ <a href="delete_pdf.php?pdfID=<?php echo $row_pdfs['pdfID']; ?>&caseno=<?php echo $row_call['logID']; ?>&filename=<?php echo $row_pdfs['pdfname']; ?>">delete</a> ]</li>
										<?php
									} while ($row_pdfs = mysql_fetch_assoc($pdfs));
									?></ul><?php
								}
								mysql_free_result($pdfs);
							?>
                </td>
                        </tr>
                    <tr>
                      <td valign="top" colspan="4">Correspondence:</td>
                      <td><?php 
					  if ($totalRows_correspondence > 0) {
					    do { ?>
                          <span class="smalltext"><?php
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_logger = sprintf("SELECT * FROM users WHERE userID = %s", $row_correspondence['logged_by']);
							$logger = mysql_query($query_logger, $adhocConn) or die(mysql_error());
							$row_logger = mysql_fetch_assoc($logger);
							$totalRows_logger = mysql_num_rows($logger);
							echo $row_logger['uname'];
							mysql_free_result($logger);
						  ?> (<?php echo date("d M Y H:i", $row_correspondence['logtime']); 
						  ?>):</span><br /><span class="fineprintplain"><?php echo nl2br($row_correspondence['comment']); ?></span><br />
                          <?php } while ($row_correspondence = mysql_fetch_assoc($correspondence)); 
					  } ?>
                          <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                            <table align="left">
                              <tr valign="baseline">
                                <td><textarea name="comment" cols="50" rows="5" class="smalltext"></textarea>                                </td>
                              </tr>
                              <tr valign="baseline">
                                <td><input type="submit" class="maintext" value="Add Correspondence" /></td>
                              </tr>
                            </table>
                            <input type="hidden" name="callID" value="<?php echo $row_call['logID']; ?>" />
                            <input type="hidden" name="logtime" value="<?php echo time(); ?>" />
                            <input type="hidden" name="logged_by" value="<?php echo $_COOKIE['MM_userID']; ?>" />
                            <input type="hidden" name="MM_insert" value="form1" />
                          </form>
                          <br />
                      </td>
                    </tr>
                        <tr valign="baseline">
                          <td colspan="5" align="right" valign="top" nowrap="nowrap"><div align="center">
                            <table border="1" cellpadding="3" cellspacing="0">
                                <tr>
                              <?php 
							  if ($totalRows_album > 0) {
                                $counter = 0;
                                do { 
                                $counter = $counter + 1;
                              ?>
                                  <td valign="top"><a href="remove_photo.php?photoID=<?php echo $row_album['photoID']; ?>&filename=<?php echo $row_album['filename']; ?>&logID=<?php echo $_GET['caseno']; ?>"><img src="images/remove.jpg" alt="REMOVE" title="REMOVE" border="0" hspace="2" /></a><a href="mailto:email?subject=Job <?php echo $row_album['logID']; ?> photo from Ad Hoc Plumbers&body=http://www.adhocadmin.co.za/photos/1000/<?php echo $row_album['filename']; ?>"><img src="images/mail.jpg" alt="SEND" title="SEND" border="0" hspace="2" /></a><br /><a href="photos/1000/<?php echo $row_album['filename']; ?>" target="_blank"><img src="photos/100/<?php echo $row_album['filename']; ?>" border="0" /></a><br />
                                    <?php echo $row_album['caption']; ?></td>
                                    <?php if ($counter == 5) { 
                                    $counter = 0;
                                    ?>
                                  </tr><tr><?php } ?>
                                <?php } while ($row_album = mysql_fetch_assoc($album)); 
								}
								?>
                                </tr><tr>
                                  <td><a href="image_uploader.php?logID=<?php echo $_GET['caseno']; ?>">add photo / invoice</a></td>
                                  </tr>
                            </table>
                          <?php
							mysql_free_result($album);
                          ?>
                          </div></td>
                        </tr>
                      </table>
                    <?php
mysql_free_result($call);
mysql_free_result($notes);
mysql_free_result($correspondence);

?>
  </body>
</html>
              