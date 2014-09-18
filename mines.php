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
$query_mines = "SELECT * FROM mines ORDER BY locationID ASC";
$mines = mysql_query($query_mines, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_mines = mysql_fetch_assoc($mines);
$totalRows_mines = mysql_num_rows($mines);
?>
<?php require_once('inc_before.php'); ?>
              <p>Mines</p>
              <blockquote>
                <?php if ($totalRows_mines > 0) { // Show if recordset not empty ?>
                  <div align="center">
                    <table border="1" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
                          <tr>
                            <td>ID</td>
                            <td>mine</td>
                            <td>location</td>
                            <td>&nbsp;</td>
                          </tr>
                          <?php do { ?>
                        <tr>
                          <td><?php echo $row_mines['mineID']; ?></td>
                          <td><?php echo $row_mines['mine']; ?></td>
                          <td><?php
								mysql_select_db($database_adhocConn, $adhocConn);
								$query_loc = sprintf("SELECT * FROM locations WHERE locationID = %s", $row_mines['locationID']);
								$loc = mysql_query($query_loc, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
								$row_loc = mysql_fetch_assoc($loc);
								$totalRows_loc = mysql_num_rows($loc);
								echo $row_loc['location'];
								mysql_free_result($loc);
						  ?></td>
                          <td><a href="edit_mine.php?mineID=<?php echo $row_mines['mineID']; ?>">edit</a></td>
                        </tr>
                        <?php } while ($row_mines = mysql_fetch_assoc($mines)); ?>
                                                        </table>
                  </div>
                  <?php } // Show if recordset not empty ?>
                <?php if ($totalRows_mines == 0) { // Show if recordset empty ?>
                  <p align="center">No records found</p>
                  <?php } // Show if recordset empty ?>
<p align="center"><a href="add_mine.php">Add a Mine</a></p>
              </blockquote>              
              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($mines);
?>
