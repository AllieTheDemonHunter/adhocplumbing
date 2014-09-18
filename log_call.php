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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "logcall")) {
	mysql_select_db($database_adhocConn, $adhocConn);
	$query_lastcall = "SELECT logID FROM call_log ORDER BY logID DESC";
	$lastcall = mysql_query($query_lastcall, $adhocConn) or die(mysql_error());
	$row_lastcall = mysql_fetch_assoc($lastcall);
	$totalRows_lastcall = mysql_num_rows($lastcall);
	$newcall = $row_lastcall['logID'] + 1;
	mysql_free_result($lastcall);

	mysql_select_db($database_adhocConn, $adhocConn);
	$query_prefix = sprintf("SELECT * FROM users inner join regions on (users.region=regions.regionID) WHERE userID = %s", $_COOKIE['MM_userID']);
	$prefix = mysql_query($query_prefix, $adhocConn) or die(mysql_error());
	$row_prefix = mysql_fetch_assoc($prefix);
	$totalRows_prefix = mysql_num_rows($prefix);
	$jobno = $row_prefix['prefix'] . str_pad($newcall,6,0,STR_PAD_LEFT);
	mysql_free_result($prefix);
	
	if ($_POST['comeback'] == 1) { $comeback = 1; } else { $comeback = 0; }
	$condition = $_POST['nature'] . " - " . $_POST['naturedetail'];
	$sdate = mktime($_POST['sd_h'],$_POST['sd_i'],0,$_POST['sd_m'],$_POST['sd_d'],$_POST['sd_y']);
	$insertSQL = sprintf("INSERT INTO call_log (logID, job_no, addressID, clientID, caller, telno1, access_amt, access_pmt_method, order_no, policy_no, claim_no, reference_no, calltype, logtime, logged_by, call_status, diary, `condition`, comeback, `other`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					   GetSQLValueString($newcall, "int"), 
					   GetSQLValueString($jobno, "text"),
					   GetSQLValueString($_POST['addressID'], "int"), 
					   GetSQLValueString($_POST['clientID'], "int"),
					   GetSQLValueString($_POST['caller'], "text"),
					   GetSQLValueString($_POST['telno1'], "text"),
					   GetSQLValueString($_POST['access_amt'], "double"),
					   GetSQLValueString($_POST['access_pmt_method'], "text"),
					   GetSQLValueString($_POST['order_no'], "text"),
					   GetSQLValueString($_POST['policy_no'], "text"),
					   GetSQLValueString($_POST['claim_no'], "text"),
					   GetSQLValueString($_POST['reference_no'], "text"),
					   GetSQLValueString($_POST['typeID'], "text"),
					   GetSQLValueString($sdate, "int"),
					   GetSQLValueString($_COOKIE['MM_userID'], "int"),
					   GetSQLValueString($_POST['call_status'], "int"),
					   GetSQLValueString($_POST['diary'], "int"),
					   GetSQLValueString($condition, "text"),
					   GetSQLValueString($comeback, "int"),
					   GetSQLValueString($_POST['other'], "text"));
	
	mysql_select_db($database_adhocConn, $adhocConn);
	$Result1 = mysql_query($insertSQL, $adhocConn) or die(mysql_error());
	
	if ($_POST['comment']) {
		mysql_select_db($database_adhocConn, $adhocConn);
		$query_latest = sprintf("SELECT * FROM call_log where addressID = %s ORDER BY logID DESC", $_POST['addressID']);
		$latest = mysql_query($query_latest, $adhocConn) or die(mysql_error());
		$row_latest = mysql_fetch_assoc($latest);
		$totalRows_latest = mysql_num_rows($latest);
		$insertSQL = sprintf("INSERT INTO comments (callID, logtime, logged_by, `comment`) VALUES (%s, %s, %s, %s)",
						   GetSQLValueString($row_latest['logID'], "int"),
						   GetSQLValueString(time(), "int"),
						   GetSQLValueString($_COOKIE['MM_userID'], "int"),
						   GetSQLValueString($_POST['comment'], "text"));
		
		mysql_select_db($database_adhocConn, $adhocConn);
		$Result1 = mysql_query($insertSQL, $adhocConn) or die(mysql_error());
		mysql_free_result($latest);
	}

	if ($_POST['typeID'] == 1) {
		$insertGoTo = "control_panel.php";
	}
	if ($_POST['typeID'] == 2) {
		$insertGoTo = "control_panel_jobs.php";
	}
	if ($_POST['typeID'] == 3) {
		$insertGoTo = "control_panel_patches.php";
	}
	header(sprintf("Location: %s", $insertGoTo));
}
?>