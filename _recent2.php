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

$maxRows_recent = 10;
$pageNum_recent = 0;
if (isset($_GET['pageNum_recent'])) {
  $pageNum_recent = $_GET['pageNum_recent'];
}
$startRow_recent = $pageNum_recent * $maxRows_recent;

mysql_select_db($database_adhocConn, $adhocConn);
$query_recent = sprintf("SELECT * FROM call_log inner join clients using (clientID) %s ORDER BY logID DESC", $extra);
$query_limit_recent = sprintf("%s LIMIT %d, %d", $query_recent, $startRow_recent, $maxRows_recent);
$recent = mysql_query($query_limit_recent, $adhocConn) or die(mysql_error());
$row_recent = mysql_fetch_assoc($recent);

if (isset($_GET['totalRows_recent'])) {
  $totalRows_recent = $_GET['totalRows_recent'];
} else {
  $all_recent = mysql_query($query_recent);
  $totalRows_recent = mysql_num_rows($all_recent);
}
$totalPages_recent = ceil($totalRows_recent/$maxRows_recent)-1;
if ($totalRows_recent > 0) { 
if ($_POST['typeID']) {
	$typeID = $_POST['typeID'];
} else {
	$typeID = $_GET['typeID'];
}
if ($_POST['call_status']) {
	$call_status = $_POST['call_status'];
} else {
	$call_status = $_GET['call_status'];
}
?>
<table width="100%" border="1" cellspacing="0" cellpadding="3">
  <tr>
    <td class="fineprint">ID</td>
    <td class="fineprint">Client</td>
    <td class="fineprint">Address</td>
    <td class="fineprint">Logged</td>
    <td class="fineprint">Contact</td>
    <td class="fineprint">Status</td>
    <td class="fineprint">log call</td>
  </tr>
    <?php do { 
		mysql_select_db($database_adhocConn, $adhocConn);
		$query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_recent['addressID']);
		$address = mysql_query($query_address, $adhocConn) or die(mysql_error());
		$row_address = mysql_fetch_assoc($address);
		$totalRows_address = mysql_num_rows($address);

	?>
  <tr>
      <td><?php if ($row_recent['job_no']) { echo $row_recent['job_no']; } else { echo $row_recent['logID']; } ?></td>
      <td class="fineprint"><?php
	  		if ($row_recent['clientID']) {
				mysql_select_db($database_adhocConn, $adhocConn);
				$query_cdetails = sprintf("SELECT * FROM clients WHERE clientID = %s", $row_recent['clientID']);
				$cdetails = mysql_query($query_cdetails, $adhocConn) or die(mysql_error());
				$row_cdetails = mysql_fetch_assoc($cdetails);
				$totalRows_cdetails = mysql_num_rows($cdetails);
				echo $row_cdetails['cname'] . " " . $row_cdetails['surname'];
				mysql_free_result($cdetails);
			}
	  ?><br /><a href="log_quote_step_8.php?addressID=<?php echo $row_recent['addressID']; ?>&typeID=<?php echo $typeID; ?>&call_status=<?php echo $call_status; ?>&edit=1">edit</a></td>
      <td class="fineprint"><?php echo $row_address['unitno']; ?> <?php echo $row_address['complex']; ?><br>
        <?php echo $row_address['streetno']; ?> <?php echo $row_address['street']; ?><br>
        <?php
			if ($row_address['suburb']) {
				mysql_select_db($database_adhocConn, $adhocConn);
				$query_sname = sprintf("SELECT * FROM suburbs WHERE suburbID = %s", $row_address['suburb']);
				$sname = mysql_query($query_sname, $adhocConn) or die(mysql_error());
				$row_sname = mysql_fetch_assoc($sname);
				$totalRows_sname = mysql_num_rows($sname);
				echo $row_sname['suburb'];
				mysql_free_result($sname);
			}
		?><br /><a href="log_quote_step_8.php?addressID=<?php echo $row_recent['addressID']; ?>&typeID=<?php echo $typeID; ?>&call_status=<?php echo $call_status; ?>&edit=1">edit</a></td>
      <td class="fineprint"><?php echo date("d M Y", $row_recent['logtime']); ?></td>
      <td class="fineprint"><?php echo $row_recent['contactperson']; ?><br>
			<?php echo $row_recent['contactnos']; ?></td>
      <td class="fineprint"><div align="center" class="subtext"><?php
	  		if ($row_recent['call_status']) {
				mysql_select_db($database_adhocConn, $adhocConn);
				$query_cstatus = sprintf("SELECT * FROM call_statuses WHERE statusID = %s", $row_recent['call_status']);
				$cstatus = mysql_query($query_cstatus, $adhocConn) or die(mysql_error());
				$row_cstatus = mysql_fetch_assoc($cstatus);
				$totalRows_cstatus = mysql_num_rows($cstatus);
				echo $row_cstatus['status'];
				mysql_free_result($cstatus);
			}
	  ?><br /><a href="case_search.php?caseno=<?php echo $row_recent['logID']; ?>"><img src="images/more.png" border="0" alt="MORE" title="MORE" hspace="1" /></a><a href="info.php?caseno=<?php echo $row_recent['logID']; ?>" target="_blank"><img src="images/info.png" border="0" alt="INFO" title="INFO" hspace="1" /></a><a href="print_jobcard.php?caseno=<?php echo $row_recent['logID']; ?>" target="_blank"><img src="images/jobcard.png" border="0" alt="JOBCARD" title="JOBCARD" hspace="1" /></a></div></td>
      <td class="fineprint"><a href="log_quote_step_8.php?addressID=<?php echo $row_recent['addressID']; ?>&typeID=<?php echo $typeID; ?>&call_status=<?php echo $call_status; ?>">log call</a></td>
</tr>
      <?php 
		mysql_free_result($address);
	  } while ($row_recent = mysql_fetch_assoc($recent)); ?>
</table>
<?php
} else {
?><p align="center">No Recent Entries Found</p>
<?php
}
mysql_free_result($recent);
?>