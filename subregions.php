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
$query_subregions = "SELECT * FROM subregions";
$subregions = mysql_query($query_subregions, $adhocConn) or die(mysql_error());
$row_subregions = mysql_fetch_assoc($subregions);
$totalRows_subregions = mysql_num_rows($subregions);
?>
<?php require_once('inc_before.php'); ?>
              <p>Subregions </p>
<table border="1" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>subID</td>
    <td>subregion</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_subregions['subID']; ?></td>
      <td><?php echo $row_subregions['subregion']; ?></td>
      <td><a href="view_subregion_suburbs.php?subID=<?php echo $row_subregions['subID']; ?>">view suburbs</a></td>
      <td><a href="edit_subregion.php?subID=<?php echo $row_subregions['subID']; ?>">edit</a></td>
    </tr>
    <?php } while ($row_subregions = mysql_fetch_assoc($subregions)); ?>
</table>
<p align="center"><a href="add_subregion.php">Add Subregion</a></p>
<?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($subregions);
?>
