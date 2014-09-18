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
  $updateSQL = sprintf("UPDATE subregions SET subregion=%s WHERE subID=%s",
                       GetSQLValueString($_POST['subregion'], "text"),
                       GetSQLValueString($_POST['subID'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());

  $updateGoTo = "subregions.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_subregion = "-1";
if (isset($_GET['subID'])) {
  $colname_subregion = $_GET['subID'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_subregion = sprintf("SELECT * FROM subregions WHERE subID = %s", GetSQLValueString($colname_subregion, "int"));
$subregion = mysql_query($query_subregion, $adhocConn) or die(mysql_error());
$row_subregion = mysql_fetch_assoc($subregion);
$totalRows_subregion = mysql_num_rows($subregion);
?>
<?php require_once('inc_before.php'); ?>
              <p>Edit Subregion</p>
              <p>&nbsp; </p>
              
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                <table align="center">
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Subregion:</td>
                    <td><input name="subregion" type="text" class="maintext" value="<?php echo htmlentities($row_subregion['subregion'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td><input type="submit" class="maintext" value="Update record" /></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_update" value="form1" />
                <input type="hidden" name="subID" value="<?php echo $row_subregion['subID']; ?>" />
              </form>
              <p>&nbsp;</p>
              <div align="center"><a href="subregions.php">Back to Subregions</a>              </div>
          <?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($subregion);
?>
