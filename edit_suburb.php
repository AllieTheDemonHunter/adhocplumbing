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
  $updateSQL = sprintf("UPDATE suburbs SET suburb=%s, regionID=%s, subregion=%s WHERE suburbID=%s",
                       GetSQLValueString($_POST['suburb'], "text"),
                       GetSQLValueString($_POST['regionID'], "int"),
                       GetSQLValueString($_POST['subregion'], "int"),
                       GetSQLValueString($_POST['suburbID'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());

  $updateGoTo = "view_suburbs.php?regionID=" . $_POST['regionID'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_adhocConn, $adhocConn);
$query_regions = "SELECT * FROM regions ORDER BY region ASC";
$regions = mysql_query($query_regions, $adhocConn) or die(mysql_error());
$row_regions = mysql_fetch_assoc($regions);
$totalRows_regions = mysql_num_rows($regions);

$colname_suburb = "-1";
if (isset($_GET['suburbID'])) {
  $colname_suburb = $_GET['suburbID'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_suburb = sprintf("SELECT * FROM suburbs WHERE suburbID = %s", GetSQLValueString($colname_suburb, "int"));
$suburb = mysql_query($query_suburb, $adhocConn) or die(mysql_error());
$row_suburb = mysql_fetch_assoc($suburb);
$totalRows_suburb = mysql_num_rows($suburb);

mysql_select_db($database_adhocConn, $adhocConn);
$query_subregions = "SELECT * FROM subregions";
$subregions = mysql_query($query_subregions, $adhocConn) or die(mysql_error());
$row_subregions = mysql_fetch_assoc($subregions);
$totalRows_subregions = mysql_num_rows($subregions);
?>
<?php require_once('inc_before.php'); ?>
              <p>Edit Suburb              </p>
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                <table align="center">
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Suburb:</td>
                    <td><input name="suburb" type="text" class="maintext" value="<?php echo htmlentities($row_suburb['suburb'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Region:</td>
                    <td><select name="regionID" class="maintext">
                        <?php 
do {  
?>
                        <option value="<?php echo $row_regions['regionID']?>" <?php if (!(strcmp($row_regions['regionID'], htmlentities($row_suburb['regionID'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_regions['region']?></option>
                        <?php
} while ($row_regions = mysql_fetch_assoc($regions));
?>
                      </select>                    </td>
                  </tr>
                  <tr> </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Subregion:</td>
                    <td><select name="subregion" class="maintext" id="subregion">
                      <option value="-1" <?php if (!(strcmp(-1, $row_suburb['subregion']))) {echo "selected=\"selected\"";} ?>>please select...</option>
                      <?php
do {  
?>
                      <option value="<?php echo $row_subregions['subID']?>"<?php if (!(strcmp($row_subregions['subID'], $row_suburb['subregion']))) {echo "selected=\"selected\"";} ?>><?php echo $row_subregions['subregion']?></option>
                      <?php
} while ($row_subregions = mysql_fetch_assoc($subregions));
  $rows = mysql_num_rows($subregions);
  if($rows > 0) {
      mysql_data_seek($subregions, 0);
	  $row_subregions = mysql_fetch_assoc($subregions);
  }
?>
                    </select>
</td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td><input type="submit" class="maintext" value="Update" /></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_update" value="form1" />
                <input type="hidden" name="suburbID" value="<?php echo $row_suburb['suburbID']; ?>" />
              </form>
              <p align="center"><a href="view_suburbs.php?regionID=<?php echo $row_suburb['regionID']; ?>">Back to Suburbs</a></p>
              <p align="center"><a href="all_regions.php">Back to Regions</a></p>
          <?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($regions);

mysql_free_result($suburb);

mysql_free_result($subregions);
?>
