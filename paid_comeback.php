
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

$colname_oldjob = "-1";
if (isset($_GET['logID'])) {
  $colname_oldjob = $_GET['logID'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_oldjob = sprintf("SELECT * FROM call_log WHERE logID = %s", GetSQLValueString($colname_oldjob, "int"));
$oldjob = mysql_query($query_oldjob, $adhocConn) or die(mysql_error());
$row_oldjob = mysql_fetch_assoc($oldjob);
$totalRows_oldjob = mysql_num_rows($oldjob);

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

$insertSQL = sprintf("INSERT INTO call_log (logID, job_no, logtime, caller, dispatcher, telno1, telno2, telno3, addressID, clientID, location, condition, medaid, medaidno, vehicle1, vehicle2, vehicle3, v1crew1, v1crew2, v1crew3, v2crew1, v2crew2, v2crew3, v3crew1, v3crew2, v3crew3, service, prf_no, notes, capturer, calltype, tfrtime, medauthno, medauthperson, tfrfrom, fromother, wardfrom, drfrom, drfromtelno, tfrto, toother, wardto, drto, drtotelno, patient, carelevel, priority, attachments, medicine, als_supervise, call_status, sms_sent, give_away, given_to, reason, auth_by, quote_amt, quote_no, invoiced, invoice_no, inv_amt, paid, paiddate, order_no, policy_no, claim_no, reference_no, despatched, est_fin_time, logged_by, seq_no, job_complete, other, jobcard_no, diary, `read`, ins_receipt_no, access_amt, access_pmt_method, actual_job, comeback) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($row_oldjob['logID'], "int"),
                       GetSQLValueString($row_oldjob['job_no'], "text"),
                       GetSQLValueString(time(), "int"),
                       GetSQLValueString($row_oldjob['caller'], "text"),
                       GetSQLValueString($row_oldjob['dispatcher'], "int"),
                       GetSQLValueString($row_oldjob['telno1'], "text"),
                       GetSQLValueString($row_oldjob['telno2'], "text"),
                       GetSQLValueString($row_oldjob['telno3'], "text"),
                       GetSQLValueString($row_oldjob['addressID'], "int"),
                       GetSQLValueString($row_oldjob['clientID'], "int"),
                       GetSQLValueString($row_oldjob['location'], "int"),
                       GetSQLValueString($row_oldjob['condition'], "text"),
                       GetSQLValueString($row_oldjob['medaid'], "int"),
                       GetSQLValueString($row_oldjob['medaidno'], "text"),
                       GetSQLValueString($row_oldjob['vehicle1'], "int"),
                       GetSQLValueString($row_oldjob['v1crew1'], "int"),
                       GetSQLValueString($row_oldjob['v1crew2'], "int"),
                       GetSQLValueString($row_oldjob['service'], "text"),
                       GetSQLValueString($row_oldjob['calltype'], "int"),
                       GetSQLValueString($row_oldjob['call_status'], "int"),
                       GetSQLValueString($row_oldjob['sms_sent'], "int"),
                       GetSQLValueString($row_oldjob['order_no'], "text"),
                       GetSQLValueString($row_oldjob['policy_no'], "text"),
                       GetSQLValueString($row_oldjob['claim_no'], "text"),
                       GetSQLValueString($row_oldjob['reference_no'], "text"),
                       GetSQLValueString($row_oldjob['despatched'], "int"),
                       GetSQLValueString($row_oldjob['est_fin_time'], "int"),
                       GetSQLValueString($row_oldjob['logged_by'], "int"),
                       GetSQLValueString($row_oldjob['seq_no'], "int"),
                       GetSQLValueString($row_oldjob['job_complete'], "int"),
                       GetSQLValueString($row_oldjob['other'], "text"),
                       GetSQLValueString($row_oldjob['jobcard_no'], "text"),
                       GetSQLValueString($row_oldjob['diary'], "int"),
                       GetSQLValueString($row_oldjob['read'], "int"),
                       GetSQLValueString($row_oldjob['ins_receipt_no'], "text"),
                       GetSQLValueString($row_oldjob['access_amt'], "double"),
                       GetSQLValueString($row_oldjob['access_pmt_method'], "text"),
                       GetSQLValueString($row_oldjob['actual_job'], "text"),
                       GetSQLValueString($row_oldjob['comeback'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($insertSQL, $adhocConn) or die(mysql_error());

  $insertGoTo = "control_panel_jobs.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));


mysql_free_result($oldjob);
?>
