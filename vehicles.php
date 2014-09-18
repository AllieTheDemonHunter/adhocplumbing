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

?>
<?php require_once('inc_before.php'); ?>

<?php
mysql_select_db($database_adhocConn, $adhocConn);
$query_vehicles = sprintf("SELECT * FROM vehicles WHERE regionID = %s ORDER BY vehicle ASC", $myregionID);
$vehicles = mysql_query($query_vehicles, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_vehicles = mysql_fetch_assoc($vehicles);
$totalRows_vehicles = mysql_num_rows($vehicles);

if ($_COOKIE['MM_UserGroup'] < 5) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>

              <p>Vehicles</p>
              <blockquote>
                <?php if ($totalRows_vehicles > 0) { // Show if recordset not empty ?>
                  <table border="1" align="center" cellpadding="3" cellspacing="0">
                      <tr>
                          <td>vehicleID</td>
                          <td>vehicle</td>
                          <td>cell no</td>
                          <td>&nbsp;</td>
                      </tr>
                      <?php do { ?>
                      <tr>
                        <td><?php echo $row_vehicles['vehicleID']; ?></td>
                        <td><?php echo $row_vehicles['vehicle']; ?></td>
                        <td><?php echo $row_vehicles['cellno']; ?></td>
                        <td><a href="edit_vehicle.php?vehicleID=<?php echo $row_vehicles['vehicleID']; ?>">edit</a></td>
                      </tr>
                      <?php } while ($row_vehicles = mysql_fetch_assoc($vehicles)); ?>
                                  </table>
                  <?php } // Show if recordset not empty ?>
                <?php if ($totalRows_vehicles == 0) { // Show if recordset empty ?>
                  <p align="center">No records found</p>
                  <?php } // Show if recordset empty ?>
<p align="center"><a href="add_vehicle.php">Add a vehicle</a></p>
              </blockquote>              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($vehicles);
?>
