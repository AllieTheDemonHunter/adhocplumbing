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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update_address")) {
  $updateSQL = sprintf("UPDATE addresses SET unitno=%s, complex=%s, streetno=%s, street=%s, lastupdate=%s WHERE addressID=%s",
                       GetSQLValueString($_POST['unitno'], "text"),
                       GetSQLValueString($_POST['complex'], "text"),
                       GetSQLValueString($_POST['streetno'], "text"),
                       GetSQLValueString($_POST['street'], "text"),
                       GetSQLValueString(time(), "int"),
                       GetSQLValueString($_POST['addressID'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());

	$updateGoTo = "log_quote_step_8.php?addressID=" . $_POST['addressID'] . "&typeID=" . $_POST['typeID'] . "&call_status=" . $_POST['call_status'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_address = "-1";
if (isset($_GET['addressID'])) {
  $colname_address = $_GET['addressID'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", GetSQLValueString($colname_address, "int"));
$address = mysql_query($query_address, $adhocConn) or die(mysql_error());
$row_address = mysql_fetch_assoc($address);
$totalRows_address = mysql_num_rows($address);

mysql_free_result($address);
?>
