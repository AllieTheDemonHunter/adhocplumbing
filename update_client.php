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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update_client")) {
  $updateSQL = sprintf("UPDATE clients SET clientno=%s, cname=%s, surname=%s, telno=%s, cellno=%s, faxno=%s, cemail=%s, postal=%s, category=%s, paymethod=%s, idno=%s,  whereheard=%s, lastupdated=%s WHERE clientID=%s",
                       GetSQLValueString($_POST['clientno'], "text"),
                       GetSQLValueString($_POST['cname'], "text"),
                       GetSQLValueString($_POST['surname'], "text"),
                       GetSQLValueString($_POST['telno'], "text"),
                       GetSQLValueString($_POST['cellno'], "text"),
                       GetSQLValueString($_POST['faxno'], "text"),
                       GetSQLValueString($_POST['cemail'], "text"),
                       GetSQLValueString($_POST['postal'], "text"),
                       GetSQLValueString($_POST['category'], "int"),
                       GetSQLValueString($_POST['paymethod'], "text"),
                       GetSQLValueString($_POST['idno'], "text"),
                       GetSQLValueString($_POST['whereheard'], "text"),
                       GetSQLValueString(time(), "int"),
                       GetSQLValueString($_POST['clientID'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());

	$updateGoTo = "log_quote_step_8.php?addressID=" . $_POST['addressID'] . "&typeID=" . $_POST['typeID'] . "&call_status=" . $_POST['call_status'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>
