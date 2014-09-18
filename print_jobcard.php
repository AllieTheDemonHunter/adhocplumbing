<?php require_once('Connections/adhocConn.php'); ?>
<?php

if (! function_exists ( "GetSQLValueString" )) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
		$theValue = get_magic_quotes_gpc () ? stripslashes ( $theValue ) : $theValue;
		
		$theValue = function_exists ( "mysql_real_escape_string" ) ? mysql_real_escape_string ( $theValue ) : mysql_escape_string ( $theValue );
		
		switch ($theType) {
			case "text" :
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "long" :
			case "int" :
				$theValue = ($theValue != "") ? intval ( $theValue ) : "NULL";
				break;
			case "double" :
				$theValue = ($theValue != "") ? "'" . doubleval ( $theValue ) . "'" : "NULL";
				break;
			case "date" :
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "defined" :
				$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				break;
		}
		return $theValue;
	}
}
?>
<?php

$colname_call = "-1";
if (isset ( $_GET ['caseno'] )) {
	$colname_call = $_GET ['caseno'];
}
mysql_select_db ( $database_adhocConn, $adhocConn );
$query_call = sprintf ( "SELECT * FROM call_log inner join clients using (clientID) WHERE logID = %s", GetSQLValueString ( $colname_call, "int" ) );
$call = mysql_query ( $query_call, $adhocConn ) or die ( __LINE__ . mysql_error () );
$row_call = mysql_fetch_assoc ( $call );
$totalRows_call = mysql_num_rows ( $call );

mysql_select_db ( $database_adhocConn, $adhocConn );
$query_notes = sprintf ( "SELECT * FROM comments WHERE callID = %s ORDER BY logtime ASC", $_GET ['caseno'] );
$notes = mysql_query ( $query_notes, $adhocConn ) or die ( mysql_error () );
$row_notes = mysql_fetch_assoc ( $notes );
$totalRows_notes = mysql_num_rows ( $notes );

