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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE categories SET category=%s WHERE catID=%s",
                       GetSQLValueString($_POST['category'], "text"),
                       GetSQLValueString($_POST['catID'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());

  $updateGoTo = "categories.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_edit_cat = "-1";
if (isset($_GET['catID'])) {
  $colname_edit_cat = $_GET['catID'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_edit_cat = sprintf("SELECT * FROM categories WHERE catID = %s", GetSQLValueString($colname_edit_cat, "int"));
$edit_cat = mysql_query($query_edit_cat, $adhocConn) or die(mysql_error());
$row_edit_cat = mysql_fetch_assoc($edit_cat);
$totalRows_edit_cat = mysql_num_rows($edit_cat);
?>
<?php require_once('inc_before.php'); ?>
&nbsp;Edit Category
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Category:</td>
      <td><input name="category" type="text" class="maintext" value="<?php echo htmlentities($row_edit_cat['category'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" class="maintext" value="Update Category" /></td>
    </tr>
  </table>
  <p align="center"><a href="categories.php">Back to Categories    </a></p>
  <p>
    <input type="hidden" name="MM_update" value="form1" />
    <input type="hidden" name="catID" value="<?php echo $row_edit_cat['catID']; ?>" />
    </p>
</form>
<p>&nbsp;</p>
<?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($edit_cat);
?>
