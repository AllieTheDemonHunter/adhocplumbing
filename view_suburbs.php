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

$maxRows_suburbs = 50;
$pageNum_suburbs = 0;
if (isset($_GET['pageNum_suburbs'])) {
  $pageNum_suburbs = $_GET['pageNum_suburbs'];
}
$startRow_suburbs = $pageNum_suburbs * $maxRows_suburbs;

$colname_suburbs = "-1";
if (isset($_GET['regionID'])) {
  $colname_suburbs = $_GET['regionID'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_suburbs = sprintf("SELECT * FROM suburbs WHERE regionID = %s ORDER BY suburb ASC", GetSQLValueString($colname_suburbs, "int"));
$query_limit_suburbs = sprintf("%s LIMIT %d, %d", $query_suburbs, $startRow_suburbs, $maxRows_suburbs);
$suburbs = mysql_query($query_limit_suburbs, $adhocConn) or die(mysql_error());
$row_suburbs = mysql_fetch_assoc($suburbs);

if (isset($_GET['totalRows_suburbs'])) {
  $totalRows_suburbs = $_GET['totalRows_suburbs'];
} else {
  $all_suburbs = mysql_query($query_suburbs);
  $totalRows_suburbs = mysql_num_rows($all_suburbs);
}
$totalPages_suburbs = ceil($totalRows_suburbs/$maxRows_suburbs)-1;

$queryString_suburbs = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_suburbs") == false && 
        stristr($param, "totalRows_suburbs") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_suburbs = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_suburbs = sprintf("&totalRows_suburbs=%d%s", $totalRows_suburbs, $queryString_suburbs);
?>
<?php require_once('inc_before.php'); ?>
              <p>Suburbs</p>
              <div align="center">
                <?php if ($totalRows_suburbs > 0) { // Show if recordset not empty ?>
                <table border="1" cellpadding="3" cellspacing="0">
                  <tr>
                    <td class="smalltext">ID</td>
            <td class="smalltext">suburb</td>
            <td class="smalltext">region</td>
            <td class="smalltext">subregion</td>
            <td class="smalltext">&nbsp;</td>
        </tr>
                  <?php do { ?>
                    <tr>
                      <td class="smalltext"><?php echo $row_suburbs['suburbID']; ?></td>
                      <td class="smalltext"><?php echo $row_suburbs['suburb']; ?></td>
                      <td class="smalltext"><?php 
				mysql_select_db($database_adhocConn, $adhocConn);
				$query_rname = sprintf("SELECT * FROM regions WHERE regionID = %s", $row_suburbs['regionID']);
				$rname = mysql_query($query_rname, $adhocConn) or die(mysql_error());
				$row_rname = mysql_fetch_assoc($rname);
				$totalRows_rname = mysql_num_rows($rname);
				echo $row_rname['region'];
				mysql_free_result($rname);
		  ?></td>
                      <td class="smalltext"><?php
					  	if ($row_suburbs['subregion']) {
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_subreg = sprintf("SELECT * FROM subregions WHERE subID = %s", $row_suburbs['subregion']);
							$subreg = mysql_query($query_subreg, $adhocConn) or die(mysql_error());
							$row_subreg = mysql_fetch_assoc($subreg);
							$totalRows_subreg = mysql_num_rows($subreg);
							echo $row_subreg['subregion'];
						}
					  ?></td>
                      <td class="smalltext"><a href="edit_suburb.php?suburbID=<?php echo $row_suburbs['suburbID']; ?>">edit</a></td>
                    </tr>
                    <?php } while ($row_suburbs = mysql_fetch_assoc($suburbs)); ?>
                              </table>
                <table border="0">
                  <tr>
                    <td><?php if ($pageNum_suburbs > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_suburbs=%d%s", $currentPage, 0, $queryString_suburbs); ?>">First</a>
                        <?php } // Show if not first page ?>        </td>
                    <td><?php if ($pageNum_suburbs > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_suburbs=%d%s", $currentPage, max(0, $pageNum_suburbs - 1), $queryString_suburbs); ?>">Previous</a>
                        <?php } // Show if not first page ?>          </td>
                    <td><?php if ($pageNum_suburbs < $totalPages_suburbs) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_suburbs=%d%s", $currentPage, min($totalPages_suburbs, $pageNum_suburbs + 1), $queryString_suburbs); ?>">Next</a>
                        <?php } // Show if not last page ?>          </td>
                    <td><?php if ($pageNum_suburbs < $totalPages_suburbs) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_suburbs=%d%s", $currentPage, $totalPages_suburbs, $queryString_suburbs); ?>">Last</a>
                        <?php } // Show if not last page ?>          </td>
                  </tr>
                </table>
                <?php } // Show if recordset not empty ?>
                <?php if ($totalRows_suburbs == 0) { // Show if recordset empty ?>
    <p>No records found</p>
    <?php } // Show if recordset empty ?>
<p><a href="add_suburb.php?regionID=<?php echo $_GET['regionID']; ?>">Add a Suburb</a></p>
              <p><a href="all_regions.php">Back to Regions</a></p>
              </div>
              <?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($suburbs);
?>
