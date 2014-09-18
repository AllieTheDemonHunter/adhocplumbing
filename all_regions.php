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

$maxRows_regions = 50;
$pageNum_regions = 0;
if (isset($_GET['pageNum_regions'])) {
  $pageNum_regions = $_GET['pageNum_regions'];
}
$startRow_regions = $pageNum_regions * $maxRows_regions;

mysql_select_db($database_adhocConn, $adhocConn);
$query_regions = "SELECT * FROM regions WHERE region <> '' AND region is not null ORDER BY active DESC, provinceID ASC, region ASC";
$query_limit_regions = sprintf("%s LIMIT %d, %d", $query_regions, $startRow_regions, $maxRows_regions);
$regions = mysql_query($query_limit_regions, $adhocConn) or die(mysql_error());
$row_regions = mysql_fetch_assoc($regions);

if (isset($_GET['totalRows_regions'])) {
  $totalRows_regions = $_GET['totalRows_regions'];
} else {
  $all_regions = mysql_query($query_regions);
  $totalRows_regions = mysql_num_rows($all_regions);
}
$totalPages_regions = ceil($totalRows_regions/$maxRows_regions)-1;

$queryString_regions = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_regions") == false && 
        stristr($param, "totalRows_regions") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_regions = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_regions = sprintf("&totalRows_regions=%d%s", $totalRows_regions, $queryString_regions);
?>
<?php require_once('inc_before.php'); ?>
              <p>All Regions
</p>

              
              <?php if ($totalRows_regions > 0) { // Show if recordset not empty ?>
        <table border="1" align="center" cellpadding="3" cellspacing="0">
                  <tr>
                    <td class="smalltext">ID</td>
                    <td class="smalltext">region</td>
                    <td class="smalltext">prefix</td>
                    <td class="smalltext">province</td>
                    <td class="smalltext">active</td>
                  </tr>
                  <?php do { ?>
                    <tr>
                      <td class="smalltext"><?php echo $row_regions['regionID']; ?></td>
                      <td class="smalltext"><?php echo $row_regions['region']; ?></td>
                      <td class="smalltext"><?php echo $row_regions['prefix']; ?></td>
                      <td class="smalltext"><?php
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_prov = sprintf("SELECT * FROM provinces WHERE provinceID = %s", $row_regions['provinceID']);
							$prov = mysql_query($query_prov, $adhocConn) or die(mysql_error());
							$row_prov = mysql_fetch_assoc($prov);
							$totalRows_prov = mysql_num_rows($prov);
							echo $row_prov['province'];
					  ?></td>
                      <?php if ($row_regions['active'] == 1) { ?>
                          <td class="smalltext" bgcolor="#00FF00"><a href="deactivate_region.php?regionID=<?php echo $row_regions['regionID']; ?>">deactivate</a></td>
                      <?php } else { ?>
                          <td class="smalltext"><a href="activate_region.php?regionID=<?php echo $row_regions['regionID']; ?>">activate</a></td>
                      <?php } ?>
                          <td class="smalltext"><a href="view_suburbs.php?regionID=<?php echo $row_regions['regionID']; ?>">suburbs</a></td>
                          <td class="smalltext"><a href="edit_region.php?regionID=<?php echo $row_regions['regionID']; ?>">edit</a></td>
                    </tr>
                    <?php } while ($row_regions = mysql_fetch_assoc($regions)); ?>
                              </table>
              <table border="0" align="center">
                <tr>
                  <td><?php if ($pageNum_regions > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_regions=%d%s", $currentPage, 0, $queryString_regions); ?>">First</a>
                          <?php } // Show if not first page ?>                  </td>
                  <td><?php if ($pageNum_regions > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_regions=%d%s", $currentPage, max(0, $pageNum_regions - 1), $queryString_regions); ?>">Previous</a>
                          <?php } // Show if not first page ?>                  </td>
                  <td><?php if ($pageNum_regions < $totalPages_regions) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_regions=%d%s", $currentPage, min($totalPages_regions, $pageNum_regions + 1), $queryString_regions); ?>">Next</a>
                          <?php } // Show if not last page ?>                  </td>
                  <td><?php if ($pageNum_regions < $totalPages_regions) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_regions=%d%s", $currentPage, $totalPages_regions, $queryString_regions); ?>">Last</a>
                          <?php } // Show if not last page ?>                  </td>
                </tr>
              </table>
              <?php } // Show if recordset not empty ?>
              <?php if ($totalRows_regions == 0) { // Show if recordset empty ?>
              <p align="center">No records found</p>
                <?php } // Show if recordset empty ?>
<p align="center"><a href="add_region.php">Add a new region</a></p>
          <?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($regions);
?>
