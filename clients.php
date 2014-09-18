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

$maxRows_clients = 25;
$pageNum_clients = 0;
if (isset($_GET['pageNum_clients'])) {
  $pageNum_clients = $_GET['pageNum_clients'];
}
$startRow_clients = $pageNum_clients * $maxRows_clients;

mysql_select_db($database_adhocConn, $adhocConn);
$query_clients = "SELECT * FROM clients where cname is not null ORDER BY clientID DESC";
$query_limit_clients = sprintf("%s LIMIT %d, %d", $query_clients, $startRow_clients, $maxRows_clients);
$clients = mysql_query($query_limit_clients, $adhocConn) or die(mysql_error());
$row_clients = mysql_fetch_assoc($clients);

if (isset($_GET['totalRows_clients'])) {
  $totalRows_clients = $_GET['totalRows_clients'];
} else {
  $all_clients = mysql_query($query_clients);
  $totalRows_clients = mysql_num_rows($all_clients);
}
$totalPages_clients = ceil($totalRows_clients/$maxRows_clients)-1;

$queryString_clients = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_clients") == false && 
        stristr($param, "totalRows_clients") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_clients = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_clients = sprintf("&totalRows_clients=%d%s", $totalRows_clients, $queryString_clients);
?>
<?php require_once('inc_before.php'); ?>
&nbsp;Clients <br />
<br />
<table border="1" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td class="smalltext">ID</td>
    <td class="smalltext">client no</td>
    <td class="smalltext">name</td>
    <td class="smalltext">telno</td>
    <td class="smalltext">cemail</td>
    <td class="smalltext">category</td>
    <td class="smalltext">flagged</td>
    <td class="smalltext">&nbsp;</td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="smalltext"><?php echo $row_clients['clientID']; ?></td>
      <td class="smalltext"><?php echo $row_clients['clientno']; ?></td>
      <td class="smalltext"><?php echo $row_clients['cname']; ?> <?php echo $row_clients['surname']; ?></td>
      <td class="smalltext"><?php echo $row_clients['telno']; ?><br />
        <?php echo $row_clients['cellno']; ?><br />
          <?php echo $row_clients['faxno']; ?></td>
      <td class="smalltext"><a href="mailto:<?php echo $row_clients['cemail']; ?>"><?php echo $row_clients['cemail']; ?></a></td>
      <td class="smalltext"><?php
	  	if ($row_clients['category']) {
			mysql_select_db($database_adhocConn, $adhocConn);
			$query_category = sprintf("SELECT * FROM categories WHERE catID = %s", $row_clients['category']);
			$category = mysql_query($query_category, $adhocConn) or die(mysql_error());
			$row_category = mysql_fetch_assoc($category);
			$totalRows_category = mysql_num_rows($category);
			echo $row_category['category'];
			mysql_free_result($category);
		}
	  ?></td>
      <td class="smalltext" <?php if ($row_clients['flagged'] == 1) { ?>bgcolor="#FF0000"<?php } ?>><?php echo $row_clients['flagdetail']; ?></td>
      <td class="smalltext"><a href="edit_client.php?clientID=<?php echo $row_clients['clientID']; ?>">edit</a><br />
        <a href="history_client.php?clientID=<?php echo $row_clients['clientID']; ?>">history</a></td>
    </tr>
    <?php } while ($row_clients = mysql_fetch_assoc($clients)); ?>
</table>

<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_clients > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_clients=%d%s", $currentPage, 0, $queryString_clients); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_clients > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_clients=%d%s", $currentPage, max(0, $pageNum_clients - 1), $queryString_clients); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td><?php if ($pageNum_clients < $totalPages_clients) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_clients=%d%s", $currentPage, min($totalPages_clients, $pageNum_clients + 1), $queryString_clients); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td><?php if ($pageNum_clients < $totalPages_clients) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_clients=%d%s", $currentPage, $totalPages_clients, $queryString_clients); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($clients);
?>
