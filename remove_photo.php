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

if ((isset($_GET['photoID'])) && ($_GET['photoID'] != "") && (isset($_COOKIE['MM_userID']))) {
	$deleteSQL = sprintf("DELETE FROM photos WHERE photoID=%s",
					   GetSQLValueString($_GET['photoID'], "int"));
	
	mysql_select_db($database_adhocConn, $adhocConn);
	$Result1 = mysql_query($deleteSQL, $adhocConn) or die(mysql_error());
	
	$file = "photos/100/" . $_GET['filename'];
	if (!unlink($file))
	  {
	  echo ("Error deleting $file");
	  }
	$file = "photos/600/" . $_GET['filename'];
	if (!unlink($file))
	  {
	  echo ("Error deleting $file");
	  }
	$file = "photos/1000/" . $_GET['filename'];
	if (!unlink($file))
	  {
	  echo ("Error deleting $file");
	  }
	$deleteGoTo = "info.php?caseno=" . $_GET['logID'];
	header(sprintf("Location: %s", $deleteGoTo));
}
?>