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

$maxRows_calls = 25;
$pageNum_calls = 0;
if (isset($_GET['pageNum_calls'])) {
  $pageNum_calls = $_GET['pageNum_calls'];
}
$startRow_calls = $pageNum_calls * $maxRows_calls;

mysql_select_db($database_adhocConn, $adhocConn);
$query_calls = "SELECT logID, caseno, casename, logtime, caller, telno1, address, location FROM call_log WHERE calltype = 1 ORDER BY logtime DESC";
$query_limit_calls = sprintf("%s LIMIT %d, %d", $query_calls, $startRow_calls, $maxRows_calls);
$calls = mysql_query($query_limit_calls, $adhocConn) or die(mysql_error());
$row_calls = mysql_fetch_assoc($calls);

if (isset($_GET['totalRows_calls'])) {
  $totalRows_calls = $_GET['totalRows_calls'];
} else {
  $all_calls = mysql_query($query_calls);
  $totalRows_calls = mysql_num_rows($all_calls);
}
$totalPages_calls = ceil($totalRows_calls/$maxRows_calls)-1;

$queryString_calls = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_calls") == false && 
        stristr($param, "totalRows_calls") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_calls = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_calls = sprintf("&totalRows_calls=%d%s", $totalRows_calls, $queryString_calls);

if ($_COOKIE['MM_UserGroup'] < 5) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>

<?php require_once('inc_before.php'); ?>
              <p>Primary Calls              </p>
              <div align="center">
                <?php if ($totalRows_calls > 0) { // Show if recordset not empty ?>
                  <table border="1" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
                        <tr>
                          <td class="subtext">logID</td>
                          <td class="subtext">casename</td>
                          <td class="subtext">logtime</td>
                          <td class="subtext">caller</td>
                          <td class="subtext">telno1</td>
                          <td class="subtext">location</td>
                          <td class="subtext">&nbsp;</td>
                          <td class="subtext">&nbsp;</td>
                        </tr>
                        <?php do { ?>
                          <tr>
                            <td class="subtext"><?php echo $row_calls['logID']; ?></td>
                            <td class="subtext"><?php echo $row_calls['casename']; ?></td>
                            <td class="subtext"><?php echo date("d M Y H:i", $row_calls['logtime']); ?></td>
                            <td class="subtext"><?php echo $row_calls['caller']; ?></td>
                            <td class="subtext"><?php echo $row_calls['telno1']; ?></td>
                            <td class="subtext"><?php
								mysql_select_db($database_adhocConn, $adhocConn);
								$query_loc = sprintf("SELECT * FROM locations WHERE locationID = %s", $row_calls['location']);
								$loc = mysql_query($query_loc, $adhocConn) or die(mysql_error());
								$row_loc = mysql_fetch_assoc($loc);
								$totalRows_loc = mysql_num_rows($loc);
								echo $row_loc['location'];
								mysql_free_result($loc);
							?></td>
                            <td class="subtext"><a href="case_search.php?caseno=<?php echo $row_calls['logID']; ?>">view</a></td>
                            <td class="subtext"><a href="edit_case.php?caseno=<?php echo $row_calls['logID']; ?>">edit</a></td>
                          </tr>
                          <?php } while ($row_calls = mysql_fetch_assoc($calls)); ?>
                                                </table>
                  <table border="0">
                        <tr>
                          <td class="subtext"><?php if ($pageNum_calls > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_calls=%d%s", $currentPage, 0, $queryString_calls); ?>">First</a>
                              <?php } // Show if not first page ?>                      </td>
                          <td class="subtext"><?php if ($pageNum_calls > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_calls=%d%s", $currentPage, max(0, $pageNum_calls - 1), $queryString_calls); ?>">Previous</a>
                              <?php } // Show if not first page ?>                      </td>
                          <td class="subtext"><?php if ($pageNum_calls < $totalPages_calls) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_calls=%d%s", $currentPage, min($totalPages_calls, $pageNum_calls + 1), $queryString_calls); ?>">Next</a>
                              <?php } // Show if not last page ?>                      </td>
                          <td class="subtext"><?php if ($pageNum_calls < $totalPages_calls) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_calls=%d%s", $currentPage, $totalPages_calls, $queryString_calls); ?>">Last</a>
                              <?php } // Show if not last page ?>                      </td>
                        </tr>
                      </table>
                  <?php } // Show if recordset not empty ?>
                <?php if ($totalRows_calls == 0) { // Show if recordset empty ?>
                  <p>No records found</p>
                  <?php } // Show if recordset empty ?>
</div>
              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($calls);
?>
