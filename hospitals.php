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

mysql_select_db($database_adhocConn, $adhocConn);
$query_hospitals = "SELECT * FROM hospitals ORDER BY hospital ASC";
$hospitals = mysql_query($query_hospitals, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_hospitals = mysql_fetch_assoc($hospitals);
$totalRows_hospitals = mysql_num_rows($hospitals);

if ($_COOKIE['MM_UserGroup'] < 5) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>

<?php require_once('inc_before.php'); ?>
              <p>Hospitals</p>
              <blockquote>
                <?php if ($totalRows_hospitals > 0) { // Show if recordset not empty ?>
                  <div align="center">
                    <table border="1" cellpadding="3" cellspacing="0">
                          <tr>
                            <td>ID</td>
                            <td>Hospital</td>
                            <td>Location</td>
                            <td>&nbsp;</td>
                          </tr>
                          <?php do { ?>
                        <tr>
                          <td><?php echo $row_hospitals['hospitalID']; ?></td>
                          <td><?php echo $row_hospitals['hospital']; ?></td>
                          <td><?php
								mysql_select_db($database_adhocConn, $adhocConn);
								$query_loc = sprintf("SELECT * FROM locations WHERE locationID = %s", $row_hospitals['location']);
								$loc = mysql_query($query_loc, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
								$row_loc = mysql_fetch_assoc($loc);
								$totalRows_loc = mysql_num_rows($loc);
								echo $row_loc['location'];
								mysql_free_result($loc);
						  ?></td>
                          <td><a href="edit_hospital.php?hospitalID=<?php echo $row_hospitals['hospitalID']; ?>">edit</a></td>
                        </tr>
                        <?php } while ($row_hospitals = mysql_fetch_assoc($hospitals)); ?>
                                                        </table>
                  </div>
                  <?php } // Show if recordset not empty ?>
                <?php if ($totalRows_hospitals == 0) { // Show if recordset empty ?>
                  <p align="center">No records found</p>
                  <?php } // Show if recordset empty ?>
<p align="center"><a href="add_hospital.php">Add Hospital</a></p>
              </blockquote>              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($hospitals);
?>
