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

?>
<?php require_once('inc_before.php'); ?>
<?php
mysql_select_db($database_adhocConn, $adhocConn);
$query_crews = sprintf("SELECT * FROM crews WHERE regionID = %s ORDER BY crew ASC", $myregionID);
$crews = mysql_query($query_crews, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_crews = mysql_fetch_assoc($crews);
$totalRows_crews = mysql_num_rows($crews);
?>
              <p>Crews</p>
              <blockquote>
                <?php if ($totalRows_crews > 0) { // Show if recordset not empty ?>
                  <div align="center">
                    <table border="1" cellpadding="3" cellspacing="0">
                          <tr>
                            <td>ID</td>
                            <td><div align="left">crew</div></td>
                            <td>cellno</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <?php do { ?>
                        <tr>
                          <td><?php echo $row_crews['crewID']; ?></td>
                          <td><div align="left"><?php echo $row_crews['crew']; ?></div></td>
                          <td><?php echo $row_crews['cellno']; ?></td>
                          <td><a href="edit_crew.php?crewID=<?php echo $row_crews['crewID']; ?>">edit</a></td>
                          <td><a href="delete_crew.php?crewID=<?php echo $row_crews['crewID']; ?>">delete</a></td>
                          <td><a href="crew_report.php?crewID=<?php echo $row_crews['crewID']; ?>">report</a></td>
                          <td><a href="report_monthly_time_spent.php?crewID=<?php echo $row_crews['crewID']; ?>">time report</a></td>
                        </tr>
                        <?php } while ($row_crews = mysql_fetch_assoc($crews)); ?>
                                                        </table>
                </div>
                  <?php } // Show if recordset not empty ?>
</blockquote>              
              
              <?php if ($totalRows_crews == 0) { // Show if recordset empty ?>
                <p align="center">No records found</p>
                <?php } // Show if recordset empty ?>
<p align="center"><a href="add_crew.php">Add a Crew Member</a></p>
              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($crews);
?>
