<?php require_once('Connections/adhocConn.php'); ?>
<?php
  $updateSQL = sprintf("UPDATE regions SET active=1 WHERE regionID=%s", $_GET['regionID']);

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($updateSQL, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());

  $updateGoTo = "all_regions.php";
  header(sprintf("Location: %s", $updateGoTo));
?>