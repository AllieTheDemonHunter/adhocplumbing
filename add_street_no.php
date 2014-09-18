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
	mysql_select_db($database_adhocConn, $adhocConn);
	$query_lastID = "SELECT * FROM addresses ORDER BY addressID DESC";
	$lastID = mysql_query($query_lastID, $adhocConn) or die(mysql_error());
	$row_lastID = mysql_fetch_assoc($lastID);
	$totalRows_lastID = mysql_num_rows($lastID);
	$addressID = $row_lastID['addressID'] + 1;
	mysql_free_result($lastID);
	mysql_select_db($database_adhocConn, $adhocConn);
	$query_lastID = "SELECT * FROM clients ORDER BY clientID DESC";
	$lastID = mysql_query($query_lastID, $adhocConn) or die(mysql_error());
	$row_lastID = mysql_fetch_assoc($lastID);
	$totalRows_lastID = mysql_num_rows($lastID);
	$clientID = $row_lastID['clientID'] + 1;
	mysql_free_result($lastID);
	$insertSQL = sprintf("INSERT INTO addresses (addressID, clientID, unitno, complex, streetno, street, suburb, region, province, added, lastupdate) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					   GetSQLValueString($addressID, "int"),
					   GetSQLValueString($clientID, "int"),
					   GetSQLValueString($_POST['unitno'], "text"),
					   GetSQLValueString($_POST['complex'], "text"),
					   GetSQLValueString($_POST['streetno'], "text"),
					   GetSQLValueString($_POST['street'], "text"),
					   GetSQLValueString($_POST['suburb'], "int"),
					   GetSQLValueString($_POST['region'], "int"),
					   GetSQLValueString($_POST['province'], "int"),
					   GetSQLValueString(time(), "int"),
					   GetSQLValueString(time(), "int"));
	
	mysql_select_db($database_adhocConn, $adhocConn);
	$Result1 = mysql_query($insertSQL, $adhocConn) or die(mysql_error());
	
	$insertSQL = sprintf("INSERT INTO clients (clientID) VALUES (%s)",
					   GetSQLValueString($clientID, "int"));
	
	mysql_select_db($database_adhocConn, $adhocConn);
	$Result1 = mysql_query($insertSQL, $adhocConn) or die(mysql_error());
	
	$insertGoTo = "log_quote_step_8.php?addressID=" . $addressID . "&typeID=" . $_POST['typeID'] . "&call_status=" . $_POST['call_status'];
	header(sprintf("Location: %s", $insertGoTo));
}
?>