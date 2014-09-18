<?php require_once('Connections/adhocConn.php'); ?>
<?php
if ($_COOKIE['MM_UserGroup'] < 5) {
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
$query_clevels = "SELECT * FROM care_levels ORDER BY levelID ASC";
$clevels = mysql_query($query_clevels, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_clevels = mysql_fetch_assoc($clevels);
$totalRows_clevels = mysql_num_rows($clevels);
?>
<?php require_once('inc_before.php'); ?>
              <p>Care Levels</p>
              <blockquote>
                <?php if ($totalRows_clevels > 0) { // Show if recordset not empty ?>
                  <div align="center">
                    <table border="1" cellpadding="3" cellspacing="0">
                          <tr>
                            <td>ID</td>
                            <td>care level</td>
                            <td>&nbsp;</td>
                          </tr>
                          <?php do { ?>
                        <tr>
                          <td><?php echo $row_clevels['levelID']; ?></td>
                          <td><?php echo $row_clevels['carelevel']; ?></td>
                          <td><a href="edit_care_level.php?levelID=<?php echo $row_clevels['levelID']; ?>">edit</a></td>
                        </tr>
                        <?php } while ($row_clevels = mysql_fetch_assoc($clevels)); ?>
                                                        </table>
                  </div>
                  <?php } // Show if recordset not empty ?>
                <?php if ($totalRows_clevels == 0) { // Show if recordset empty ?>
                  <p align="center">No records found</p>
                  <?php } // Show if recordset empty ?>
<p align="center"><a href="add_care_level.php">Add a Care Level</a></p>
              </blockquote>              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($clevels);
?>
