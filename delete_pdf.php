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

if ((isset($_GET['filename'])) && ($_GET['filename'] != "") && ($_COOKIE['MM_UserGroup'] >= 3)) {
	$deleteSQL = sprintf("DELETE FROM pdfs WHERE pdfID=%s",
					   GetSQLValueString($_GET['pdfID'], "int"));
	
	mysql_select_db($database_adhocConn, $adhocConn);
	$Result1 = mysql_query($deleteSQL, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
	
	$filename = $_GET['filename'];
	if (file_exists($filename)) {
		$del1 = unlink($filename);
	}
}
$deleteGoTo = "info.php?caseno=" . $_GET['caseno'];
header(sprintf("Location: %s", $deleteGoTo));
?>