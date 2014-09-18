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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_fuel = 20;
$pageNum_fuel = 0;
if (isset($_GET['pageNum_fuel'])) {
  $pageNum_fuel = $_GET['pageNum_fuel'];
}
$startRow_fuel = $pageNum_fuel * $maxRows_fuel;

mysql_select_db($database_adhocConn, $adhocConn);
$query_fuel = "SELECT * FROM fuelman ORDER BY `timestamp` DESC";
$query_limit_fuel = sprintf("%s LIMIT %d, %d", $query_fuel, $startRow_fuel, $maxRows_fuel);
$fuel = mysql_query($query_limit_fuel, $adhocConn) or die(mysql_error());
$row_fuel = mysql_fetch_assoc($fuel);

if (isset($_GET['totalRows_fuel'])) {
  $totalRows_fuel = $_GET['totalRows_fuel'];
} else {
  $all_fuel = mysql_query($query_fuel);
  $totalRows_fuel = mysql_num_rows($all_fuel);
}
$totalPages_fuel = ceil($totalRows_fuel/$maxRows_fuel)-1;

$queryString_fuel = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_fuel") == false && 
        stristr($param, "totalRows_fuel") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_fuel = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_fuel = sprintf("&totalRows_fuel=%d%s", $totalRows_fuel, $queryString_fuel);

if ($_COOKIE['MM_UserGroup'] < 5) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>

<?php require_once('inc_before.php'); ?>
              <p>Fleet Management</p>
              <p>View Fuel              </p>
              <div align="center">
                <?php if ($totalRows_fuel > 0) { // Show if recordset not empty ?>
                  <table border="1" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
                        <tr>
                          <td class="subtext">time</td>
                          <td class="subtext">ob no</td>
                          <td class="subtext">vehicle</td>
                          <td class="subtext">person</td>
                          <td class="subtext">km</td>
                          <td class="subtext">card no</td>
                          <td class="subtext">litres</td>
                          <td class="subtext">oil</td>
                          <td class="subtext">value</td>
                          <td class="subtext">&nbsp;</td>
                        </tr>
                        <?php do { ?>
                      <tr>
                        <td class="subtext"><?php echo date("d M Y H:i", $row_fuel['timestamp']); ?></td>
                        <td class="subtext"><?php echo $row_fuel['ob_no']; ?></td>
                        <td class="subtext"><?php echo $row_fuel['vehicleID']; ?></td>
                        <td class="subtext"><?php echo $row_fuel['person']; ?></td>
                        <td class="subtext"><?php echo $row_fuel['km']; ?></td>
                        <td class="subtext"><?php echo $row_fuel['card_no']; ?></td>
                        <td class="subtext"><?php echo $row_fuel['litres']; ?></td>
                        <td class="subtext"><?php echo $row_fuel['oil']; ?></td>
                        <td class="subtext"><?php echo $row_fuel['value']; ?></td>
                        <td class="subtext"><a href="edit_fuel.php?fuelID=<?php echo $row_fuel['fuelID']; ?>">edit</a></td>
                      </tr>
                      <?php } while ($row_fuel = mysql_fetch_assoc($fuel)); ?>
                                                </table>
                  <table border="0">
                        <tr>
                          <td><?php if ($pageNum_fuel > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_fuel=%d%s", $currentPage, 0, $queryString_fuel); ?>">First</a>
                              <?php } // Show if not first page ?>                      </td>
                          <td><?php if ($pageNum_fuel > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_fuel=%d%s", $currentPage, max(0, $pageNum_fuel - 1), $queryString_fuel); ?>">Previous</a>
                              <?php } // Show if not first page ?>                      </td>
                          <td><?php if ($pageNum_fuel < $totalPages_fuel) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_fuel=%d%s", $currentPage, min($totalPages_fuel, $pageNum_fuel + 1), $queryString_fuel); ?>">Next</a>
                              <?php } // Show if not last page ?>                      </td>
                          <td><?php if ($pageNum_fuel < $totalPages_fuel) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_fuel=%d%s", $currentPage, $totalPages_fuel, $queryString_fuel); ?>">Last</a>
                              <?php } // Show if not last page ?>                      </td>
                        </tr>
                                                </table>
                  <?php } // Show if recordset not empty ?>
</div>
              
              <?php if ($totalRows_fuel == 0) { // Show if recordset empty ?>
                <p align="center">No Records Found</p>
                <?php } // Show if recordset empty ?>
<p align="center"><a href="report_fleet_management.php">Back to Fleet Management</a></p>
              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($fuel);
?>
