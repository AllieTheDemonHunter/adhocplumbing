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
$query_locations = "SELECT * FROM locations ORDER BY location ASC";
$locations = mysql_query($query_locations, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_locations = mysql_fetch_assoc($locations);
$totalRows_locations = mysql_num_rows($locations);
?>
<?php require_once('inc_before.php'); ?>
              <p>Locations</p>
              <blockquote>
                <?php if ($totalRows_locations > 0) { // Show if recordset not empty ?>
                  <div align="center">
                    <table border="1" cellpadding="3" cellspacing="0">
                          <tr>
                            <td>ID</td>
                            <td>location</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <?php do { ?>
                        <tr>
                          <td><?php echo $row_locations['locationID']; ?></td>
                          <td><?php echo $row_locations['location']; ?></td>
                          <td><a href="edit_location.php?locationID=<?php echo $row_locations['locationID']; ?>">edit</a></td>
                          <td><a href="delete_location.php?locationID=<?php echo $row_locations['locationID']; ?>">delete</a></td>
                        </tr>
                        <?php } while ($row_locations = mysql_fetch_assoc($locations)); ?>
                                                        </table>
                  </div>
                  <?php } // Show if recordset not empty ?>
                <?php if ($totalRows_locations == 0) { // Show if recordset empty ?>
                  <p align="center">No records found</p>
                  <?php } // Show if recordset empty ?>
<p align="center"><a href="add_location.php">Add a Location</a></p>
              </blockquote>              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($locations);
?>
