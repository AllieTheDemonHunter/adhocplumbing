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
$query_categories = "SELECT * FROM categories ORDER BY category ASC";
$categories = mysql_query($query_categories, $adhocConn) or die(mysql_error());
$row_categories = mysql_fetch_assoc($categories);
$totalRows_categories = mysql_num_rows($categories);
?>
<?php require_once('inc_before.php'); ?>
&nbsp;Categories <br />
<br />
<table border="1" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>ID</td>
    <td>category</td>
    <td>&nbsp;</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_categories['catID']; ?></td>
      <td><?php echo $row_categories['category']; ?></td>
      <td><a href="edit_category.php?catID=<?php echo $row_categories['catID']; ?>">edit</a></td>
    </tr>
    <?php } while ($row_categories = mysql_fetch_assoc($categories)); ?>
</table>
<p align="center"><a href="add_category.php">Add a Category</a></p>
<?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($categories);
?>
