<?php require_once('Connections/adhocConn.php'); ?>
<?php
if (!($_COOKIE['MM_UserGroup'])) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}

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

mysql_select_db($database_adhocConn, $adhocConn);
$query_red = "SELECT * FROM call_log WHERE call_status = 1 ORDER BY calltype ASC, logtime DESC";
$red = mysql_query($query_red, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_red = mysql_fetch_assoc($red);
$totalRows_red = mysql_num_rows($red);

mysql_select_db($database_adhocConn, $adhocConn);
$query_orange = "SELECT * FROM call_log WHERE call_status = 2 ORDER BY calltype ASC, logtime DESC";
$orange = mysql_query($query_orange, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_orange = mysql_fetch_assoc($orange);
$totalRows_orange = mysql_num_rows($orange);

mysql_select_db($database_adhocConn, $adhocConn);
$query_green = "SELECT * FROM call_log WHERE call_status = 3 ORDER BY calltype ASC, logtime DESC";
$green = mysql_query($query_green, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_green = mysql_fetch_assoc($green);
$totalRows_green = mysql_num_rows($green);
?>
<?php require_once('inc_before.php'); ?>
              <p>Forms</p>
              <p>&nbsp;              </p>
              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($red);
mysql_free_result($orange);
mysql_free_result($green);
?>
