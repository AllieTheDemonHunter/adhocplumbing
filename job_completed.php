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
if ($_COOKIE['MM_UserGroup'] >= 4) {
	$updateSQL = sprintf("UPDATE call_log SET est_fin_time=%s, job_complete=1, call_status=6 WHERE logID=%s",
                       GetSQLValueString(time()-1, "int"),
                       GetSQLValueString($_GET['logID'], "int"));

	mysql_select_db($database_adhocConn, $adhocConn);
	$Result1 = mysql_query($updateSQL, $adhocConn) or die(__LINE__.mysql_error());
	
	$updateSQL = sprintf("UPDATE crews SET booked_until=%s WHERE crewID=%s",
					   GetSQLValueString(time()-1, "int"),
					   GetSQLValueString($_GET['c1'], "int"));
	
	mysql_select_db($database_adhocConn, $adhocConn);
	$Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());
  
	$updateSQL = sprintf("UPDATE crews SET booked_until=%s WHERE crewID=%s",
					   GetSQLValueString(time()-1, "int"),
					   GetSQLValueString($_GET['c2'], "int"));
	
	mysql_select_db($database_adhocConn, $adhocConn);
	$Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());
  
	$updateSQL = sprintf("UPDATE vehicles SET booked_until=%s WHERE vehicleID=%s",
					   GetSQLValueString(time()-1, "int"),
					   GetSQLValueString($_GET['v1'], "int"));
	
	mysql_select_db($database_adhocConn, $adhocConn);
	$Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());
}
	
$updateGoTo = "control_panel_jobs.php";
header(sprintf("Location: %s", $updateGoTo));
?>
