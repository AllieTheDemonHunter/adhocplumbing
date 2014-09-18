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

if (!($_COOKIE['MM_UserGroup'])) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>
<script type="text/javascript">
function printpage()
  {
  window.print()
  }
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Adhoc_print_jobcard</title>
</head>

<body onLoad="printpage()">
<link href="styles.css" rel="stylesheet" type="text/css">

              <table width="700" border="3" align="center" cellpadding="10" cellspacing="0">
                <tr>
                  <td bgcolor="#FFFFFF"><p>JOBCARD</p>
                    <p align="center" class="logbutton">CASE NUMBER: <?php echo $row_call['logID']; ?></p>
                    <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                      <table border="0" align="center" cellpadding="3" cellspacing="0">
                        <tr valign="baseline">
                          <td nowrap="nowrap" align="right">Despatcher:</td>
                          <td colspan="4"><?php
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_despatcher = sprintf("SELECT * FROM users WHERE userID = %s", $_COOKIE['MM_userID']);
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
                          <td align="right" valign="top" nowrap="nowrap">Nature of Call:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['condition'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Actual job:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['actual_job'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
						<tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Jobcard no:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['jobcard_no'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
						<tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Insurance no:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['ins_receipt_no'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
						<tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Invoice no:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['invoice_no'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
						<tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Patchwork:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['patch_work'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
						<tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Geyser:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['geyser'], ENT_COMPAT, 'utf-8'); ?></td>
						  </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Other:</td>
                          <td colspan="4"><?php echo htmlentities($row_call['other'], ENT_COMPAT, 'utf-8'); ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Client:</td>
                          <td colspan="4"><?php
						  if ($row_call['clientID']) {
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_client = sprintf("SELECT * FROM clients WHERE clientID = %s", $row_call['clientID']);
							$client = mysql_query($query_client, $adhocConn) or die(mysql_error());
							$row_client = mysql_fetch_assoc($client);
							$totalRows_client = mysql_num_rows($client);
							echo $row_client['cname'] . " " . $row_client['surname'] . " (ID No " . $row_client['idno'] . ")";
							$cat = $row_client['category'];
							mysql_free_result($client);
						  }
						  ?>                          </td>
                        </tr>
                    <tr>
                      <td align="right">Email Address:</td>
                      <td><a href="mailto:<?php echo $row_call['cemail']; ?>"><?php echo $row_call['cemail']; ?></a></td>
                    </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Category:</td>
                          <td colspan="4"><?php
						  if ($cat) {
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_category = sprintf("SELECT * FROM categories WHERE catID = %s", $cat);
							$category = mysql_query($query_category, $adhocConn) or die(mysql_error());
							$row_category = mysql_fetch_assoc($category);
							$totalRows_category = mysql_num_rows($category);
							echo $row_category['category'];
							mysql_free_result($category);
						  }
						  ?></td>
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
                          <td align="right" valign="top" nowrap="nowrap">Vehicle:</td>
                          <td colspan="4"><?php
						  if ($row_call['vehicle1']) {
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_vehicle = sprintf("SELECT * FROM vehicles WHERE vehicleID = %s", $row_call['vehicle1']);
							$vehicle = mysql_query($query_vehicle, $adhocConn) or die(mysql_error());
							$row_vehicle = mysql_fetch_assoc($vehicle);
							$totalRows_vehicle = mysql_num_rows($vehicle);
							echo $row_vehicle['vehicle'];
							mysql_free_result($vehicle);
						  }
						  ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Crew 1:</td>
                          <td colspan="4"><?php
						  if ($row_call['v1crew1']) {
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_crew = sprintf("SELECT * FROM crews WHERE crewID = %s", $row_call['v1crew1']);
							$crew = mysql_query($query_crew, $adhocConn) or die(mysql_error());
							$row_crew = mysql_fetch_assoc($crew);
							$totalRows_crew = mysql_num_rows($crew);
							echo $row_crew['crew'];
							mysql_free_result($crew);
						  }
						  ?></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" valign="top" nowrap="nowrap">Crew 2:</td>
                          <td colspan="4"><?php
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
                      </table>
                      
<?php
	mysql_select_db($database_adhocConn, $adhocConn);
	$query_history = sprintf("SELECT * FROM call_log WHERE addressID = %s AND logID <> %s ORDER BY logID DESC", $row_call['addressID'], $row_call['logID']);
	$history = mysql_query($query_history, $adhocConn) or die(mysql_error());
	$row_history = mysql_fetch_assoc($history);
	$totalRows_history = mysql_num_rows($history);
	if ($totalRows_history > 0) { 
?>
<p align="center">HISTORY:</p>
<?php
	do {
?>
<p>
<?php echo date("d M Y", $row_history['logtime']); ?>: <?php echo $row_history['condition']; ?><br /><?php if ($row_history['notes']) { echo "<br />" . $row_history['notes']; } ?><?php if ($row_history['v1crew1']) { ?>
		<em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <?php
			mysql_select_db($database_adhocConn, $adhocConn);
			$query_crew = sprintf("SELECT * FROM crews WHERE crewID = %s", $row_history['v1crew1']);
			count:3;
			$crew = mysql_query($query_crew, $adhocConn) or die(mysql_error());
			$row_crew = mysql_fetch_assoc($crew);
			$totalRows_crew = mysql_num_rows($crew);
			echo $row_crew['crew'];
			mysql_free_result($crew);
		?></em><?php } ?></p>
<?php
	} while ($row_history = mysql_fetch_assoc($history));
}
mysql_free_result($history);
mysql_free_result($call);
mysql_free_result($notes);
?>
                      
                    
</body>
</html>
              