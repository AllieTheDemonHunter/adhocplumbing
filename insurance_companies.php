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
$query_medaids = "SELECT * FROM med_aids ORDER BY aidname ASC";
$medaids = mysql_query($query_medaids, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_medaids = mysql_fetch_assoc($medaids);
$totalRows_medaids = mysql_num_rows($medaids);

if ($_COOKIE['MM_UserGroup'] < 5) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>

<?php require_once('inc_before.php'); ?>
              <p>Insurance Companies</p>
              <blockquote>
                <div align="center">
                  <?php if ($totalRows_medaids > 0) { // Show if recordset not empty ?>
                    <table border="1" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
                      <tr>
                        <td>ID</td>
                        <td>co name</td>
                        <td>plumbing co</td>
                        <td>despatch</td>
                        <td>&nbsp;</td>
                      </tr>
                      <?php do { ?>
                        <tr>
                          <td><?php echo $row_medaids['aidID']; ?></td>
                          <td><?php echo $row_medaids['aidname']; ?></td>
                          <td><?php echo $row_medaids['ambu_co']; ?></td>
                          <td><?php echo $row_medaids['despatch']; ?></td>
                          <td><a href="edit_ins_co.php?aidID=<?php echo $row_medaids['aidID']; ?>">edit</a></td>
                        </tr>
                        <?php } while ($row_medaids = mysql_fetch_assoc($medaids)); ?>
                    </table>
                    <?php } // Show if recordset not empty ?>
</div>
                
                <?php if ($totalRows_medaids == 0) { // Show if recordset empty ?>
                  <p align="center">No records found</p>
                  <?php } // Show if recordset empty ?>
<p align="center"><a href="add_ins_co.php">Add an Insurance Company</a></p>
              </blockquote>              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($medaids);
?>