if (! ($_COOKIE ['MM_UserGroup'])) {
	$deniedGoTo = "index.php";
	header ( sprintf ( "Location: %s", $deniedGoTo ) );
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Adhoc_print_jobcard</title>
<script type="text/javascript">
function printpage()
  {
  window.print()
  }
</script>
<link href="jobcard-print-styles.css" rel="stylesheet" type="text/css"/>
</head>
<?php
mysql_select_db ( $database_adhocConn, $adhocConn );
$query_despatcher = sprintf ( "SELECT * FROM users WHERE userID = %s", $row_call['logged_by'] );
$despatcher = mysql_query ( $query_despatcher, $adhocConn ) or die ( "LINE " . __LINE__ . ": " . mysql_error () );
$row_despatcher = mysql_fetch_assoc ( $despatcher );
$totalRows_despatcher = mysql_num_rows ( $despatcher );
$logger_fullname = $row_despatcher ['fullname'];
mysql_free_result ( $despatcher );

?>
<body onload="printpage()" id="print-jobcard">
<?php //print_r($row_despatcher);?>
	<table width="730" align="center" id="main-table" cellpadding="10" cellspacing="0">
		<tr>
			<td id="logo-container" width="50%">
				<?php 
				switch($row_despatcher['region']) {
					case "498": //Pretoria Projects
						$logo_img = "images/project-logo.png";
						break;
					case "100": //Witbank
						$logo_img = "images/project-logo.png";
						break;
					case "3":
						$logo_img = "images/adhoc-logo.png";
				}
				?>
				<img src="<?php print $logo_img; ?>" />
				<h1 class="case-number">CASE NR: <?php echo $row_call['logID']; ?></h1>
				<div id="excess-amount">NB! GEYSER INSTALLATION EXCESS: R<?php echo htmlentities($row_call['access_amt'], ENT_COMPAT, 'utf-8'); ?></div>
			</td>
			<td width="50%" id="jobcard-title-block"><?php //print_r($row_call);?>
				<h2>JOBCARD</h2>
				<table>
					<tr valign="baseline">
						<td nowrap="nowrap" ><b>Logged By:</b></td>
						<td><b><?php print $logger_fullname; ?></b>
						</td>
					</tr>
					<tr valign="baseline">
						<td  valign="top" nowrap="nowrap"><b>Logged:</b></td>
						<td><b><?php echo date("d M Y H:i", htmlentities($row_call['logtime'], ENT_COMPAT, 'utf-8')); ?></b><br /><br /></td>
					</tr>
					<tr valign="baseline">
						<td nowrap="nowrap" ><b>Printed By:</b></td>
						<td><b><?php
						mysql_select_db ( $database_adhocConn, $adhocConn );
						$query_despatcher = sprintf ( "SELECT * FROM users WHERE userID = %s", $_COOKIE ['MM_userID'] );
						$despatcher = mysql_query ( $query_despatcher, $adhocConn ) or die ( "LINE " . __LINE__ . ": " . mysql_error () );
						$row_despatcher = mysql_fetch_assoc ( $despatcher );
						$totalRows_despatcher = mysql_num_rows ( $despatcher );
						echo $row_despatcher ['fullname'];
						mysql_free_result ( $despatcher );
						?></b>
						</td>
					</tr>
					<tr valign="baseline">
						<td  valign="top" nowrap="nowrap"><b>Printed:</b></td>
						<td><b><?php echo date("d M Y H:i"); ?></b></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td><div id="client-container" class="large-container">
					<h3>CLIENT</h3>
					<table border="0" align="center" cellpadding="3" cellspacing="0">
<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Name:</b></td>
							<td><?php
							if ($row_call ['clientID']) {
								mysql_select_db ( $database_adhocConn, $adhocConn );
								$query_client = sprintf ( "SELECT * FROM clients WHERE clientID = %s", $row_call ['clientID'] );
								$client = mysql_query ( $query_client, $adhocConn ) or die ( mysql_error () );
								$row_client = mysql_fetch_assoc ( $client );
								$totalRows_client = mysql_num_rows ( $client );
								echo $row_client ['cname'];
								$cat = $row_client ['category'];
								mysql_free_result ( $client );
							}
							?>                          </td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Surname:</b></td>
							<td><?php
							if ($row_call ['clientID']) {
								mysql_select_db ( $database_adhocConn, $adhocConn );
								$query_client = sprintf ( "SELECT * FROM clients WHERE clientID = %s", $row_call ['clientID'] );
								$client = mysql_query ( $query_client, $adhocConn ) or die ( mysql_error () );
								$row_client = mysql_fetch_assoc ( $client );
								$totalRows_client = mysql_num_rows ( $client );
								echo $row_client ['surname'];
								$cat = $row_client ['category'];
								mysql_free_result ( $client );
							}
							?>                          </td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>ID Number:</b></td>
							<td><?php
							if ($row_call ['clientID']) {
								mysql_select_db ( $database_adhocConn, $adhocConn );
								$query_client = sprintf ( "SELECT * FROM clients WHERE clientID = %s", $row_call ['clientID'] );
								$client = mysql_query ( $query_client, $adhocConn ) or die ( mysql_error () );
								$row_client = mysql_fetch_assoc ( $client ); //print_r($row_client);
								$totalRows_client = mysql_num_rows ( $client );
								echo $row_client ['idno'];
								$cat = $row_client ['category'];
								mysql_free_result ( $client );
							}
							?>                          </td>
						</tr>
						<tr valign="baseline">
							<td nowrap="nowrap" width="30"><b>Address:</b></td>
							<td><?php
							mysql_select_db ( $database_adhocConn, $adhocConn );
							$query_address = sprintf ( "SELECT * FROM addresses WHERE addressID = %s", $row_call ['addressID'] );
							$address = mysql_query ( $query_address, $adhocConn ) or die ( mysql_error () );
							$row_address = mysql_fetch_assoc ( $address );
							$totalRows_address = mysql_num_rows ( $address );
							if (($row_address ['unitno']) || ($row_address ['complex'])) {
								echo $row_address ['unitno'] . " " . $row_address ['complex'] . "<br>";
							}
							echo $row_address ['streetno'] . " " . $row_address ['street'] . "<br>"; //print_r($row_address);
							?></td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Suburb:</b></td>
							<td>
							<?php 
							mysql_select_db ( $database_adhocConn, $adhocConn );
							$query_suburb = sprintf ( "SELECT * FROM suburbs WHERE suburbID = %s", $row_address ['suburb'] );
							$suburb = mysql_query ( $query_suburb, $adhocConn ) or die ( mysql_error () );
							$row_suburb = mysql_fetch_assoc ( $suburb );
							$totalRows_suburb = mysql_num_rows ( $suburb );
							echo $row_suburb ['suburb'];
							mysql_free_result ( $suburb );
							mysql_free_result ( $address );							
							?>
							</td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>City:</b></td>
							<td>
							<?php 
							mysql_select_db ( $database_adhocConn, $adhocConn );
							$query_suburb = sprintf ( "SELECT * FROM regions WHERE regionID = %s", $row_address ['region'] );
							$region = mysql_query ( $query_suburb, $adhocConn ) or die ( mysql_error () );
							$row_region = mysql_fetch_assoc ( $region );
							$totalRows_suburb = mysql_num_rows ( $region );
							echo $row_region ['region'];
							//mysql_free_result ( $suburb );
							//mysql_free_result ( $address );							
							?>
							</td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Contact:</b></td>
							<td><?php echo htmlentities($row_call['caller'], ENT_COMPAT, 'utf-8'); //print_r($row_call); ?></td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Tel 1:</b></td>
							<td><?php echo htmlentities($row_call['telno1'], ENT_COMPAT, 'utf-8'); ?></td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Tel 2:</b></td>
							<td><?php echo htmlentities($row_call['telno2'], ENT_COMPAT, 'utf-8'); ?></td>
						</tr>
						<tr>
							<td><b>Email:</b></td>
							<td><a href="mailto:<?php echo $row_call['cemail']; ?>"><?php echo $row_call['cemail']; ?></a></td>
						</tr>
						<tr>
							<td><b>Payment:</b></td>
							<td><?php print $row_client['paymethod']; ?></td>
						</tr>

					</table>
				</div></td>
			<td><div id="job-container" class="large-container">
					<h3>JOB</h3>
					<table>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap" width="30"><b>Job Type:</b></td>
							<td><?php echo htmlentities($row_call['condition'], ENT_COMPAT, 'utf-8'); ?></td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Other:</b></td>
							<td><?php echo htmlentities($row_call['other'], ENT_COMPAT, 'utf-8'); ?></td>
						</tr>
						<!-- 
						<tr>
							<td  valign="top" nowrap="nowrap" width="30"><b>Excess:</b></td>
							<td>R<?php echo htmlentities($row_call['access_amt'], ENT_COMPAT, 'utf-8'); ?> (<?php echo htmlentities($row_call['access_pmt_method'], ENT_COMPAT, 'utf-8'); ?>)</td>
						</tr>	 -->	
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap" width="30"><b>Actual job:</b></td>
							<td><?php echo htmlentities($row_call['actual_job'], ENT_COMPAT, 'utf-8'); ?></td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Jobcard no:</b></td>
							<td><?php echo htmlentities($row_call['jobcard_no'], ENT_COMPAT, 'utf-8'); ?></td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Insurance no:</b></td>
							<td><?php echo htmlentities($row_call['ins_receipt_no'], ENT_COMPAT, 'utf-8'); ?></td>
						</tr>
						<!-- 
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Invoice no:</b></td>
							<td><?php echo htmlentities($row_call['invoice_no'], ENT_COMPAT, 'utf-8'); ?></td>
						</tr>
						 -->
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Patchwork:</b></td>
							<td><?php echo htmlentities($row_call['patch_work'], ENT_COMPAT, 'utf-8'); ?></td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Geyser:</b></td>
							<td><?php echo htmlentities($row_call['geyser'], ENT_COMPAT, 'utf-8'); ?></td>
						</tr>
					</table>
				</div></td>
		</tr>
		<tr>
			<td><div id="service-provider-container" class="large-container">
					<h3>SERVICE PROVIDER</h3>
					<table>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap" width="30"><b>Insure:</b></td>
							<td><?php
							if ($cat) {
								mysql_select_db ( $database_adhocConn, $adhocConn );
								$query_category = sprintf ( "SELECT * FROM categories WHERE catID = %s", $cat );
								$category = mysql_query ( $query_category, $adhocConn ) or die ( mysql_error () );
								$row_category = mysql_fetch_assoc ( $category );
								$totalRows_category = mysql_num_rows ( $category );
								echo $row_category ['category'];
								mysql_free_result ( $category );
							}
							?></td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Order No:</b></td>
							<td><?php echo htmlentities($row_call['order_no'], ENT_COMPAT, 'utf-8'); ?></td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Reference No:</b></td>
							<td><?php echo htmlentities($row_call['reference_no'], ENT_COMPAT, 'utf-8'); ?></td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Claim No:</b></td>
							<td><?php echo htmlentities($row_call['claim_no'], ENT_COMPAT, 'utf-8'); ?></td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Policy No:</b></td>
							<td><?php echo htmlentities($row_call['policy_no'], ENT_COMPAT, 'utf-8'); ?></td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Payment Method:</b></td>
							<td><?php echo htmlentities($row_call['paymethod'], ENT_COMPAT, 'utf-8'); ?></td>
						</tr>

						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Vehicle:</b></td>
							<td><?php
							if ($row_call ['vehicle1']) {
								mysql_select_db ( $database_adhocConn, $adhocConn );
								$query_vehicle = sprintf ( "SELECT * FROM vehicles WHERE vehicleID = %s", $row_call ['vehicle1'] );
								$vehicle = mysql_query ( $query_vehicle, $adhocConn ) or die ( mysql_error () );
								$row_vehicle = mysql_fetch_assoc ( $vehicle );
								$totalRows_vehicle = mysql_num_rows ( $vehicle );
								echo $row_vehicle ['vehicle'];
								mysql_free_result ( $vehicle );
							}
							?></td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Crew 1:</b></td>
							<td><?php
							if ($row_call ['v1crew1']) {
								mysql_select_db ( $database_adhocConn, $adhocConn );
								$query_crew = sprintf ( "SELECT * FROM crews WHERE crewID = %s", $row_call ['v1crew1'] );
								$crew = mysql_query ( $query_crew, $adhocConn ) or die ( mysql_error () );
								$row_crew = mysql_fetch_assoc ( $crew );
								$totalRows_crew = mysql_num_rows ( $crew );
								echo $row_crew ['crew'];
								mysql_free_result ( $crew );
							}
							?></td>
						</tr>
						<tr valign="baseline">
							<td  valign="top" nowrap="nowrap"><b>Crew 2:</b></td>
							<td><?php
							if ($row_call ['v1crew2']) {
								mysql_select_db ( $database_adhocConn, $adhocConn );
								$query_crew = sprintf ( "SELECT * FROM crews WHERE crewID = %s", $row_call ['v1crew2'] );
								$crew = mysql_query ( $query_crew, $adhocConn ) or die ( mysql_error () );
								$row_crew = mysql_fetch_assoc ( $crew );
								$totalRows_crew = mysql_num_rows ( $crew );
								echo $row_crew ['crew'];
								mysql_free_result ( $crew );
							}
							?></td>
						</tr>
					</table>
				</div></td>
			<td>
<div id="history-container" class="large-container">
					<h3>HISTORY</h3>
<?php
// mysql_select_db($database_adhocConn, $adhocConn);
$query_history = sprintf ( "SELECT * FROM call_log WHERE addressID = %s AND logID <> %s ORDER BY logID DESC LIMIT 10", $row_call ['addressID'], $row_call ['logID'] );
$history = mysql_query ( $query_history, $adhocConn ) or die ( mysql_error () );
$row_history = mysql_fetch_assoc ( $history );
$totalRows_history = mysql_num_rows ( $history );
if ($totalRows_history > 0) {
	?>
		<table border="0" id="history-table">
						<thead>
							<tr>
								<th>Date</th>
								<th>Condition</th>
								<th>Notes</th>
								<th>Crew</th>
							</tr>
						</thead>
						<tbody>
		<?php
	do {
		?>
		<tr>
								<td><?php echo date("d M Y", $row_history['logtime']); ?></td>
								<td><?php echo $row_history['condition']; ?></td>
								<td>
				<?php
		if ($row_history ['notes']) {
			echo $row_history ['notes'];
		} else {
			print "-";
		}
		?>
			</td>
								<td>
			<?php
		if ($row_history ['v1crew1']) {
			$query_crew = sprintf ( "SELECT * FROM crews WHERE crewID = %s", $row_history ['v1crew1'] );
			$crew = mysql_query ( $query_crew, $adhocConn ) or die ( mysql_error () );
			$row_crew = mysql_fetch_assoc ( $crew );
			$totalRows_crew = mysql_num_rows ( $crew );
			echo "" . $row_crew ['crew'] . "";
			mysql_free_result ( $crew );
		} else {
			print "-";
		}
		?>
			 </td>
							</tr>	
	<?php
	} while ( $row_history = mysql_fetch_assoc ( $history ) );
	mysql_free_result ( $history );
	?>
			</tbody>
					</table>
<?php

} else {
	print "No History";
}
mysql_free_result ( $call );
//mysql_free_result ( $notes );
?>
</div>
</td>
		</tr>
		<tr>
			<td colspan="2">
				<div id="notes-container" class="large-container">
					<h3>NOTES</h3>
	<?php
	if ($totalRows_notes > 0) {
		?>
		<table border="0" id="notes-table">
						<thead>
							<tr>
								<th>Date</th>
								<th>User</th>
								<th>Comments</th>
							</tr>
						</thead>
						<tbody>
       <?php do { ?>
			<tr>
            <?php
			mysql_select_db ( $database_adhocConn, $adhocConn );
			$query_logger = sprintf ( "SELECT * FROM users WHERE userID = %s", $row_notes ['logged_by'] );
			$logger = mysql_query ( $query_logger, $adhocConn ) or die ( mysql_error () );
			$row_logger = mysql_fetch_assoc ( $logger );
			$totalRows_logger = mysql_num_rows ( $logger );
			echo "<td>" . date ( "Y-m-d", $row_notes ['logtime'] ) . "</td>";
			echo "<td>" . $row_logger ['uname'] . "</td>";
			mysql_free_result ( $logger );
			echo "<td>" . $row_notes ['comment'] . "</td>";
			?>
		  	</tr>
      <?php } while ($row_notes = mysql_fetch_assoc($notes));?>
      </tbody>
					</table>
      <?php
	} else {
		print "No Notes found.";
	}
	?>
</div>
			</td>
		</tr>
	</table>







</body>
</html>
