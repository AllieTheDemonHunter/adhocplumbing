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

$colname_suburbs = "-1";
if (isset($_GET['subID'])) {
  $colname_suburbs = $_GET['subID'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_suburbs = sprintf("SELECT * FROM suburbs WHERE subregion = %s ORDER BY suburb ASC", GetSQLValueString($colname_suburbs, "int"));
$suburbs = mysql_query($query_suburbs, $adhocConn) or die(mysql_error());
$row_suburbs = mysql_fetch_assoc($suburbs);
$totalRows_suburbs = mysql_num_rows($suburbs);
?>
<?php require_once('inc_before.php'); ?>
              <p>Subregion Suburbs&nbsp;</p>
              
              <?php if ($totalRows_suburbs > 0) { // Show if recordset not empty ?>
      <table border="1" align="center" cellpadding="3" cellspacing="0">
                  <tr>
                    <td>ID</td>
                    <td>suburb</td>
                    <td>region</td>
                    <td>subregion</td>
                    <td>&nbsp;</td>
                  </tr>
                  <?php do { ?>
                    <tr>
                      <td><?php echo $row_suburbs['suburbID']; ?></td>
                      <td><?php echo $row_suburbs['suburb']; ?></td>
                      <td><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_region = sprintf("SELECT * FROM regions WHERE regionID = %s", $row_suburbs['regionID']);
						$region = mysql_query($query_region, $adhocConn) or die(mysql_error());
						$row_region = mysql_fetch_assoc($region);
						$totalRows_region = mysql_num_rows($region);
						echo $row_region['region'];
						mysql_free_result($region);
					?></td>
                      <td><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_subreg = sprintf("SELECT * FROM subregions WHERE subID = %s", $row_suburbs['subregion']);
						$subreg = mysql_query($query_subreg, $adhocConn) or die(mysql_error());
						$row_subreg = mysql_fetch_assoc($subreg);
						$totalRows_subreg = mysql_num_rows($subreg);
						echo $row_subreg['subregion'];
						mysql_free_result($subreg);
					?></td>
                      <td><a href="edit_suburb.php?suburbID=<?php echo $row_suburbs['suburbID']; ?>">edit</a></td>
                    </tr>
                    <?php } while ($row_suburbs = mysql_fetch_assoc($suburbs)); ?>
                              </table>
              <?php } // Show if recordset not empty ?>
              <?php if ($totalRows_suburbs == 0) { // Show if recordset empty ?>
              <p align="center">No records found</p>
                <?php } // Show if recordset empty ?>
<p align="center"><a href="subregions.php">Back to Subregions</a></p>
          <?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($suburbs);
?>
