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
	$updateSQL = sprintf("UPDATE call_log SET est_fin_time=%s, job_complete=0, call_status=4 WHERE logID=%s",
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

	mysql_select_db($database_adhocConn, $adhocConn);
	$query_crew = sprintf("SELECT * FROM crews WHERE crewID = %s", $_GET['c1']);
	$crew = mysql_query($query_crew, $adhocConn) or die(__LINE__.mysql_error());
	$row_crew = mysql_fetch_assoc($crew);
	$totalRows_crew = mysql_num_rows($crew);
	$cellno = $row_crew['cellno'];
	mysql_free_result($crew);
	
	$msg1 = "CALL NO " . $_POST['logID'] . " HAS BEEN CANCELLED.";
	
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
?>
